<?php
App::uses('AppModel', 'Model');

class FismaSystemFileState extends AppModel 
{
	public $displayField = 'name';
	public $hasMany = array(
		'FismaSystemFile' => array(
			'className' => 'FismaSystemFile',
			'foreignKey' => 'fisma_system_file_state_id',
			'dependent' => false,
		),
	);
}
