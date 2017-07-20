<?php
App::uses('AppModel', 'Model');

class ReportsSeverity extends AppModel 
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
		'PenTestResultLog' => array(
			'className' => 'PenTestResultLog',
			'foreignKey' => 'reports_severity_id',
			'dependent' => false,
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'reports_severity_id',
			'dependent' => false,
		),
		'FovResult' => array(
			'className' => 'FovResult',
			'foreignKey' => 'reports_severity_id',
			'dependent' => false,
		),
	);
	
	public $actsAs = [
		'ReportsAttribute',
	];
	
	public $cacheQueries = true;
	
	public $searchFields = [
		'ReportsSeverity.name',
	];
}
