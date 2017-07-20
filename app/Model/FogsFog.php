<?php
App::uses('AppModel', 'Model');
/**
 * FogsFog Model
 *
 * @property FogParent $FogParent
 * @property FogChild $FogChild
 */
class FogsFog extends AppModel 
{

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'FogParent' => array(
			'className' => 'Fog',
			'foreignKey' => 'parent_id',
		),
		'FogChild' => array(
			'className' => 'Fog',
			'foreignKey' => 'child_id',
		),
		'Import' => array(
			'className' => 'Import',
			'foreignKey' => 'import_id',
		),
		'Firewall' => array(
			'className' => 'Firewall',
			'foreignKey' => 'firewall_id',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FogChild.name',
		'FogParent.name',
	);
	
	public function saveAssociations($parent_id = false, $child_ids = array(), $global_xref_data = array())
	{
	/*
	 * Saves associations between a fog parents and children
	 * 
	 */
			$existing = $this->find('list', array(
				'recursive' => -1,
				'fields' => array($this->alias. '.id', $this->alias. '.child_id'),
				'conditions' => array(
					$this->alias. '.parent_id' => $parent_id,
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
}
