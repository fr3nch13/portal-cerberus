<?php
App::uses('AppModel', 'Model');
/**
 * Firewall Model
 *
 * @property Rule $Rule
 */
class Protocol extends AppModel 
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
		'Firewall' => array(
			'className' => 'Firewall',
			'foreignKey' => 'firewall_id',
		),
		'ProtocolAddedUser' => array(
			'className' => 'HostAlias',
			'foreignKey' => 'added_user_id',
		),
	);
	
	public $hasMany = array(
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'protocol_id',
			'dependent' => false,
		),
		'Pog' => array(
			'className' => 'Pog',
			'foreignKey' => 'protocol_id',
			'dependent' => false,
		)
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('simple');
	
	// define the fields that can be searched
	public $searchFields = array(
		'Protocol.name',
	);
}
