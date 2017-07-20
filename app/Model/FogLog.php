<?php
App::uses('AppModel', 'Model');
/**
 * FogLog Model
 *
 * @property Fog $Fog
 * @property Rule $Rule
 */
class FogLog extends AppModel
{
	public $validate = array(
		'fog_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'Fog' => array(
			'className' => 'Fog',
			'foreignKey' => 'fog_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);
	
	public $order = array("FogLog.created" => "asc");
	
	// define the fields that can be searched
	public $searchFields = array(
		'FogLog.name',
		'FogLog.ip_addresses',
		'FogLog.old_name',
		'FogLog.old_ip_addresses',
	);
}
