<?php
App::uses('AppModel', 'Model');

class FismaStatus extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'fisma_status_id',
			'dependent' => false,
		)
	);
	
	public function defaultId()
	{
		return $this->field('id', array('default' => true));
	}
}
