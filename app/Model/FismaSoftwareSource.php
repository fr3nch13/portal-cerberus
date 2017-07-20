<?php
App::uses('AppModel', 'Model');

class FismaSoftwareSource extends AppModel
{
	public $displayField = 'name';
	
	public $order = array("FismaSoftwareSource.name" => "asc");
	
	public $hasMany = array(
		'FismaSoftware' => array(
			'className' => 'FismaSoftware',
			'foreignKey' => 'fisma_software_source_id',
			'dependent' => false,
		)
	);
	
	public function checkAdd($name = false, $extra = array())
	{
		if(!$name) return false;
		
		$name = trim($name);
		if(!$name) return false;
		
		$slug = Inflector::slug(strtolower($name));
		
		if($id = $this->field($this->primaryKey, array($this->alias.'.slug' => $slug)))
		{
			return $id;
		}
		
		// not an existing one, create it
		$this->create();
		$this->data = array_merge(array('name' => $name, 'slug' => $slug, 'approved' => false), $extra);
		if($this->save($this->data))
		{
			return $this->id;
		}
		return false;
	}
}
