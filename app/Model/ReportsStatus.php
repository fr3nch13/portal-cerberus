<?php
App::uses('AppModel', 'Model');

class ReportsStatus extends AppModel
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
		'UsResultLog' => array(
			'className' => 'UsResultLog',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'UsResult' => array(
			'className' => 'UsResult',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'EolResultLog' => array(
			'className' => 'EolResultLog',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'EolResult' => array(
			'className' => 'EolResult',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'PenTestResultLog' => array(
			'className' => 'PenTestResultLog',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'HighRiskResultLog' => array(
			'className' => 'HighRiskResultLog',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'HighRiskResult' => array(
			'className' => 'HighRiskResult',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
		'FovResult' => array(
			'className' => 'FovResult',
			'foreignKey' => 'reports_status_id',
			'dependent' => false,
		),
	);
	
	public $actsAs = [
		'ReportsAttribute',
	];
	
	public $cacheQueries = true;
	
	public $searchFields = [
		'ReportsStatus.name',
	];
	
	public $typeFormListOrder = ['id' => 'ASC'];
	
	public $toggleFields = ['show'];
	
	public function getOpenId()
	{
		return $this->field($this->primaryKey, array($this->alias.'.slug' => 'open'));
	}
	
	public function getClosedId()
	{
		return $this->field($this->primaryKey, array($this->alias.'.slug' => 'closed'));
	}
	
	public function getRaId()
	{
		return $this->field($this->primaryKey, array($this->alias.'.slug' => 'risk_accepted'));
	}
}
