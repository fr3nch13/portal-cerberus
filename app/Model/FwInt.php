<?php
App::uses('AppModel', 'Model');
/**
 * FwInt Model
 *
 */
class FwInt extends AppModel 
{

	public $belongsTo = array(
		'Firewall' => array(
			'className' => 'Firewall',
			'foreignKey' => 'firewall_id',
		),
		'FwInterface' => array(
			'className' => 'FwInterface',
			'foreignKey' => 'fw_interface_id',
		),
	);
	
	public $hasMany = array(
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'fw_int_id',
			'dependent' => false,
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FwInt.name',
		'FwInterface.name',
		'Firewall.name',
	);
	
	public function afterSave($created = false, $options = array())
	{	
		
		if($this->id)
		{
			$rule_fields = array();
			if(isset($this->data[$this->alias]['firewall_id']) and $this->data[$this->alias]['firewall_id'])
			{
				$rule_fields['Rule.firewall_id'] = $this->data[$this->alias]['firewall_id'];
			}
			if(isset($this->data[$this->alias]['fw_interface_id']) and $this->data[$this->alias]['fw_interface_id'])
			{
				$rule_fields['Rule.fw_interface_id'] = $this->data[$this->alias]['fw_interface_id'];
			}
			if($rule_fields)
			{
				$this->Rule->updateAll($rule_fields, array('Rule.fw_int_id' => $this->id));
			}
		}
		return parent::afterSave($created, $options);
	}
	
/*
	public function saveAssociations($parent_id = false, $child_ids = array(), $global_xref_data = array())
	{
			$existing = $this->find('list', array(
				'recursive' => -1,
				'fields' => array('FwInt.id', 'FwInt.child_id'),
				'conditions' => array(
					'FwInt.parent_id' => $parent_id,
				),
			));
			
			// get just the new ones
			$child_ids = array_diff($child_ids, $existing);
			
			// build the proper save array
			$data = array();
			foreach($child_ids as $child_id)
			{
				$data[$child_id] = array('parent_id' => $parent_id, 'child_id' => $child_id);
				if(isset($global_xref_data))
				{
					$data[$child_id] = array_merge($global_xref_data, $data[$child_id]);
				}
			}
			
			return $this->saveMany($data);
	}
*/
}
