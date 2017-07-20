<?php
App::uses('AppModel', 'Model');
/**
 * FismaSystemPoamStatusLog Model
 *
 * @property FismaSystemPoam $FismaSystemPoam
 * @property User $User
 */
class FismaSystemPoamStatusLog extends AppModel 
{

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'fisma_system_poam_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'status' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'FismaSystemPoam' => array(
			'className' => 'FismaSystemPoam',
			'foreignKey' => 'fisma_system_poam_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);
}
