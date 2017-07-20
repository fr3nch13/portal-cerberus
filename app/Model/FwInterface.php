<?php
App::uses('AppModel', 'Model');
/**
 * Firewall Model
 *
 * @property Rule $Rule
 */
class FwInterface extends AppModel 
{

	public $displayField = 'name';

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'slug' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
			),
		),
	);
	
	public $belongsTo = array(
		'Import' => array(
			'className' => 'Import',
			'foreignKey' => 'import_id',
		),
	);
	
	public $hasMany = array(
		'FwInt' => array(
			'className' => 'FwInt',
			'foreignKey' => 'fw_interface_id',
			'dependent' => false,
		),
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'fw_interface_id',
			'dependent' => false,
		),
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('simple');
	
	// define the fields that can be searched
	public $searchFields = array(
		'FwInterface.name',
	);
}
