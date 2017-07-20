<?php

class EolSoftwareAlias extends AppModel 
{
	public $displayField = 'name';
	
	public $belongsTo = array(
		'EolSoftware' => array(
			'className' => 'EolSoftware',
			'foreignKey' => 'eol_software_id',
		),
	);
}