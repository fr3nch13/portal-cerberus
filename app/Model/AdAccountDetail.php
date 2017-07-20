<?php
App::uses('AppModel', 'Model');
class AdAccountDetail extends AppModel 
{
	public $belongsTo = array(
		'AdAccount' => array(
			'className' => 'AdAccount',
			'foreignKey' => 'ad_account_id',
			'multiselect' => true,
			'nameSingle' => 'AD Account',
		),
	);
	
	public function checkAddUpdate($ad_account_id = false, $data = array())
	{
		if(!$ad_account_id) return false;
		
		$id = false;
		if($id = $this->field($this->primaryKey, array($this->alias.'.ad_account_id' => $ad_account_id)))
		{
			$this->id = $id;
			$data['id'] = $id;
		}
		else
		{
			$this->create();
		}
		
		if($data and !isset($data[$this->alias]))
			$data = array($this->alias => $data);
		
		if($data or !$id)
		{
			$data[$this->alias]['ad_account_id'] = $ad_account_id;
			$this->data = $data;
			$this->save($this->data);
		}
		
		return $this->id;
	}
}