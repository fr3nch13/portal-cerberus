<?php
App::uses('AppModel', 'Model');

class FismaSystemHosting extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_hosting_id',
			'dependent' => false,
		)
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystemHosting.name',
	);
}
