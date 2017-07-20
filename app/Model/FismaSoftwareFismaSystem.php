<?php
App::uses('AppModel', 'Model');
class FismaSoftwareFismaSystem extends AppModel 
{
	public $useTable = 'fisma_softwares_fisma_systems';
	public $validate = array(
		'fisma_software_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'fisma_system_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'FismaSoftware' => array(
			'className' => 'FismaSoftware',
			'foreignKey' => 'fisma_software_id',
		),
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystem.name',
		'FismaSoftware.name',
	);
	
	public function saveAssociatedSoftwares($fisma_system_id = false, $fisma_software_ids = array(), $fisma_software_xref_data = array())
	{
		if(!$fisma_software_ids) $fisma_software_ids = array();
		
		// remove the existing records (incase they add a fisma_software that is already associated with this fisma_system)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('FismaSoftwareFismaSystem.id', 'FismaSoftwareFismaSystem.fisma_software_id'),
			'conditions' => array(
				'FismaSoftwareFismaSystem.fisma_system_id' => $fisma_system_id,
			),
		));
		
		// get just the new ones
		$fisma_software_ids = array_diff($fisma_software_ids, $existing);
		
		// build the proper save array
		$data = array();
		foreach($fisma_software_ids as $fisma_software => $fisma_software_id)
		{
			$data[$fisma_software] = array('fisma_system_id' => $fisma_system_id, 'fisma_software_id' => $fisma_software_id, 'active' => 1);
			if(isset($fisma_software_xref_data[$fisma_software]))
			{
				$data[$fisma_software] = array_merge($fisma_software_xref_data[$fisma_software], $data[$fisma_software]);
			}
		}
		return $this->saveMany($data);
	}
	
	public function saveAssociatedSystems($fisma_software_id = false, $fisma_system_ids = array(), $fisma_system_xref_data = array())
	{
		if(!$fisma_system_ids) $fisma_system_ids = array();
		
		// remove the existing records (incase they add a fisma_system that is already associated with this fisma_software)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('FismaSoftwareFismaSystem.id', 'FismaSoftwareFismaSystem.fisma_system_id'),
			'conditions' => array(
				'FismaSoftwareFismaSystem.fisma_software_id' => $fisma_software_id,
			),
		));
		
		// get just the new ones
		$fisma_system_ids = array_diff($fisma_system_ids, $existing);
		
		// build the proper save array
		$data = array();
		foreach($fisma_system_ids as $fisma_system => $fisma_system_id)
		{
			$data[$fisma_system] = array('fisma_software_id' => $fisma_software_id, 'fisma_system_id' => $fisma_system_id, 'active' => 1);
			if(isset($fisma_system_xref_data[$fisma_system]))
			{
				$data[$fisma_system] = array_merge($fisma_system_xref_data[$fisma_system], $data[$fisma_system]);
			}
		}
		return $this->saveMany($data);
	}
}
