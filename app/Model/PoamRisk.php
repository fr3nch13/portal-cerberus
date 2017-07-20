<?php
App::uses('AppModel', 'Model');

class PoamRisk extends AppModel 
{
	public $displayField = 'name';
	
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
			],
		],
		'slug' => [
			'notBlank' => [
				'rule' => ['notBlank'],
			],
		],
	];
	
	public $hasMany = [
		'PoamResultLog' => [
			'className' => 'PoamResultLog',
			'foreignKey' => 'poam_risk_id',
			'dependent' => false,
		],
		'PoamResult' => [
			'className' => 'PoamResult',
			'foreignKey' => 'poam_risk_id',
			'dependent' => false,
		],
	];
	
	public $actsAs = [
		'Poam',
		'Utilities.Common',
	];
	
	public $toggleFields = ['show'];
}
