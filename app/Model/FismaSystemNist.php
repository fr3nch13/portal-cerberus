<?php
App::uses('AppModel', 'Model');

class FismaSystemNist extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_nist_id',
			'dependent' => false,
		)
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystemNist.name',
	);
}
