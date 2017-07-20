<?php
App::uses('AppModel', 'Model');

class FismaSystemThreatAssessment extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_threat_assessment_id',
			'dependent' => false,
		)
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystemThreatAssessment.name',
	);
	
	public function beforeSave($options = array()) 
	{
		// only if it is a new one
		if(isset($this->data[$this->alias]['name']) and !isset($this->data[$this->alias]['slug']) and !isset($this->data[$this->alias]['id']) and !$this->id)
		{
			$this->data[$this->alias]['slug'] = $this->slugify($this->data[$this->alias]['name']);
		}
		
		return parent::beforeSave($options);
	}
	
	public function checkAdd($name = false, $extra = array())
	{
		if(!$name) return false;
		
		$name = trim($name);
		if(!$name) return false;
		
		$slug = $this->slugify($name);
		
		if($id = $this->field($this->primaryKey, array($this->alias.'.slug' => $slug)))
		{
			return $id;
		}
		
		// not an existing one, create it
		$this->create();
		$this->data = array_merge(array('name' => $name, 'slug' => $slug), $extra);
		if($this->save($this->data))
		{
			return $this->id;
		}
		return false;
	}
}
