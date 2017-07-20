<?php
App::uses('AppModel', 'Model');
/**
 * FismaType Model
 *
 * @property FismaSystem $FismaSystem
 */
class FismaType extends AppModel 
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'fisma_type_id',
			'dependent' => false,
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaType.name',
	);
	
	public function defaultId()
	{
		return $this->field('id', array('default' => true));
	}
}
