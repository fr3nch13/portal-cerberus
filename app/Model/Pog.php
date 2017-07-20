<?php
App::uses('AppModel', 'Model');
/**
 * Pog Model
 *
 * @property Rule $Rule
 */
class Pog extends AppModel 
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
		'Protocol' => array(
			'className' => 'Protocol',
			'foreignKey' => 'protocol_id',
			'dependent' => false,
		),
	);
	
	public $hasMany = array(
		'SrcRule' => array(
			'className' => 'Rule',
			'foreignKey' => 'src_pog_id',
			'dependent' => false,
		),
		'DstRule' => array(
			'className' => 'Rule',
			'foreignKey' => 'dst_pog_id',
			'dependent' => false,
		),
		'PogsChild' => array(
			'className' => 'PogsPog',
			'foreignKey' => 'parent_id',
			'dependent' => false,
		),
		'PogsParent' => array(
			'className' => 'PogsPog',
			'foreignKey' => 'child_id',
			'dependent' => false,
		),
		'PogLog' => array(
			'className' => 'PogLog',
			'foreignKey' => 'pog_id',
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
		'Pog.name',
		'Pog.ports',
	);
	
	public $PogLog_data = array();
	public $newData = array();
	
	public $compile = false;
	public $compiles = array();
	public $protocols = array();
	
	public function beforeSave($options = array()) 
	{
		// fix the ports
		if(isset($this->data[$this->alias]['ports']))
		{
			$this->data[$this->alias]['ports'] = trim($this->data[$this->alias]['ports']);
			$this->data[$this->alias]['ports'] = preg_split('/(\n|,)+/', $this->data[$this->alias]['ports']);
			foreach($this->data[$this->alias]['ports'] as $i => $port)
			{
				$port = trim($port);
				if(!$port)
				{
					unset($this->data[$this->alias]['ports'][$i]);
				}
				else
				{
					$this->data[$this->alias]['ports'][$i] = $port;
				}
			}
			$this->data[$this->alias]['ports'] = implode("\n", $this->data[$this->alias]['ports']);
		}
		
/*
		// fix the name if needed
		if(isset($this->data[$this->alias]['name']))
		{
//			$this->data[$this->alias]['name'] = preg_replace("/[^a-z0-9+\_\-]/i", "_", $this->data[$this->alias]['name'] );
//			$this->data[$this->alias]['name'] = preg_replace("/\s+/i", "_", $this->data[$this->alias]['name'] );
		}
*/
		
		// reset the array
		$this->PogLog_data = array(
			'old_name' => '',
			'old_ports' => '',
			'name' => (isset($this->data['Pog']['name'])?$this->data['Pog']['name']:false),
			'ports' => (isset($this->data['Pog']['ports'])?$this->data['Pog']['ports']:false),
		);
		
		if(isset($this->data['Pog']['id']))
		{
			$this->newData = $this->data;
			
			$this->recursive = -1;
			$pog = $this->read(null, $this->data['Pog']['id']);
			
			$this->PogLog_data['old_name'] = $pog['Pog']['name'];
			$this->PogLog_data['old_ports'] = $pog['Pog']['ports'];
			
			$this->data = $this->newData;
		}
		
		$user_id = 0;
		if(isset($this->data['Pog']['modified_user_id']))
		{
			$this->PogLog_data['user_id'] = $this->data['Pog']['modified_user_id'];
			$this->data['Pog']['modified'] = date('Y-m-d H:i:s');
		}
		elseif(isset($this->data['Pog']['added_user_id']))
		{
			$this->PogLog_data['user_id'] = $this->data['Pog']['added_user_id'];
			$this->data['Pog']['modified'] = false;
			$this->data['Pog']['created'] = date('Y-m-d H:i:s');
		}
		
		if(isset($this->data['PogLog']))
		{
			$this->PogLog_data = $this->mergeSettings($this->PogLog_data, $this->data['PogLog']);
			unset($this->data['PogLog']);
		}
		
		return parent::beforeSave($options);
	}
	
	public function afterSave($created = false, $options = array())
	{
		if($this->id)
		{
			$this->PogLog_data['pog_id'] = $this->id;
			
			$this->PogLog->create();
			$this->PogLog->data = $this->PogLog_data;
			$this->PogLog->save($this->PogLog->data);
			
			$this->PogLog_data = array();
		}
		return parent::afterSave($created, $options);
	}
	
	public function beforeFind($query = array())
	{
		return parent::beforeFind($query);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		foreach ($results as $key => $val) 
		{
			if (isset($val[$this->alias]['ports'])) 
			{
				$val[$this->alias]['ports'] = trim($val[$this->alias]['ports']);
				$val[$this->alias]['ports'] = preg_split('/(\n|,)+/', $val[$this->alias]['ports']);
				foreach($val[$this->alias]['ports'] as $i => $port)
				{
					$port = trim($port);
					if(!$port)
					{
						unset($val[$this->alias]['ports'][$i]);
					}
					else
					{
						$val[$this->alias]['ports'][$i] = $port;
					}
				}
				$val[$this->alias]['ports'] = implode("\n", $val[$this->alias]['ports']);
				$results[$key][$this->alias]['ports'] = $val[$this->alias]['ports'];
			}
		
			// fix the name if needed
/*
			if(isset($this->data[$this->alias]['name']))
			{
//				$this->data[$this->alias]['name'] = preg_replace("/[^a-z0-9+\_\-]/i", "_", $this->data[$this->alias]['name'] );
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
					$val[$this->alias]['name'] = trim($val[$this->alias]['name']);
					$protocol = '';
					
					if($val[$this->alias]['protocol_id'])
					{
						$protocol_id = $val[$this->alias]['protocol_id'];
						if(isset($protocols[$protocol_id]))
						{
							$protocol = $protocols[$protocol_id];
						}
						else
						{
							$this->Protocol->id = $protocol_id;
							$protocol = $protocols[$protocol_id] = $this->Protocol->field('name');
						}
					}
					else
					{
						if(preg_match('/(tcpudp|tcp(\-|\_)udp|udptcp)/i', $val[$this->alias]['name']))
						{
							$protocol = 'tcp-udp';
						}
						elseif(preg_match('/(tcp$|(\_|\-)tcp(\_|\-)|TCP)/', $val[$this->alias]['name']))
						{
							$protocol = 'tcp';
						}
						elseif(preg_match('/(udp$|(\_|\-)udp(\_|\-)|UDP)/', $val[$this->alias]['name']))
						{
							$protocol = 'udp';
						}
						
						if($protocol)
						{
							// save the fix s these regex's don't run again on this pog
							$protocol_id = $this->Protocol->slugCheckAdd($protocol, array(
								'added_user_id' => (isset($val[$this->alias]['added_user_id'])?$val[$this->alias]['added_user_id']:0),
								'modified_user_id' => (isset($val[$this->alias]['modified_user_id'])?$val[$this->alias]['modified_user_id']:0),
								'firewall_id' => (isset($val[$this->alias]['firewall_id'])?$val[$this->alias]['firewall_id']:0),
								'import_id' => (isset($val[$this->alias]['import_id'])?$val[$this->alias]['import_id']:0),
								'slug' => $protocol,
								'name' => $protocol,
								'protocols' => $protocol,
								'description' => __('Auto detected from %s.', $this->alias),
							));
							
							$this->slugCheckAddUpdate = true;
							$this->slugCheckAdd($val[$this->alias]['slug'], array(
								'protocol_id' => $protocol_id,
							));
							$protocols[$protocol_id] = $protocol;
						}
					}
					
					$compiled = array(
						__('object-group service %s %s', $val[$this->alias]['name'], $protocol),
					);
					
					if (isset($results[$key][$this->alias]['ports'])) 
					{
						$ports = explode("\n", $results[$key][$this->alias]['ports']);
						
						foreach($ports as $port)
						{
							$port = trim($port);
							// has mask
							if(preg_match('/\s+/', $port))
							{
								$compiled[] = __('	port-object range %s', $port);
							}
							else
							{
								$compiled[] = __('	port-object eq %s', $port);
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
		$results = parent::find('all', array_replace($query, array(
			'resursive' => 0,
			'contain' => array('Protocol'),
		)));
		
		if(!$results)
		{
			return array();
		}
		
		$out = array();
		foreach($results as $result)
		{
			if(!isset($result[$this->alias]['slug'])) continue;
			
			$slug = $result[$this->alias]['slug'];
			$proto_slug = (isset($result['Protocol']['slug'])?$result['Protocol']['slug']:'');
			
			if(isset($out[$slug])) continue;
			
			$ports = array();
			if(isset($result[$this->alias]['ports']))
			{
				$ports_array = explode("\n", $result[$this->alias]['ports']);
				foreach($ports_array as $port)
				{
					$ports[$port] = $port;
				}
			}
			
			$out[$slug] = array(
				'name' => (isset($result[$this->alias]['name'])?$result[$this->alias]['name']:$slug),
				'slug' => $slug,
				'protocol' => (isset($result['Protocol']['name'])?$result['Protocol']['name']:$proto_slug),
				'protocol_slug' => $proto_slug,
				'ports' => $ports,
			);
		}
		
		return $out;
	}
}
