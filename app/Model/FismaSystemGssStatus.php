<?php
App::uses('AppModel', 'Model');

class FismaSystemGssStatus extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_gss_status_id',
			'dependent' => false,
		)
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystemGssStatus.name',
	);
}
