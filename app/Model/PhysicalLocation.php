<?php
App::uses('AppModel', 'Model');
class PhysicalLocation extends AppModel 
{
	public $order = array('PhysicalLocation.name' => 'asc');
	
	public $hasMany = array(
		'FismaSystemPhysicalLocation' => array(
			'className' => 'FismaSystemPhysicalLocation',
			'foreignKey' => 'physical_location_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'joinTable' => 'fisma_systems_physical_locations',
			'foreignKey' => 'physical_location_id',
			'associationForeignKey' => 'fisma_system_id',
			'unique' => 'keepExisting',
			'with' => 'FismaSystemPhysicalLocation',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystem.name',
		'PhysicalLocation.name',
	);
}