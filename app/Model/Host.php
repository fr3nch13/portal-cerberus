<?php
App::uses('AppModel', 'Model');

class Host extends AppModel 
{
	public $displayField = 'name';

	public $validate = array(
		'ip_address' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $hasOne = array(
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'host_id',
			'dependent' => false,
		),
	);
	
	public $hasMany = array(
		'HostLog' => array(
			'className' => 'HostLog',
			'foreignKey' => 'host_id',
			'dependent' => false,
		),
		'HostAlias' => array(
			'className' => 'HostAlias',
			'foreignKey' => 'host_id',
			'dependent' => false,
		),
		'PenTestResultLog' => array(
			'className' => 'PenTestResultLog',
			'foreignKey' => 'host_id',
			'dependent' => false,
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'host_id',
			'dependent' => false,
		),
		'SubnetMember' => array(
			'className' => 'SubnetMember',
			'foreignKey' => 'host_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'Fog' => array(
			'className' => 'Fog',
			'joinTable' => 'hosts_fogs',
			'foreignKey' => 'host_id',
			'associationForeignKey' => 'fog_id',
			'unique' => 'keepExisting',
		)
	);
	
	public $actsAs = array(
		'Utilities.Extractor', 
	);
	
	public $sessionCache = array();
	
	public $oldRecord = array();
	public $newRecord = array();
	
	public function beforeFind($query = array())
	{
		return parent::beforeFind($query);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		// means we include the subnet and fisma inventroy for the host
		if($this->recursive > 0 and isset($results[0][$this->alias]))
		{	
			foreach($results as $i => $result)
			{
				// include the subnets
				$subnet_member = $this->SubnetMember->find('all', array(
					'conditions' => array('SubnetMember.host_id' => $result[$this->alias]['id']),
					'contain' => array('Subnet', 'FismaInventory'),
					'recursive' => 0,
				));	
				$results[$i][$this->alias] = $results[$i][$this->alias]+array('SubnetMember' => $subnet_member);
			}
		}
		return parent::afterFind($results, $primary);
	}
	
	
	public function beforeSave($options = array()) 
	{
		// see if we're updating this inventory. if so, get the current record from the db
		if(isset($this->id))
		{
			$this->newRecord = $this->data;
			$this->oldRecord = $this->read(null, $this->id);
			$this->data = $this->newRecord;
		}
	}
	
	public function afterSave($created = false, $options = array())
	{
		/// log any changes
		$this->HostLog->logChanges($this->id, $this->oldRecord);
		
		$rescan = true; // if the ip address is changed, recheck the subnets
		if($created)
		{
			$rescan = true;
		}
		else
		{
			/// see if the ip address changed
			if(isset($this->oldRecord[$this->alias]['ip_address']) and isset($this->newRecord[$this->alias]['ip_address']))
				if($this->oldRecord[$this->alias]['ip_address'] != $this->newRecord[$this->alias]['ip_address'])
					$rescan = true;
		}
		if($rescan)
		{
			$this->SubnetMember->subnetsToHost($this->id);
		}
		return parent::afterSave($created, $options);
	}
	
	public function checkAddUpdate($ip_address = false, $hostname = false, $extra = array())
	{
		$ip_address = trim($ip_address);
		$hostname = trim($hostname);
		$hostname = trim($hostname, '.');
		
		if(!isset($extra['name']) and $hostname)
			$extra['name'] = $hostname;
		
		/// check that we actually have an ip address
		if($this->EX_discoverType($ip_address) != 'ipaddress')
			$ip_address = false;
		
		/// check that we actually have a host name
		if($this->EX_discoverType($hostname) != 'hostname')
		{
			// if not, than it is a common name/description
			$hostname = false;
		}
		
		if(!$ip_address and !$hostname) return false;
		
		$validate = true;
		if(isset($extra['validate']))
		{
			$validate = $extra['validate'];
			unset($extra['validate']);
		}
		
		$conditions = array();
		
		if($ip_address and $hostname)
		{
			$conditions['OR'] = array(
				'ip_address' => $ip_address,
				'hostname' => $hostname,
			);
		}
		elseif($ip_address)
		{
			$conditions['ip_address'] = $ip_address;
		}
		else
		{
			$conditions['hostname'] = $hostname;
		}
		
///// add session caching here eventually. using: $this->sessionCache
		
		if(!$host = $this->find('first', array('conditions' => $conditions)))
		{
			// not an existing one, create it
			$this->create();
			$this->data = array_merge(array('ip_address' => $ip_address, 'hostname' => $hostname), $extra);
			if($this->save($this->data, $validate))
			{
				return $this->id;
			}
			return false;
		}
		$this->id = $host[$this->alias]['id'];
		
		/// see if we need to update the record
		$update = array();
		// check the ip address
		if($ip_address)
		{
			if($ip_address != $host[$this->alias]['ip_address'])
				$update['ip_address'] = $ip_address;	
		}
		// check the ip address
		if($hostname)
		{
			if($hostname != $host[$this->alias]['hostname'])
				$update['hostname'] = $hostname;	
		}
		
		// check the extras
		if($extra)
		{
			foreach($extra as $ex_field => $ex_value)
			{
				if($ex_value != $host[$this->alias][$ex_field])
					$update[$ex_field] = $ex_value;
			}
		}
		
		if($update)
		{
			$this->data = array_merge($update, $extra);
			$this->save($this->data);
		}
		return $this->id;
	}

}
