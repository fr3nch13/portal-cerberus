<?php
App::uses('AppModel', 'Model');

class ReportsEvent extends AppModel 
{
	public $displayField = 'name';
	public $order = array('ReportsEvent.event_date' => 'DESC');
	
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'slug' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'shortname' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $hasMany = array(
		'PenTestReport' => array(
			'className' => 'PenTestReport',
			'foreignKey' => 'reports_event_id',
			'dependent' => false,
		),
	);
	
	public $searchFields = array(
		'ReportsEvent.name',
	);
	
	public $checkAddCache = array();
	
	public function checkAdd($name = false, $extra = array())
	{
		if(!$name) return false;
		
		$name = trim($name);
		if(!$name) return false;
		
		$slug = Inflector::slug(strtolower($name));
		if(!$slug) return false;
		
		if(isset($this->checkAddCache[$slug]))
			return $this->checkAddCache[$slug];
		
		if($id = $this->field($this->primaryKey, array($this->alias.'.slug' => $slug)))
		{
			$this->checkAddCache[$slug] = $id;
			return $id;
		}
		
		// not an existing one, create it
		$this->create();
		$this->data = array_merge(array('name' => $name, 'slug' => $slug), $extra);
		if($this->save($this->data, false))
		{
			$this->checkAddCache[$slug] = $this->id;
			return $this->id;
		}
		return false;
	}
}
