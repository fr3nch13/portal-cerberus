<?php
App::uses('AppModel', 'Model');
/**
 * Fog Model
 *
 * @property Rule $Rule
 */
class Fog extends AppModel 
{

	public $displayField = 'name';

	public $validate = array(
		'name' => array(
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
	);
	
	public $hasMany = array(
		'SrcRule' => array(
			'className' => 'Rule',
			'foreignKey' => 'src_fog_id',
			'dependent' => false,
		),
		'DstRule' => array(
			'className' => 'Rule',
			'foreignKey' => 'dst_fog_id',
			'dependent' => false,
		),
		'FogsChild' => array(
			'className' => 'FogsFog',
			'foreignKey' => 'parent_id',
			'dependent' => false,
		),
		'FogsParent' => array(
			'className' => 'FogsFog',
			'foreignKey' => 'child_id',
			'dependent' => false,
		),
		'FogLog' => array(
			'className' => 'FogLog',
			'foreignKey' => 'fog_id',
			'dependent' => true,
		),
	);
	
	public $actsAs = array(
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
			),
		),
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('simple');
	
	// define the fields that can be searched
	public $searchFields = array(
		'Fog.name',
		'Fog.ip_addresses',
	);
	
	public $FogLog_data = array();
	public $newData = array();
	
	public $compile = false;
	public $compiles = array();
	
	public function beforeSave($options = array()) 
	{
		// fix the ip_addresses
		if(isset($this->data[$this->alias]['ip_addresses']))
		{
			$this->data[$this->alias]['ip_addresses'] = trim($this->data[$this->alias]['ip_addresses']);
			$this->data[$this->alias]['ip_addresses'] = preg_split('/(\n|,)+/', $this->data[$this->alias]['ip_addresses']);
			foreach($this->data[$this->alias]['ip_addresses'] as $i => $ip_address)
			{
				$ip_address = trim($ip_address);
				if(!$ip_address)
				{
					unset($this->data[$this->alias]['ip_addresses'][$i]);
				}
				else
				{
					$this->data[$this->alias]['ip_addresses'][$i] = $ip_address;
				}
			}
			$this->data[$this->alias]['ip_addresses'] = implode("\n", $this->data[$this->alias]['ip_addresses']);
		}
		
/*
		// fix the name if needed
		if(isset($this->data[$this->alias]['name']))
		{
//			$this->data[$this->alias]['name'] = preg_replace("/[^a-z0-9+\_\-\.]/i", "_", $this->data[$this->alias]['name'] );
//			$this->data[$this->alias]['name'] = preg_replace("/\s+/i", "_", $this->data[$this->alias]['name'] );
		}
*/
	
		// reset the array
		$this->FogLog_data = array(
			'old_name' => '',
			'old_ip_addresses' => '',
			'name' => (isset($this->data['Fog']['name'])?$this->data['Fog']['name']:false),
			'ip_addresses' => (isset($this->data['Fog']['ip_addresses'])?$this->data['Fog']['ip_addresses']:false),
		);	
		
		if(isset($this->data['Fog']['id']))
		{
			$this->newData = $this->data;
			
			$this->recursive = -1;
			$fog = $this->read(null, $this->data['Fog']['id']);
			
			$this->FogLog_data['old_name'] = $fog['Fog']['name'];
			$this->FogLog_data['old_ip_addresses'] = $fog['Fog']['ip_addresses'];
			
			$this->data = $this->newData;
		}
		
		$user_id = 0;
		if(isset($this->data['Fog']['modified_user_id']))
		{
			$this->FogLog_data['user_id'] = $this->data['Fog']['modified_user_id'];
			$this->data['Fog']['modified'] = date('Y-m-d H:i:s');
		}
		elseif(isset($this->data['Fog']['added_user_id']))
		{
			$this->FogLog_data['user_id'] = $this->data['Fog']['added_user_id'];
			$this->data['Fog']['modified'] = false;
			$this->data['Fog']['created'] = date('Y-m-d H:i:s');
		}
		
		if(isset($this->data['FogLog']))
		{
			$this->FogLog_data = $this->mergeSettings($this->FogLog_data, $this->data['FogLog']);
			unset($this->data['FogLog']);
		}
		
		return parent::beforeSave($options);
	}
	
	public function afterSave($created = false, $options = array())
	{
		if($this->id)
		{
			$this->FogLog_data['fog_id'] = $this->id;
			
			$this->FogLog->create();
			$this->FogLog->data = $this->FogLog_data;
			$this->FogLog->save($this->FogLog->data, ['validate' => false]);
			
			$this->FogLog_data = array();
		}
		return parent::afterSave($created, $options);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		foreach ($results as $key => $val) 
		{
			if (isset($val[$this->alias]['ip_addresses'])) 
			{
				$val[$this->alias]['ip_addresses'] = trim($val[$this->alias]['ip_addresses']);
				$val[$this->alias]['ip_addresses'] = preg_split('/(\n|,)+/', $val[$this->alias]['ip_addresses']);
				foreach($val[$this->alias]['ip_addresses'] as $i => $ip_address)
				{
					$ip_address = trim($ip_address);
					if(!$ip_address)
					{
						unset($val[$this->alias]['ip_addresses'][$i]);
					}
					else
					{
						$val[$this->alias]['ip_addresses'][$i] = $ip_address;
					}
				}
				$val[$this->alias]['ip_addresses'] = implode("\n", $val[$this->alias]['ip_addresses']);
				$results[$key][$this->alias]['ip_addresses'] = $val[$this->alias]['ip_addresses'];
			}
			
/*
			// fix the name if needed
			if(isset($this->data[$this->alias]['name']))
			{
//				$this->data[$this->alias]['name'] = preg_replace("/[^a-z0-9\_\-+]/i", "_", $this->data[$this->alias]['name'] );
				$this->data[$this->alias]['name'] = preg_replace("/\s+/i", "_", $this->data[$this->alias]['name'] );
			}
*/
			
			if($this->compile and isset($val[$this->alias]['id']) and $val[$this->alias]['id'])
			{
				$id = $val[$this->alias]['id'];
				if(isset($compiles[$id]))
				{
					$results[$key][$this->alias]['compiled'] = $compiles[$id];
				}
				else
				{
					$compiled = array(
						__('object-group network %s', $val[$this->alias]['name']),
					);
					if(isset($val[$this->alias]['description']) and trim($val[$this->alias]['description']))
					{
						$compiled[] = __('	description %s', $val[$this->alias]['description']);
					}
					
					if (isset($results[$key][$this->alias]['ip_addresses'])) 
					{
						$ipaddresses = explode("\n", $results[$key][$this->alias]['ip_addresses']);
						
						foreach($ipaddresses as $ipaddress)
						{
							$ipaddress = trim($ipaddress);
							// has mask
							if(preg_match('/\s+/', $ipaddress))
							{
								$compiled[] = __('	network-object %s', $ipaddress);
							}
							else
							{
								$compiled[] = __('	network-object host %s', $ipaddress);
							}
						}
					}
					
					$results[$key][$this->alias]['compiled'] = $compiles[$id] = implode("\n", $compiled);
				}
			}
		}
		
		return parent::afterFind($results, $primary);
	}
	
	public function findAllSlugAsKey($query = array())
	{
		$results = parent::find('all', $query);
		
		if(!$results)
		{
			return array();
		}
		
		$out = array();
		foreach($results as $result)
		{
			if(!isset($result[$this->alias]['slug'])) continue;
			
			$slug = $result[$this->alias]['slug'];
			
			if(isset($out[$slug])) continue;
			
			$hosts = array();
			if(isset($result[$this->alias]['ip_addresses']))
			{
				$ip_addresses = explode("\n", $result[$this->alias]['ip_addresses']);
				foreach($ip_addresses as $ip_address)
				{
					$hosts[$ip_address] = $ip_address;
				}
			}
			
			$out[$slug] = array(
				'name' => (isset($result[$this->alias]['name'])?$result[$this->alias]['name']:$slug),
				'slug' => $slug,
				'hosts' => $hosts,
			);
		}
		
		return $out;
	}
}
