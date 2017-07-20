<?php
App::uses('AppModel', 'Model');
class FismaSystemPhysicalLocation extends AppModel 
{
	public $useTable = 'fisma_systems_physical_locations';
	
	public $belongsTo = array(
		'PhysicalLocation' => array(
			'className' => 'PhysicalLocation',
			'foreignKey' => 'physical_location_id',
			'multiselect' => true,
			'nameSingle' => 'Physical Location',
		),
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
			'multiselect' => true,
			'nameSingle' => 'FISMA System',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystem.name',
		'PhysicalLocation.name',
	);
	
	public function getLocationIds($fisma_system_id = false)
	{
		if(!$fisma_system_id)
			return array();
		
		return $this->find('list', array(
			'recursive' => -1,
			'fields' => array($this->alias.'.physical_location_id', $this->alias.'.physical_location_id'),
			'conditions' => array(
				$this->alias.'.fisma_system_id' => $fisma_system_id,
			),
		));
	}
	
	public function getSystemIds($physical_location_id = false)
	{
		if(!$physical_location_id)
			return array();
		
		return $this->find('list', array(
			'recursive' => -1,
			'fields' => array($this->alias.'.fisma_system_id', $this->alias.'.fisma_system_id'),
			'conditions' => array(
				$this->alias.'.physical_location_id' => $physical_location_id,
			),
		));
	}
	
	public function saveAssociatedLocations($fisma_system_id = false, $physical_location_ids = array(), $xref_data = array())
	{
		if(!$fisma_system_id) return false;
		if(!$physical_location_ids) $physical_location_ids = array();
		
		// remove the existing records (incase they add a physical_location that is already associated with this fisma_system)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('FismaSystemPhysicalLocation.physical_location_id', 'FismaSystemPhysicalLocation.physical_location_id'),
			'conditions' => array(
				'FismaSystemPhysicalLocation.fisma_system_id' => $fisma_system_id,
			),
		));
		
		$_physical_location_ids = $physical_location_ids;
		$physical_location_ids = array();
		$remove = array();
		foreach($_physical_location_ids as $physical_location_id => $checked)
		{
			// track the unes that need to be removed
			if(!$checked)
				$remove[$physical_location_id] = $physical_location_id;
			else
				$physical_location_ids[$physical_location_id] = $physical_location_id;
		}
		
		$_xref_data = $xref_data;
		$xref_data = array();
		foreach($_xref_data as $physical_location_id => $xrefData)
		{
			$xref_data[$physical_location_id] = $xrefData;
		}
		
		// get just the new ones
		foreach($existing as $physical_location_id)
		{
			if(isset($physical_location_ids[$physical_location_id]))
				unset($physical_location_ids[$physical_location_id]);
		}
		
		// build the proper save array
		$data = array();
		foreach($physical_location_ids as $physical_location_id)
		{
			$data[$physical_location_id] = array('fisma_system_id' => $fisma_system_id, 'physical_location_id' => $physical_location_id, 'active' => 1);
			
			if(isset($xref_data[$physical_location_id]))
			{
				$data[$physical_location_id] = array_merge($xref_data[$physical_location_id], $data[$physical_location_id]);
			}
		}
		
		if($remove)
		{
			$this->deleteAll(array(
				$this->alias.'.fisma_system_id' => $fisma_system_id,
				$this->alias.'.physical_location_id' => $remove,
			));
		}
		
		if(!$data)
			return true;
		
		return $this->saveMany($data);
	}
	
	public function saveAssociatedSystems($physical_location_id = false, $fisma_system_ids = array(), $xref_data = array())
	{
		if(!$physical_location_id) return false;
		if(!$fisma_system_ids) $fisma_system_ids = array();
		
		// remove the existing records (incase they add a fisma_system that is already associated with this physical_location)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('FismaSystemPhysicalLocation.fisma_system_id', 'FismaSystemPhysicalLocation.fisma_system_id'),
			'conditions' => array(
				'FismaSystemPhysicalLocation.physical_location_id' => $physical_location_id,
			),
		));
		
		// get just the new ones
		$_fisma_system_ids = $fisma_system_ids;
		$fisma_system_ids = array();
		$remove = array();
		foreach($_fisma_system_ids as $fisma_system_id => $checked)
		{
			// track the unes that need to be removed
			if(!$checked)
				$remove[$fisma_system_id] = $fisma_system_id;
			else
				$fisma_system_ids[$fisma_system_id] = $fisma_system_id;
		}
		
		$_xref_data = $xref_data;
		$xref_data = array();
		foreach($_xref_data as $fisma_system_id => $xrefData)
		{
			$xref_data[$fisma_system_id] = $xrefData;
		}
		
		// get just the new ones
		foreach($existing as $fisma_system_id)
		{
			if(isset($fisma_system_ids[$fisma_system_id]))
				unset($fisma_system_ids[$fisma_system_id]);
		}
		
		// build the proper save array
		$data = array();
		foreach($fisma_system_ids as $fisma_system_id)
		{
			$data[$fisma_system_id] = array('physical_location_id' => $physical_location_id, 'fisma_system_id' => $fisma_system_id, 'active' => 1);
			
			if(isset($xref_data[$fisma_system_id]))
			{
				$data[$fisma_system_id] = array_merge($xref_data[$fisma_system_id], $data[$fisma_system_id]);
			}
		}
		
		if($remove)
		{
			$this->deleteAll(array(
				$this->alias.'.physical_location_id' => $physical_location_id,
				$this->alias.'.fisma_system_id' => $remove,
			));
		}
		
		if(!$data)
			return true;
		
		return $this->saveMany($data);
	}
}