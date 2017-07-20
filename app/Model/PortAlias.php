<?php
App::uses('AppModel', 'Model');
/**
 * Firewall Model
 *
 * @property Rule $Rule
 */
class PortAlias extends AppModel 
{

	public $displayField = 'alias';

	public $validate = array(
		'alias' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'port' => array(
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
		'Port' => array(
			'className' => 'Port',
			'foreignKey' => 'port_id',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'PortAlias.port',
		'PortAlias.alias',
	);
}
