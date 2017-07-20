<?php
App::uses('AppModel', 'Model');
/**
 * Firewall Model
 *
 * @property Rule $Rule
 */
class HostAlias extends AppModel 
{

	public $displayField = 'alias';

	public $validate = array(
		'alias' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'ip_address' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'slug' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
			),
		),
	);
	
	public $belongsTo = array(
		'Import' => array(
			'className' => 'Import',
			'foreignKey' => 'import_id',
		),
		'Firewall' => array(
			'className' => 'Firewall',
			'foreignKey' => 'firewall_id',
		),
		'Host' => array(
			'className' => 'Host',
			'foreignKey' => 'host_id',
		),
		'HostAliasAddedUser' => array(
			'className' => 'HostAlias',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
	);
	
	public $actsAs = array(
		'Utilities.FwConfigParser', 
		'Utilities.Nslookup', 
		'Utilities.Extractor', 
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'HostAlias.ip_address',
		'HostAlias.alias',
	);
	
	public function IpLookup($host = false, $add_data = array(), $type = false, $bypass_lookup = false)
	{
		if(!$type)
			$type = $this->EX_discoverType($host);
		
		$fields = array();
		$conditions = array();
		if($type == 'ipaddress')
		{
			if(!$bypass_lookup)
			{
				// lookup the ip first
				$results = $this->NS_localLookup($host, 'ip');
				
				if($results)
				{
					$hosts = array();
					foreach($results as $alias => $details)
					{
						$slug = $this->FCP_slugify($alias);
						$add_data = array_merge($add_data, array(
							'slug' => $slug,
							'ip_address' => $host,
							'alias' => $alias,
						));
						
						$host_alias_id = $this->slugCheckAdd($slug, $add_data);
					}
				}
			}
			$fields = array('alias');
			$conditions = array(
				'ip_address' => $host,
			);
		}
		else
		{
			$fields = array('ip_address');
			$conditions = array(
				'alias' => $host,
			);
		}
	
		$aliases = $this->find('list', array(
			'fields' => $fields,
			'conditions' => $conditions,
		));
		
		return $aliases;
	}
	
	public function checkAdd($ip_address = false, $alias = false)
	{
		if(!$ip_address) return false;
		if(!$alias) return false;
		
		$slug = $this->FCP_slugify($alias);
		$add_data = array(
			'slug' => $slug,
			'ip_address' => $ip_address,
			'alias' => $alias,
		);
		
		return $this->slugCheckAdd($slug, $add_data);
	}
}
