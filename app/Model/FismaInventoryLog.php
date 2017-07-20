<?php
App::uses('AppModel', 'Model');
/**
 * FismaInventoryLog Model
 *
 * @property FismaInventory $FismaInventory
 * @property User $User
 * @property NewFismaType $NewFismaType
 * @property NewFismaStatus $NewFismaStatus
 * @property OldFismaType $OldFismaType
 * @property OldFismaStatus $OldFismaStatus
 */
class FismaInventoryLog extends AppModel 
{

	public $displayField = 'fisma_inventory_id';
	
	public $validate = array(
		'fisma_inventory_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'fisma_inventory_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'NewFismaType' => array(
			'className' => 'FismaType',
			'foreignKey' => 'new_fisma_type_id',
		),
		'NewFismaStatus' => array(
			'className' => 'FismaStatus',
			'foreignKey' => 'new_fisma_status_id',
		),
		'OldFismaType' => array(
			'className' => 'FismaType',
			'foreignKey' => 'old_fisma_type_id',
		),
		'OldFismaStatus' => array(
			'className' => 'FismaStatus',
			'foreignKey' => 'old_fisma_status_id',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaInventoryLog.new_name',
		'FismaInventoryLog.new_contact_name',
		'FismaInventoryLog.new_contact_email',
		'FismaInventoryLog.new_mac_address',
		'FismaInventoryLog.new_asset_tag',
		'FismaInventoryLog.new_ip_address',
		'FismaInventoryLog.new_dns_name',
		'NewFismaType.name',
		'NewFismaStatus.name',
		
		'FismaInventoryLog.old_name',
		'FismaInventoryLog.old_contact_name',
		'FismaInventoryLog.old_contact_email',
		'FismaInventoryLog.old_mac_address',
		'FismaInventoryLog.old_asset_tag',
		'FismaInventoryLog.old_ip_address',
		'FismaInventoryLog.old_dns_name',
		'OldFismaType.name',
		'OldFismaStatus.name',
	);
	
	public function changeLog($logs = array())
	{
	/*
	 * reformat an all array to show the field, old, and new only
	 */
		$log_keys = array_keys($this->getColumnTypes());
		
		foreach($logs as $i => $log)
		{
			$changes = array();
			
			foreach($log[$this->alias] as $k => $v)
			{
				if(!preg_match('/^new\_/', $k)) continue;
				
				$new_k = $k;
				$old_k = str_replace('new', 'old', $k);
				
				$new_v = $log[$this->alias][$new_k];
				$old_v = $log[$this->alias][$old_k];
				
				// find the object that was changed
				$new_object = $old_object = false;
				if(preg_match('/\_id$/', $new_k))
				{
					$new_object = str_replace('_id', '', $new_k);
					$new_object = Inflector::camelize($new_object);
					$old_object = str_replace('_id', '', $old_k);
					$old_object = Inflector::camelize($old_object);
				}
				
				if($new_v == $old_v) continue;
				
				$field_k = str_replace('new_', '', $new_k);
				$changes[$field_k] = array(
					'old_value' => $old_v,
					'old_object' => $old_object,
					'old_object_name' => false,
					'old_object_id' => false,
					'new_value' => $new_v,
					'new_object' => $new_object,
					'new_object_name' => false,
					'new_object_id' => false,
				);
				if(isset($this->{$old_object} ))
				{
					$displayField = $this->{$old_object}->displayField;
					$changes[$field_k]['old_object_name'] =(isset($log[$old_object][$displayField])?$log[$old_object][$displayField]:false);
					$primaryKey = $this->{$old_object}->primaryKey;
					$changes[$field_k]['old_object_id'] =(isset($log[$old_object][$primaryKey])?$log[$old_object][$primaryKey]:false);
				}
				if(isset($this->{$new_object} ))
				{
					$displayField = $this->{$new_object}->displayField;
					$changes[$field_k]['new_object_name'] =(isset($log[$new_object][$displayField])?$log[$new_object][$displayField]:false);
					$primaryKey = $this->{$new_object}->primaryKey;
					$changes[$field_k]['new_object_id'] =(isset($log[$new_object][$primaryKey])?$log[$new_object][$primaryKey]:false);
				}
			}
			$logs[$i]['changes'] = $changes;
		}
		return $logs;
	}
	
	public function fixInventoryLogs()
	{
		$fisma_inventory_logs = $this->find('all', array(
			'conditions' => array(
				'FismaInventoryLog.new_host_id !=' => 0,
				'FismaInventoryLog.old_host_id' => 0,
			),
		));
		
		// foreach log, find the previous log
		$delete_ids = array();
		$saveMany = array();
		$prev_update = '';
		$fil_count = count($fisma_inventory_logs);
		$i = 0;
		foreach($fisma_inventory_logs as $fisma_inventory_log)
		{
			Configure::write('debug', 1);
			$prev_log = $this->find('all', array(
				'conditions' => array(
					'FismaInventoryLog.fisma_inventory_id' => $fisma_inventory_log['FismaInventoryLog']['fisma_inventory_id'],
					'FismaInventoryLog.created <= ' => $fisma_inventory_log['FismaInventoryLog']['created'],
				),
				'order' => array('FismaInventoryLog.created' => 'desc'),
				'limit' => 2,
			));
			
			// found what we're looking for, this is the last entry, fix the modified date for the fisma inventory
			if(
				isset($prev_log[0]['FismaInventoryLog']['id']) 
				and $fisma_inventory_log['FismaInventoryLog']['id'] == $prev_log[0]['FismaInventoryLog']['id']
				and isset($prev_log[1]['FismaInventoryLog']['created'])
			)
			{
				// delete this log
				$this->delete($prev_log[0]['FismaInventoryLog']['id']);
				// update the modified date for the fisma inventory to the created date of the last log
				$this->FismaInventory->id = $fisma_inventory_log['FismaInventoryLog']['fisma_inventory_id'];
				$this->FismaInventory->data = array(
					'id' => $prev_log[1]['FismaInventoryLog']['fisma_inventory_id'],
					'modified' => $prev_log[1]['FismaInventoryLog']['created'],
				);

echo "\033[".strlen($prev_update)."D";
$prev_update = $this->FismaInventory->id. ' - '. round($i/$fil_count * 100). '%';
echo $prev_update;

				$this->FismaInventory->dontLog = true;
				$this->FismaInventory->save($this->FismaInventory->data);
			}
			$i++;
		}
	}
}
