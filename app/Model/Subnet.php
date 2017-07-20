<?php
App::uses('AppModel', 'Model');
/**
 * Subnet Model
 *
 */
class Subnet extends AppModel 
{

	
	public $displayField = 'cidr';

	
	public $validate = array(
		'cidr' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $hasMany = array(
		'SubnetMember' => array(
			'className' => 'SubnetMember',
			'foreignKey' => 'subnet_id',
			'dependent' => true,
		),
	);
	
	public $actsAs = array(
		'Batcher.Batcher' => array(
			'fieldMap' => array(
				'Subnet.name' => array('label' => 'Name'),
				'Subnet.cidr' => array('label' => 'CIDR'),
				'Subnet.ic' => array('label' => 'IC'),
				'Subnet.location' => array('label' => 'Location'), 
				'Subnet.comments' => array('label' => 'Comments'),
				'Subnet.dhcp' => array('label' => 'DHCP', 'type' => 'match', 
					'default' => 0,
					'options' => array(
						'unknown' => 0,
						'yes' => 1,
						'no' => 2,
					)),
				'Subnet.dhcp_scope' => array('label' => 'DHCP Scope'),
			),
		),
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
			),
		),
	);
	
	
	// define the fields that can be searched
	public $searchFields = array(
		'Subnet.name',
		'Subnet.cidr',
		'Subnet.netmask',
		'Subnet.ic',
		'Subnet.location',
		'Subnet.comments', 
		'Subnet.dhcp_scope',
	);
	
	public $currentRecord = array();
	public $newRecord = array();
	
	public $CommonNetwork = false;
	
	public function beforeSave($options = array()) 
	{
		// if cidr is supplied, but the netmask, ip_start, or ip_end aren't, figure them out
		if(isset($this->data[$this->alias]['cidr']))
		{
			$this->data[$this->alias]['subnet_check'] = $this->alias.'.cidr';
			$this->data = $this->calcNetwork($this->data);
		}
		
		// see if we're updating a subnet. if so, get the current record from the db
		if(isset($this->id))
		{
			$this->newRecord = $this->data;
			$this->currentRecord = $this->read(null, $this->id);
			$this->data = $this->newRecord;
		}
		
		return parent::beforeSave($options);
	}
	
	public function afterSave($created = false, $options = array())
	{
		$rescan = false; // if we should rescan other objects that have ip addresses
		if($created)
		{
			$rescan = true;
		}
		else
		{
			/// see if any of the ip address related fields changed
			if(isset($this->currentRecord[$this->alias]['cidr']) and isset($this->newRecord[$this->alias]['cidr']))
				if($this->currentRecord[$this->alias]['cidr'] != $this->newRecord[$this->alias]['cidr'])
					$rescan = true;
			if(isset($this->currentRecord[$this->alias]['ip_start']) and isset($this->newRecord[$this->alias]['ip_start']))
				if($this->currentRecord[$this->alias]['ip_start'] != $this->newRecord[$this->alias]['ip_start'])
					$rescan = true;
			if(isset($this->currentRecord[$this->alias]['ip_end']) and isset($this->newRecord[$this->alias]['ip_end']))
				if($this->currentRecord[$this->alias]['ip_end'] != $this->newRecord[$this->alias]['ip_end'])
					$rescan = true;
			if(isset($this->currentRecord[$this->alias]['netmask']) and isset($this->newRecord[$this->alias]['netmask']))
				if($this->currentRecord[$this->alias]['netmask'] != $this->newRecord[$this->alias]['netmask'])
					$rescan = true;
		}
		
		if($rescan)
		{
			$this->rescan($this->id);
		}
		
		return parent::afterSave($created, $options);
	}
	
	public function rescan($id = false)
	{
		$this->SubnetMember->shell_input = (isset($this->shell_input)?$this->shell_input:false);
		$this->SubnetMember->fismaInventoriesToSubnet($id);
		$this->SubnetMember->penTestResultsToSubnet($id);
		$this->SubnetMember->eolResultsToSubnet($id);
		$this->SubnetMember->highRiskResultsToSubnet($id);
		$this->SubnetMember->usResultsToSubnet($id);
	}
	
	public function rescanAll()
	{
		Configure::write('debug', 0);
		$subnets = $this->find('list', array(
			'fields' => array($this->alias.'.id', $this->alias.'.cidr'),
		));
		
		$this->shell_nolog = true;
		foreach($subnets as $subnet_id => $cidr)
		{
			$subnet_id.' - '.$cidr. "\n";
			$this->rescan($subnet_id);
		}
	}
	
	public function calcNetwork($data = array())
	{
		if(!isset($data[$this->alias]))
		{
			$this->modelError = __('Unknown Fields');
			return $data;
		}
		
		// make it dot notation
		$out = array();
		foreach($data[$this->alias] as $name => $value)
		{
			$out[$this->alias.'.'.$name] = $value;
		}
		$data = $out;
		
		if(!isset($data[$this->alias.'.subnet_check']))
		{
			$this->modelError = __('Unknown Field to Check.');
			return false;
		}
		
		$this_field = $data[$this->alias.'.subnet_check'];
		if(!isset($data[$this_field]))
		{
			$this->modelError = __('No data to check');
			return Hash::expand($data);
		}
		
		unset($data[$this->alias.'.subnet_check']);
		
		$this_field_data = trim($data[$this_field]);
		if(!$this_field_data)
		{
			$this->modelError = __('No data in checked field');
			return Hash::expand($data);
		}

		$this->loadCommonNetwork();
		
		switch ($this_field) 
		{
			case $this->alias.'.cidr':
				$data[$this->alias.'.netmask'] = $this->CommonNetwork->cidrToNetmask($data[$this->alias.'.cidr']);
				list($data[$this->alias.'.ip_start'], $data[$this->alias.'.ip_end']) = $this->CommonNetwork->cidrToRange($data[$this->alias.'.cidr']);
				
				break;
			case $this->alias.'.netmask':
				list($network, $cidr) = explode('/', $data[$this->alias.'.cidr']);
				$cidr = $this->CommonNetwork->netmaskToCidr($data[$this->alias.'.netmask']);
				$data[$this->alias.'.cidr'] = $network.'/'.$cidr;
				list($data[$this->alias.'.ip_start'], $data[$this->alias.'.ip_end']) = $this->CommonNetwork->cidrToRange($data[$this->alias.'.cidr']);
		}
		
		if(isset($data[$this->alias.'.ip_start']))
		{
			$this->loadCommonNetwork();
			$data[$this->alias.'.ip_start_long'] = $this->CommonNetwork->convertIpToLong($data[$this->alias.'.ip_start']);
		}
		
		if(isset($data[$this->alias.'.ip_end']))
		{
			$this->loadCommonNetwork();
			$data[$this->alias.'.ip_end_long'] = $this->CommonNetwork->convertIpToLong($data[$this->alias.'.ip_end']);
		}
		
		return Hash::expand($data);
	}
	
	public function ipArray($id = false)
	{
		$this->id = $id;
		$cidr = $this->field('cidr');
		
		if(!$cidr)	
			return false;
		
		$this->loadCommonNetwork();
		return $this->CommonNetwork->cidrToIpArray($cidr);
	}
	
	public function loadCommonNetwork()
	{
		if(!$this->CommonNetwork)
		{
			App::uses('CommonNetwork', 'Utilities.Lib');
			$this->CommonNetwork = new CommonNetwork();
		}
	}
}
