<?php
App::uses('AppModel', 'Model');

class FismaContactType extends AppModel
{
	public $displayField = 'name';
	
	public $order = array("FismaContactType.primary_priority" => "asc");
	
	public $hasMany = array(
		'AdAccountFismaSystem' => array(
			'className' => 'AdAccountFismaSystem',
			'foreignKey' => 'fisma_contact_type_id',
			'dependent' => false,
		)
	);
	
	public $defaultFields = array('is_saa', 'is_tech', 'is_daa', 'is_isso');
	
	public function checkAdd($slug = false, $extra = array())
	{
		if(!$slug) return false;
		
		$slug = trim($slug);
		if(!$slug) return false;
		
		$slug = strtoupper($slug);
		
		if($id = $this->field($this->primaryKey, array($this->alias.'.slug' => $slug)))
		{
			return $id;
		}
		
		if(!isset($extra['created']))
			$extra['created'] = date('Y-m-d H:i:s');
		
		// not an existing one, create it
		$this->create();
		$this->data = array_merge(array('slug' => $slug), $extra);
		if($this->save($this->data))
		{
			return $this->id;
		}
		return false;
	}
	
	public function getDaaId()
	{
		if($id = $this->field($this->primaryKey, array($this->alias.'.is_daa' => true)))
		{
			return $id;
		}
		return false;
	}
	
	public function getDaaName()
	{
		if($id = $this->field('name', array($this->alias.'.is_daa' => true)))
		{
			return $id;
		}
		return false;
	}
	
	public function getIssoId()
	{
		if($id = $this->field($this->primaryKey, array($this->alias.'.is_isso' => true)))
		{
			return $id;
		}
		return false;
	}
	
	public function getIssoName()
	{
		if($id = $this->field('name', array($this->alias.'.is_isso' => true)))
		{
			return $id;
		}
		return false;
	}
	
	public function getSaaId()
	{
		if($id = $this->field($this->primaryKey, array($this->alias.'.is_saa' => true)))
		{
			return $id;
		}
		return false;
	}
	
	public function getSaaName()
	{
		if($id = $this->field('name', array($this->alias.'.is_saa' => true)))
		{
			return $id;
		}
		return false;
	}
	
	public function getTechId()
	{
		if($id = $this->field($this->primaryKey, array($this->alias.'.is_tech' => true)))
		{
			return $id;
		}
		return false;
	}
	
	public function getTechName()
	{
		if($id = $this->field('name', array($this->alias.'.is_tech' => true)))
		{
			return $id;
		}
		return false;
	}
}
