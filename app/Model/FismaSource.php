<?php
App::uses('AppModel', 'Model');
/**
 * FismaSource Model
 *
 * @property FismaSystem $FismaSystem
 */
class FismaSource extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'fisma_source_id',
			'dependent' => false,
		)
	);
	
	public function defaultId()
	{
		return $this->field('id', array('default' => true));
	}
}
