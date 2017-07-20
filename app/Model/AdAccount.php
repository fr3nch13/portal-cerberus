<?php
App::uses('AppModel', 'Model');
App::uses('ContactsAdAccount', 'Contacts.Model');

class AdAccount extends ContactsAdAccount 
{	
	public $hasMany = array(
		'OwnerContact' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'owner_contact_id',
			'dependent' => false,
		),
		'AdAccountFismaSystem' => array(
			'className' => 'AdAccountFismaSystem',
			'foreignKey' => 'ad_account_id',
			'dependent' => true,
		),
	);
	
	public $hasOne = array(
		'AdAccountDetail' => array(
			'className' => 'AdAccountDetail',
			'foreignKey' => 'ad_account_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'joinTable' => 'ad_accounts_fisma_systems',
			'foreignKey' => 'ad_account_id',
			'associationForeignKey' => 'fisma_system_id',
			'unique' => 'keepExisting',
			'with' => 'AdAccountFismaSystem',
		),
	);
	
	public $contactTypes = array('owner' => 'OwnerContact');
	
	public function beforeValidate($options = array())
	{
		if(isset($this->data[$this->AdAccountDetail->alias]))
		{
			if(!isset($this->data[$this->AdAccountDetail->alias][$this->AdAccountDetail->primaryKey]))
			{
				if($id = $this->{$this->AdAccountDetail->alias}->checkAddUpdate($this->id, $this->data[$this->AdAccountDetail->alias]))
				{
					$this->data[$this->AdAccountDetail->alias][$this->AdAccountDetail->primaryKey] = $id;
				}
			}
		}
		return parent::beforeValidate();
	}
	
	public function contactTypeField($contactType = 'owner')
	{	
		$contactType = ucfirst(strtolower($contactType)). 'Contact';
		
		if(!isset($this->hasMany[$contactType]))
			return false;
		
		return $this->hasMany[$contactType]['foreignKey'];
	}
}
