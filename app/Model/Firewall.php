<?php
App::uses('AppModel', 'Model');
/**
 * Firewall Model
 *
 * @property Rule $Rule
 */
class Firewall extends AppModel 
{

	public $displayField = 'name';
	public $slugField = 'hostname';

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
		'Import' => array(
			'className' => 'Import',
			'foreignKey' => 'import_id',
		),
		'FirewallAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'FirewallModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
	);
	
	public $hasMany = array(
		'FwInt' => array(
			'className' => 'FwInt',
			'foreignKey' => 'firewall_id',
			'dependent' => false,
		),
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'firewall_id',
			'dependent' => false,
		),
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('simple');
	
	// define the fields that can be searched
	public $searchFields = array(
		'Firewall.name',
	);
}
