<?php
App::uses('AppModel', 'Model');
/**
 * FismaSystemPoamCompletionStatus Model
 *
 * @property FismaSystemPoam $FismaSystemPoam
 */
class FismaSystemPoamCompletionStatus extends AppModel 
{

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FismaSystemPoam' => array(
			'className' => 'FismaSystemPoam',
			'foreignKey' => 'fisma_system_poam_completion_status_id',
			'dependent' => false,
		)
	);

}
