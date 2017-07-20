<?php
App::uses('AppModel', 'Model');
/**
 * FismaInventory Model
 *
 * @property FismaSystem $FismaSystem
 * @property AddedUser $AddedUser
 * @property ModifiedUser $ModifiedUser
 * @property FismaType $FismaType
 * @property FismaStatus $FismaStatus
 * @property FismaInventoryLog $FismaInventoryLog
 */
class FismaInventory extends AppModel 
{

	public $displayField = 'name';
	
	public $validate = array(
/*
		'name' => array(
			'numeric' => array(
				'rule' => array('notBlank'),
			),
		),
		'mac_address' => array(
			'numeric' => array(
				'rule' => array('notBlank'),
			),
		),
		'ip_address' => array(
			'numeric' => array(
				'rule' => array('notBlank'),
			),
		),
*/
		'fisma_system_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'added_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'modified_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
		),
		'AddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'ModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'FismaType' => array(
			'className' => 'FismaType',
			'foreignKey' => 'fisma_type_id',
			'plugin_filter' => array(
				'name' => 'Type',
			)
		),
		'FismaStatus' => array(
			'className' => 'FismaStatus',
			'foreignKey' => 'fisma_status_id',
			'plugin_filter' => array(
				'name' => 'Status',
			)
		),
		'FismaSource' => array(
			'className' => 'FismaSource',
			'foreignKey' => 'fisma_source_id',
			'plugin_filter' => array(
				'name' => 'Source',
			)
		),
	);
	
	public $hasMany = array(
		'FismaInventoryLog' => array(
			'className' => 'FismaInventoryLog',
			'foreignKey' => 'fisma_inventory_id',
			'dependent' => true,
		),
		'FismaInventoryFile' => array(
			'className' => 'FismaInventoryFile',
			'foreignKey' => 'fisma_inventory_id',
			'dependent' => true,
		),
		'SubnetMember' => array(
			'className' => 'SubnetMember',
			'foreignKey' => 'fisma_inventory_id',
			'dependent' => true,
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
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
		'FismaSystem.name',
		'FismaInventory.name',
		'FismaInventory.contact_name',
		'FismaInventory.contact_email',
		'FismaInventory.mac_address',
		'FismaInventory.asset_tag',
		'FismaInventory.ip_address',
		'FismaInventory.dns_name',
		'FismaInventory.location',
		'FismaInventory.nat_ip_address',
		'FismaType.name',
		'FismaStatus.name',
		'FismaSource.name',
	);
	
	public $logData = array();
	
	
	public $csv_field_map = array(
		'FismaInventory.name' => 'Friendly Name',
		'FismaInventory.mac_address' => 'MAC Address',
		'FismaInventory.ip_address' => 'IP Address',
		'FismaInventory.asset_tag' => 'Asset Tag', 
		'FismaInventory.dns_name' => 'DNS Name',
	);
	
	public $currentRecord = array();
	public $newRecord = array();
	
	public $dontLog = false;
	
	public function containDiscover($others = array())
	{
	// hotfix used to discover all we need to use in a contain to get a new limit count for exporting search results
		$out = $others;
		foreach($this->searchFields as $searchField_k => $searchField_v)
		{
			$field = false;
			$model = false;
			if(is_string($searchField_v))
				$field = $searchField_v;
			elseif(!is_int($searchField_k) and is_string($searchField_k))
				$field = $searchField_k;
			
			if(!$field)
				continue;
			
			if(stripos($field, '.') !== false)
			{
				list($model, $field) = explode('.', $field);
				if($model != $this->alias)
					$out[$model] = $model;
			}
		}
		sort($out);
		$out = array_flip($out);
		$out = array_flip($out);
		return $out;
	}
	
	public function beforeValidate($options = array())
	{
		$this->data = $this->fixData($this->data);
		
		return parent::beforeValidate($options);
	}
	
	public function beforeSave($options = array()) 
	{
		$this->data = $this->fixData($this->data);
		
		if($this->dontLog)
			return parent::beforeSave($options);
		
		// see if we're updating this inventory. if so, get the current record from the db
		if(isset($this->id))
		{
			$this->newRecord = $this->data;
			$this->currentRecord = $this->read(null, $this->id);
			$this->data = $this->newRecord;
		}
		
		// track the new data
		// $this->newData = $this->data[$this->alias];
		$this->modelError = false;
		$this->logData = array();
		$oldData = array();
		
		$log_keys = array_keys($this->FismaInventoryLog->getColumnTypes());
		
		foreach($this->data[$this->alias] as $k => $v)
		{
			$new_k = 'new_'. $k;
			if(!in_array($new_k, $log_keys)) continue;
			
			$v = trim($v);
			
			$this->logData[$new_k] = $v;
			$this->data[$this->alias][$k] = $v; // trim whitespace off
		}
		
		// an edit, track the old data as well
		if(isset($this->data[$this->alias]['id']))
		{
			$newData = $this->data;
			$this->recursive = -1;
			if(!$oldData = $this->read(null, $this->data[$this->alias]['id']))
			{
				$this->modelError = __('Unable to find the original item.');
				return false;
			}
			$this->data = $newData;
			
			$oldData = $oldData[$this->alias];
			
			// only track the differences
			foreach($oldData as $k => $v)
			{
				$new_k = 'new_'. $k;
				if(!in_array($new_k, $log_keys)) continue;
				
				$old_k = 'old_'. $k;
				if(!in_array($new_k, $log_keys)) continue;
				
				if(isset($this->logData[$new_k]) and isset($oldData[$k]))
				{
					if($this->logData[$new_k] != $oldData[$k])
					{
						$this->logData[$old_k] = $oldData[$k];
					}
					else
					{
						unset($this->logData[$new_k]);
					}
				}
			}
			
			if($this->logData and isset($this->data[$this->alias]['modified_user_id']) and $this->data[$this->alias]['modified_user_id'])
			{
				$this->logData['user_id'] = $this->data[$this->alias]['modified_user_id'];
				$this->data[$this->alias]['modified'] = date('Y-m-d H:i:s');
			}
		}
		else
		{
			if(isset($this->data[$this->alias]['added_user_id']) and $this->data[$this->alias]['added_user_id'])
			{
				$this->logData['user_id'] = $this->data[$this->alias]['added_user_id'];
				$this->data[$this->alias]['modified'] = false;
				$this->data[$this->alias]['created'] = date('Y-m-d H:i:s');
			}
		}
		
		return parent::beforeSave($options);
	}
	
	public function afterSave($created = false, $options = array())
	{
		if($this->id and $this->logData)
		{
			$this->logData['fisma_inventory_id'] = $this->id;
			
			$this->FismaInventoryLog->create();
			$this->FismaInventoryLog->data = $this->logData;
			$this->FismaInventoryLog->save($this->FismaInventoryLog->data);
			
			$this->logData = array();
		}
		
		$rescan = true; // if the ip address is changed, recheck the subnets
		if($created)
		{
			$this->Usage_updateCounts('created', 'fisma_inventory');
			$this->Usage_updateCounts('fisma_inventory', 'created');
			$rescan = true;
		}
		else
		{
			$this->Usage_updateCounts('modified', 'fisma_inventory');
			$this->Usage_updateCounts('fisma_inventory', 'modified');
			/// see if any of the ip address  changed
			if(isset($this->currentRecord[$this->alias]['ip_address']) and isset($this->newRecord[$this->alias]['ip_address']))
				if($this->currentRecord[$this->alias]['ip_address'] != $this->newRecord[$this->alias]['ip_address'])
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
		$this->SubnetMember->subnetsToFismaInventory($id);
	}
	
	public function fixData($data = array())
	{
		if(isset($data[$this->alias]['mac_address']) and $data[$this->alias]['mac_address'])
		{
			$data[$this->alias]['mac_address'] = strtoupper($data[$this->alias]['mac_address']);
			$data[$this->alias]['mac_address'] = preg_replace('/[^a-zA-Z0-9]+/',"", $data[$this->alias]['mac_address']);
		}
		
		return $data;
	}
	
	public function batchGetHeaders($data = array())
	{
		if(!isset($data[$this->alias]['csv']))
		{
			$this->invalidate['csv'] = array(_('No CSV data available (batchGetHeaders)'));
			return false;
		}
		
		$data[$this->alias]['csv'] = trim($data[$this->alias]['csv']);
		
		$lines = explode("\n", $data[$this->alias]['csv']);
		$_headers = str_getcsv(array_shift($lines));
		$headers = array();
		foreach($_headers as $i => $header)
		{
			$header = trim($header);
			$header_key = strtolower(Inflector::slug($header));
			$header_value = Inflector::humanize($header_key);
			if(!$header_key) unset($headers[$i]);
			$headers[$header_key] = $header_value;
		}
		
		return $headers;
	}
	
	public function batchMapCsv($data = array(), $header_map = array())
	{
		if(!isset($data[$this->alias]['csv']))
		{
			$this->invalidate['csv'] = array(__('No CSV data available (batchMapCsv)'));
			return false;
		}
		
		$header_map = Set::flatten($header_map);
		//$header_map = array_flip($header_map);
		
		$data[$this->alias]['csv'] = trim($data[$this->alias]['csv']);
		
		$lines = explode("\n", $data[$this->alias]['csv']);
		$headers = str_getcsv(array_shift($lines));
		
		// clean up the headers
		foreach($headers as $i => $header)
		{
			$headers[$i] = strtolower(Inflector::slug($header));
		}
		
		$item_map = array();
		$cnt = 0;
		foreach($lines as $line)
		{
			$item = str_getcsv($line);
			foreach($headers as $i => $header)
			{
				if(isset($item[$i]) and trim($item[$i]))
				{
					$item_map[$cnt][$header] = $item[$i];
				}
			}
			$cnt++;
		}
		
		$items = array();
		$cnt = 0;
		foreach($item_map as $item_map_item)
		{
			$item = array();
			foreach($header_map as $ours => $theirs)
			{
				$item[$ours] = '';
				if(isset($item_map_item[$theirs])) $item[$ours] = $item_map_item[$theirs];
			}
			
			if($item)
			{
				$items[$cnt] = $item;
				$cnt++;
			}
		}
		
		$items = Set::flatten($items);
		$items = Hash::expand($items, '.');
		
		foreach($items as $i => $item)
		{
			// clean up the mac address 
			if(isset($item['FismaInventory']['mac_address']))
			{
				$item['FismaInventory']['mac_address'] = strtoupper($item['FismaInventory']['mac_address']);
				$items[$i]['FismaInventory']['mac_address'] = preg_replace("/[^a-zA-Z0-9]/", "", $item['FismaInventory']['mac_address']);
			}
		}
		
		return $items;
	}
	
	public function batchSave($data = array(), $data_append = array())
	{
		foreach($data as $i => $item)
		{
			foreach($item as $model => $model_data)
			{
				if(isset($data_append[$model]))
				{
					$data[$i][$model] = array_merge($data_append[$model], $data[$i][$model]);
				}
				foreach($model_data as $k => $v)
				{
					if(preg_match('/_id$/i', $k))
					{
						if(!$v) $data[$i][$model][$k] = 0;
					}
				}
			}
		}
		
		$data_to_save = array();
		$_data = $data;
		$errors = false;
		$return = false;
		
		if($validate = $this->validateMany($_data))
		{
			// all were fine
			$data_to_save = $data;
			$return = true;
		}
		else
		{
			// items needs to be fixed
			$data_to_fix = array();
			$errors = $this->validationErrors;
			foreach($errors as $i => $error_data)
			{
				if(isset($data[$i]))
				{
					$data_to_fix[$i] = $data[$i];
					unset($data[$i]);
				}
				$data_to_save = $data;
			}
			$this->batchIssues = count($data_to_fix);
			$this->batchDataToFix = $data_to_fix;
		}
		
		// save the ones that can be saved
		$this->batchSaved = 0;
		foreach($data as $i => $item)
		{
			if($this->saveAssociated($item))
			{
				$this->batchSaved++;
			}
			else
			{
				$this->batchDataToFix[$i] = $item;
				$this->batchIssues++;
				$return = true;
			}
		}
		
		$this->validationErrors = $errors;
		
		return $return;
	}
	
	public function multiselect_items($data = array(), $values = array())
	{
		$this->multiselectReferer = array();
		if(isset($data[$this->alias]['multiselect_referer']))
		{
			$this->multiselectReferer = unserialize($data[$this->alias]['multiselect_referer']);
		}
		
		$ids = array();
		if(isset($data['multiple']))
		{
			$ids = $data['multiple'];
		}
		
		$values = Hash::flatten($values);
		return $this->updateAll(
			$values,
			array($this->alias.'.id' => $ids)
		);
	}
	
	public function multiselect_items_multiple($data = array(), $values = array())
	{
		$this->multiselectReferer = array();
		if(isset($data[$this->alias]['multiselect_referer']))
		{
			$this->multiselectReferer = unserialize($data[$this->alias]['multiselect_referer']);
		}
		
		return $this->saveMany($values);
	}
	
	public function multiselect_addTags($data = array(), $values = array())
	{
		$this->multiselectReferer = array();
		if(isset($data[$this->alias]['multiselect_referer']))
		{
			$this->multiselectReferer = unserialize($data[$this->alias]['multiselect_referer']);
		}
		
		$ids = array();
		if(isset($data['multiple']))
		{
			$ids = $data['multiple'];
		}
		
		foreach($ids as $id)
		{
			$this->id = $id;
			$this->data = $values;
			$this->save($this->data);
		}
		return true;
	}
	
	public function idsForDirector($ad_account_id = false)
	{
		$fismaSystem_ids = $this->FismaSystem->idsForDirector($ad_account_id);
		
		if($ids = $this->find('list', array(
			'fields' => array($this->alias.'.id', $this->alias.'.id'),
			'conditions' => array($this->alias.'.fisma_system_id' => $fismaSystem_ids)
		)))
		{
			return array();
		}
		return $ids;
	}
	
	public function listforDirector($ad_account_id = false)
	{
		$fismaSystem_ids = $this->FismaSystem->idsForDirector($ad_account_id);
		
		if(!$inventories = $this->find('all', array(
			'conditions' => array($this->alias.'.fisma_system_id' => $fismaSystem_ids)
		)))
		{
			return array();
		}
		return $inventories;
	}
}
