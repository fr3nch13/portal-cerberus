<?php
App::uses('AppModel', 'Model');
/**
 * FismaSystemPoam Model
 *
 * @property FismaSystem $FismaSystem
 * @property FismaSystemPoamCompletionStatus $FismaSystemPoamCompletionStatus
 * @property AddedUser $AddedUser
 * @property ModifiedUser $ModifiedUser
 * @property FismaSystemPoamStatusLog $FismaSystemPoamStatusLog
 */
class FismaSystemPoam extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'fisma_system_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'fisma_system_poam_completion_status_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'added_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'modified_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'closed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
		'weakness_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'controls' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'weakness' => array(
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
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
		),
		'FismaSystemPoamCompletionStatus' => array(
			'className' => 'FismaSystemPoamCompletionStatus',
			'foreignKey' => 'fisma_system_poam_completion_status_id',
		),
		'AddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'ModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FismaSystemPoamStatusLog' => array(
			'className' => 'FismaSystemPoamStatusLog',
			'foreignKey' => 'fisma_system_poam_id',
			'dependent' => false,
		)
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('closed');

}
