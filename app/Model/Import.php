<?php
App::uses('AppModel', 'Model');
/**
 * Import Model
 *
 * @property Rule $Rule
 */
class Import extends AppModel 
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
				'on'   => 'create',
			),
		),
		'file' => array(
			'included' => array(
				'on'   => 'create',
				'rule'    => 'uploadError',
				'message' => 'Something went wrong with the file upload.'
			),
/*
			'mimetype' => array(
				'on'   => 'create',
				'rule'    => array('mimeType', array('text/plain')),
				'message' => 'Invalid file type.'
			),
*/
		),
	);
	
	public $belongsTo = array(
		'ImportAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'ImportModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'ImportRescannedUser' => array(
			'className' => 'User',
			'foreignKey' => 'rescanned_user_id',
		),
	);
	
	public $hasMany = array(
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
		'Firewall' => array(
			'className' => 'Firewall',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
		'Fog' => array(
			'className' => 'Fog',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
		'FwInterface' => array(
			'className' => 'FwInterface',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
		'Protocol' => array(
			'className' => 'Protocol',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
		'Pog' => array(
			'className' => 'Pog',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
		'HostAlias' => array(
			'className' => 'HostAlias',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
		'PortAlias' => array(
			'className' => 'PortAlias',
			'foreignKey' => 'import_id',
			'dependent' => false,
		),
	);
	
	public $actsAs = array(
		'Utilities.FwConfigParser', 
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'Import.name',
	);
	
	public $manageUploads = array(
		'form_field' => 'file',
		'db_field' => 'filename',
		'file_object_name' => 'firewall config file',
	);
	
	public $process_added = array(
		'firewalls' => 0,
		'host_aliases' => 0,
		'fogs' => 0,
		'protogs' => 0,
		'pogs' => 0,
		'rules' => 0,
	);
	
	public function beforeSave($options = array())
	{
		return parent::beforeSave($options);
	}
	
	public function proccessImportString($data = array(), $string = false)
	{
		if(!$data)
		{
			$data = $this->data[$this->alias];
		}
		
		if($results = $this->FCP_parseString($string, $this->Fog->findAllSlugAsKey(), $this->Pog->findAllSlugAsKey()))
		{
			return $this->processImportResults($data, $results);
		}
		return false;
	}
	
	public function processImportFile($data = array(), $import_path = false)
	{
		if(!$data)
		{
			$data = $this->data[$this->alias];
		}
		if($results = $this->FCP_parseFile($import_path, $this->Fog->findAllSlugAsKey(), $this->Pog->findAllSlugAsKey()))
		{
			return $this->processImportResults($data, $results);
		}
		return false;
	}
	
	public function processImportResults($data = array(), $results = array())
	{
		if(!$data) return false;
		if(!$results) return false;
		
		$import_id = (isset($data['id'])?$data['id']:$this->id);
		$firewall_id = (isset($data['firewall_id'])?$data['firewall_id']:0);
		$added_user_id = (isset($data['added_user_id'])?$data['added_user_id']:0);
		$modified_user_id = (isset($data['modified_user_id'])?$data['modified_user_id']:0);
		$rescanned_user_id = (isset($data['rescanned_user_id'])?$data['rescanned_user_id']:0);
		
		$update = (isset($data['update'])?$data['update']:false);
		if($update) $update = true;
		
		// check/add the firewall
		if(!$firewall_id)
		{
			$firewall_id = $this->Firewall->slugCheckAdd($results['hostname_slug'], array(
				'slug' => $results['hostname_slug'],
				'added_user_id' => $added_user_id,
				'modified_user_id' => $modified_user_id,
				'rescanned_user_id' => $rescanned_user_id,
				'import_id' => $import_id,
				'name' => $results['name'],
				'hostname' => $results['hostname'],
				'domain_name' => $results['domain_name'],
			), array('update' => $update));
		}
		
		// check/add the host aliases
		$host_alias_ids = array();
		if(isset($results['names']))
		{
			foreach($results['names'] as $ip_address => $alias)
			{
				$slug = $this->FCP_slugify($alias);
				$host_alias_id = $this->HostAlias->slugCheckAdd($slug, array(
					'slug' => $slug,
					'added_user_id' => $added_user_id,
					'modified_user_id' => $modified_user_id,
					'rescanned_user_id' => $rescanned_user_id,
					'firewall_id' => $firewall_id,
					'import_id' => $import_id,
					'ip_address' => $ip_address,
					'alias' => $alias,
				), array('update' => $update));
			}
		}
		
		$fog_ids = array();
		// check/add the fogs
		if(isset($results['fogs']) and count($results['fogs']))
		{
			$families = array();
			foreach($results['fogs'] as $fog)
			{
				$ip_addresses = false;
				if(isset($fog['hosts']))
				{
					if(is_array($fog['hosts']))
					{
						$fog['hosts'] = implode("\n", $fog['hosts']);
					}
					$ip_addresses = $fog['hosts'];
				}
				
				
				if($fog_id = $this->Fog->slugCheckAdd($fog['slug'], array(
					'slug' => $fog['slug'],
					'added_user_id' => $added_user_id,
					'modified_user_id' => $modified_user_id,
					'rescanned_user_id' => $rescanned_user_id,
					'firewall_id' => $firewall_id,
					'import_id' => $import_id,
					'name' => $fog['name'],
					'ip_addresses' => $ip_addresses,
					'description' => (isset($fog['description'])?$fog['description']:false),
				), ['update' => $update, 'validate' => false]))
				{
					$fog_ids[$fog['slug']] = $fog_id;
					// groups
					if(isset($fog['groups']))
					{
						$families[$fog['slug']] = $fog['groups'];
					}
				}
			}
			
			if($families)
			{
				foreach($families as $parent_slug => $children)
				{
					$parent_id = false;
					if(isset($fog_ids[$parent_slug]))
					{
						$parent_id = $fog_ids[$parent_slug];
					}
					if(!$parent_id) continue;
					
					$child_ids = array();
					foreach($children as $child_slug => $child_name)
					{
						$child_id = false;
						if(isset($fog_ids[$child_slug]))
						{
							$child_id = $fog_ids[$child_slug];
						}
						if(!$child_id) continue;
						$child_ids[$child_id] = $child_id;
					}
					
					// save the parent/children relationship for this Fog
					$this->Fog->FogsParent->saveAssociations($parent_id, $child_ids, array(
						'import_id' => $import_id, 
						'firewall_id' => $firewall_id, 
						'added_user_id' => $added_user_id,
						'modified_user_id' => $modified_user_id,
						'rescanned_user_id' => $rescanned_user_id,
					));
				}
			}
		}
		
		$protocol_ids = array();
		// check/add the protocol object groups
		if(isset($results['protogs']) and count($results['protogs']))
		{
			$families = array();
			foreach($results['protogs'] as $protog)
			{
				$protocols = false;
				if(isset($protog['protocols']))
				{
					if(is_array($protog['protocols']))
					{
						$protog['protocols'] = implode("\n", $protog['protocols']);
					}
					$protocols = $protog['protocols'];
				}
				
				if($protocol_id = $this->Protocol->slugCheckAdd($protog['slug'], array(
					'slug' => $protog['slug'],
					'added_user_id' => $added_user_id,
					'modified_user_id' => $modified_user_id,
					'rescanned_user_id' => $rescanned_user_id,
					'firewall_id' => $firewall_id,
					'import_id' => $import_id,
					'name' => $protog['name'],
					'protocols' => $protocols,
					'description' => (isset($pog['description'])?$pog['description']:false),
				), ['update' => $update, 'validate' => false]))
				{
					$protocol_ids[$protog['slug']] = $protocol_id;
				}
			}
		}
		
		$pog_ids = array();
		$pog_protocols = array();
		
		// check/add the pogs
		if(isset($results['pogs']) and count($results['pogs']))
		{
			$families = array();
			foreach($results['pogs'] as $pog)
			{
				$ports = false;
				if(isset($pog['ports']))
				{
					if(is_array($pog['ports']))
					{
						$pog['ports'] = implode("\n", $pog['ports']);
					}
					$ports = $pog['ports'];
				}
				
				// make sure we push an update as well
				$this->Pog->slugCheckAddUpdate = true;
				
				if($pog_id = $this->Pog->slugCheckAdd($pog['slug'], array(
					'slug' => $pog['slug'],
					'added_user_id' => $added_user_id,
					'modified_user_id' => $modified_user_id,
					'rescanned_user_id' => $rescanned_user_id,
					'firewall_id' => $firewall_id,
					'import_id' => $import_id,
					'name' => $pog['name'],
					'protocol' => $pog['protocol'],
					'protocol_slug' => $pog['protocol_slug'],
					'protocol_id' => (isset($protocol_ids[$pog['protocol_slug']])?$protocol_ids[$pog['protocol_slug']]:0),
					'ports' => $ports,
					'description' => (isset($pog['description'])?$pog['description']:false),
				), ['update' => $update, 'validate' => false]))
				{
					$pog_ids[$pog['slug']] = $pog_id;
					// groups
					if(isset($pog['groups']))
					{
						$families[$pog['slug']] = $pog['groups'];
					}
				}
			}
			
			if($families)
			{
				foreach($families as $parent_slug => $children)
				{
					$parent_id = false;
					if(isset($pog_ids[$parent_slug]))
					{
						$parent_id = $pog_ids[$parent_slug];
					}
					if(!$parent_id) continue;
					
					$child_ids = array();
					foreach($children as $child_slug => $child_name)
					{
						$child_id = false;
						if(isset($pog_ids[$child_slug]))
						{
							$child_id = $pog_ids[$child_slug];
						}
						if(!$child_id) continue;
						$child_ids[$child_id] = $child_id;
					}
					
					// save the parent/children relationship for this Pog
					$this->Pog->PogsParent->saveAssociations($parent_id, $child_ids, array(
						'import_id' => $import_id, 
						'firewall_id' => $firewall_id, 
						'added_user_id' => $added_user_id,
						'modified_user_id' => $modified_user_id,
						'rescanned_user_id' => $rescanned_user_id,
					));
				}
			}
		}
		
		// process the rules
		if(isset($results['rules']) and count($results['rules']))
		{
			// get app of the interfaces that are referenced in the rules
			$fw_interface_ids = array();
			foreach($results['rules'] as $hash => $rule)
			{
				if(!isset($rule['interface'])) continue;
				
				$slug = $this->FCP_slugify($rule['interface']);
				$fw_interface_id = $this->FwInterface->slugCheckAdd($slug, array(
					'slug' => $slug,
					'added_user_id' => $added_user_id,
					'modified_user_id' => $modified_user_id,
					'rescanned_user_id' => $rescanned_user_id,
					'firewall_id' => $firewall_id,
					'import_id' => $import_id,
					'name' => $rule['interface'],
				), ['update' => $update, 'validate' => false]);
				$fw_interface_ids[$slug] = $fw_interface_id;
			}
			
			// get app of the protocols that are referenced in the rules
			$protocol_ids = array();
			foreach($results['rules'] as $hash => $rule)
			{
				if(!isset($rule['protocol'])) continue;
				
				$slug = $this->FCP_slugify($rule['protocol']);
				$protocol_id = $this->Protocol->slugCheckAdd($slug, array(
					'slug' => $slug,
					'added_user_id' => $added_user_id,
					'modified_user_id' => $modified_user_id,
					'rescanned_user_id' => $rescanned_user_id,
					'firewall_id' => $firewall_id,
					'import_id' => $import_id,
					'name' => $rule['protocol'],
				), ['update' => $update, 'validate' => false]);
				$protocol_ids[$slug] = $protocol_id;
			}
			
			$review_state_id = $this->Rule->ReviewState->defaultId();
			
			// process the actual rules
			foreach($results['rules'] as $hash => $rule)
			{
				if(!isset($rule['protocol'])) continue;
				
				$rule_data = array(
					'hash' => $hash,
					'added_user_id' => $added_user_id,
					'modified_user_id' => $modified_user_id,
					'rescanned_user_id' => $rescanned_user_id,
					'firewall_id' => $firewall_id,
					'import_id' => $import_id,
					'review_state_id' => $review_state_id,
					'fw_interface_id' => 0,
					'permit' => 0,
					'protocol_id' => 0,
					'src_fisma_system_id' => 0,
					'dst_fisma_system_id' => 0,
					'src_fog_id' => 0,
					'dst_fog_id' => 0,
					'src_pog_id' => 0,
					'dst_pog_id' => 0,
					'src_ip' => (isset($rule['src_ip'])?$rule['src_ip']:false),
					'src_port' => (isset($rule['src_port'])?$rule['src_port']:false),
					'src_desc' => false,
					'dst_ip' => (isset($rule['dst_ip'])?$rule['dst_ip']:false),
					'dst_port' => (isset($rule['dst_port'])?$rule['dst_port']:false),
					'dst_desc' => false,
					'logging' => (isset($rule['logging'])?$rule['logging']:false),
					'remarks' => (isset($rule['remark'])?$rule['remark']:false),
					'raw' => (isset($rule['line'])?$rule['line']:false),
					'use_src_fog' => false,
					'use_dst_fog' => false,
					'use_src_pog' => false,
					'use_dst_pog' => false,
				);
				
				if(isset($data['Rule']))
				{
					$rule_data = array_merge($data['Rule'], $rule_data);
				}
				
				// get the fw_interface id
				$slug = $this->FCP_slugify($rule['interface']);
				$rule_data['fw_interface_id'] = (isset($fw_interface_ids[$slug])?$fw_interface_ids[$slug]:0);
			
				// get the permit
				$rule_data['permit'] = (isset($rule['permit']) and $rule['permit'] == 'permit'?1:0);
				
				// get the protocol
				$slug = $this->FCP_slugify($rule['protocol']);
				$rule_data['protocol_id'] = (isset($protocol_ids[$slug])?$protocol_ids[$slug]:0);
				
				// source ip address
				if(isset($rule['src_ip']) and trim($rule['src_ip']))
				{
					$rule_data['src_ip'] = $rule['src_ip'];
					
					// the description
					$aliases = $this->HostAlias->IpLookup($rule['src_ip'], array(
						'added_user_id' => $added_user_id,
						'modified_user_id' => $modified_user_id,
						'rescanned_user_id' => $rescanned_user_id,
						'firewall_id' => $firewall_id,
						'import_id' => $import_id,
					));
					
					$rule_data['src_desc'] = implode(', ', $aliases);
				}
				
				// source port
				if(isset($rule['src_port']) and trim($rule['src_port']))
				{
					$rule_data['src_port'] = $rule['src_port'];
				}
				
				// source fog
				if(isset($rule['src_fog']) and trim($rule['src_fog']))
				{
					$slug = false;
					if(isset($rule['src_fog_slug']) and trim($rule['src_fog_slug'])) $slug = $rule['src_fog_slug'];
					else $slug = $this->FCP_slugify($rule['src_fog']);
					
					$fog_id = false;
					if(isset($fog_ids[$slug]))
					{
						$fog_id = $fog_ids[$slug];
					}
					// add this fog
					else
					{
						$fog_id = $this->Fog->slugCheckAdd($slug, array(
							'slug' => $slug,
							'added_user_id' => $added_user_id,
							'modified_user_id' => $modified_user_id,
							'rescanned_user_id' => $rescanned_user_id,
							'firewall_id' => $firewall_id,
							'import_id' => $import_id,
							'name' => $rule['src_fog'],
						), ['update' => $update, 'validate' => false]);
					}
					if($fog_id)
					{
						$rule_data['src_fog_id'] = $fog_id;
						$rule_data['use_src_fog'] = true;
					}
				}
				
				// source pog
				if(isset($rule['src_pog']) and trim($rule['src_pog']))
				{
					$slug = false;
					if(isset($rule['src_pog_slug']) and trim($rule['src_pog_slug'])) $slug = $rule['src_pog_slug'];
					else $slug = $this->FCP_slugify($rule['src_pog']);
					
					$pog_id = false;
					if(isset($pog_ids[$slug]))
					{
						$pog_id = $pog_ids[$slug];
					}
					// add this pog
					else
					{
						$pog_id = $this->Pog->slugCheckAdd($slug, array(
							'slug' => $slug,
							'added_user_id' => $added_user_id,
							'modified_user_id' => $modified_user_id,
							'rescanned_user_id' => $rescanned_user_id,
							'firewall_id' => $firewall_id,
							'import_id' => $import_id,
							'name' => $rule['src_pog'],
						), ['update' => $update, 'validate' => false]);
					}
					if($pog_id)
					{
						$rule_data['src_pog_id'] = $pog_id;
						$rule_data['use_src_pog'] = true;
					}
				}
				
				// destination ip address
				if(isset($rule['dst_ip']) and trim($rule['dst_ip']))
				{
					$rule_data['dst_ip'] = $rule['dst_ip'];
					
					// the description
					$aliases = $this->HostAlias->IpLookup($rule['dst_ip'], array(
						'added_user_id' => $added_user_id,
						'modified_user_id' => $modified_user_id,
						'rescanned_user_id' => $rescanned_user_id,
						'firewall_id' => $firewall_id,
						'import_id' => $import_id,
					));
					
					$rule_data['dst_desc'] = implode(', ', $aliases);
				}
				
				// destination port
				if(isset($rule['dst_port']) and trim($rule['dst_port']))
				{
					$rule_data['dst_port'] = $rule['dst_port'];
				}
				
				// destination fog
				if(isset($rule['dst_fog']) and trim($rule['dst_fog']))
				{
					$slug = false;
					if(isset($rule['dst_fog_slug']) and trim($rule['dst_fog_slug'])) $slug = $rule['dst_fog_slug'];
					else $slug = $this->FCP_slugify($rule['dst_fog']);
					
					$fog_id = false;
					if(isset($fog_ids[$slug]))
					{
						$fog_id = $fog_ids[$slug];
					}
					// add this fog
					else
					{
						$fog_id = $this->Fog->slugCheckAdd($slug, array(
							'slug' => $slug,
							'added_user_id' => $added_user_id,
							'modified_user_id' => $modified_user_id,
							'rescanned_user_id' => $rescanned_user_id,
							'firewall_id' => $firewall_id,
							'import_id' => $import_id,
							'name' => $rule['dst_fog'],
						), ['update' => $update, 'validate' => false]);
					}
					if($fog_id)
					{
						$rule_data['dst_fog_id'] = $fog_id;
						$rule_data['use_dst_fog'] = true;
					}
				}
				
				// destination pog
				if(isset($rule['dst_pog']) and trim($rule['dst_pog']))
				{
					$slug = false;
					if(isset($rule['dst_pog_slug']) and trim($rule['dst_pog_slug'])) $slug = $rule['dst_pog_slug'];
					else $slug = $this->FCP_slugify($rule['dst_pog']);
					
					$pog_id = false;
					if(isset($pog_ids[$slug]))
					{
						$pog_id = $pog_ids[$slug];
					}
					// add this pog
					else
					{
						$pog_id = $this->Fog->slugCheckAdd($slug, array(
							'slug' => $slug,
							'added_user_id' => $added_user_id,
							'modified_user_id' => $modified_user_id,
							'rescanned_user_id' => $rescanned_user_id,
							'firewall_id' => $firewall_id,
							'import_id' => $import_id,
							'name' => $rule['dst_pog'],
						), ['update' => $update, 'validate' => false]);
					}
					if($pog_id)
					{
						$rule_data['dst_pog_id'] = $pog_id;
						$rule_data['use_dst_pog'] = true;
					}
				}
				
				if(!$rule_id = $this->Rule->hashCheckAdd($hash, $rule_data, array('validate' => false, 'update' => true)))
				{
				}
			}
		}
	
		$this->process_added = array(
			'Firewalls' => $this->Firewall->checkadded,
			'Host Aliases' => $this->HostAlias->checkadded,
			'Firewall Object Groups' => $this->Fog->checkadded,
			'Protocols' => $this->Protocol->checkadded,
			'Port Object Groups' => $this->Pog->checkadded,
			'Interfaces' => $this->FwInterface->checkadded,
			'Rules' => $this->Rule->checkadded,
		);
		
		// update the import data as well
		if($import_id)
		{
			$data['rescanned'] = date('Y-m-d H:i:s');
			$this->id = $import_id;
			$this->data = $data;
			$this->save($this->data);
		}
		
		return true;
	}
}
