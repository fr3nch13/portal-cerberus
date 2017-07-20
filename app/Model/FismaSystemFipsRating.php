<?php
App::uses('AppModel', 'Model');

class FismaSystemFipsRating extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_fips_rating_id',
			'dependent' => false,
		)
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystemFipsRating.name',
	);
}
