<?php
App::uses('AppModel', 'Model');

class FismaSoftwareGroup extends AppModel
{
	public $displayField = 'name';
	
	public $order = array("FismaSoftwareGroup.name" => "asc");
	
	public $hasMany = array(
		'FismaSoftware' => array(
			'className' => 'FismaSoftware',
			'foreignKey' => 'fisma_software_group_id',
			'dependent' => false,
		)
	);
}
