<?php
App::uses('AppModel', 'Model');
/**
 * PogLog Model
 *
 * @property Pog $Pog
 * @property Rule $Rule
 */
class PogLog extends AppModel
{
	public $validate = array(
		'pog_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'Pog' => array(
			'className' => 'Pog',
			'foreignKey' => 'pog_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);
	
	public $order = array("PogLog.created" => "asc");
	
	// define the fields that can be searched
	public $searchFields = array(
		'PogLog.name',
		'PogLog.ports',
		'PogLog.old_name',
		'PogLog.old_ports',
	);
}
