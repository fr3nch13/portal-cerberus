<?php
App::uses('AppModel', 'Model');

class ReportsSystemType extends AppModel 
{
	public $displayField = 'name';
	
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'slug' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $hasMany = array(
		'HighRiskResultLog' => array(
			'className' => 'HighRiskResultLog',
			'foreignKey' => 'reports_system_type_id',
			'dependent' => false,
		),
		'HighRiskResult' => array(
			'className' => 'HighRiskResult',
			'foreignKey' => 'reports_system_type_id',
			'dependent' => false,
		),
		'FovResult' => array(
			'className' => 'FovResult',
			'foreignKey' => 'reports_system_type_id',
			'dependent' => false,
		),
	);
	
	public $actsAs = [
		'ReportsAttribute',
	];
	
	public $cacheQueries = true;
	
	public $searchFields = [
		'ReportsSystemType.name',
	];
}
