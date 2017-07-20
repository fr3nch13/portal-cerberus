<?php
App::uses('AppModel', 'Model');
App::uses('Host', 'Model');

class HostLog extends Host 
{
	public $useTable = 'host_logs';
	
	public $belongsTo = array(
		'Host' => array(
			'className' => 'Host',
			'foreignKey' => 'host_id',
		),
	);
	
	/// overwrite some fuctions from host that we don't need here
	public function afterFind($results = array(), $primary = false)
	{
		return true;
	}
	
	public function beforeSave($options = array()) 
	{
		return true;
	}
	
	public function afterSave($created = false, $options = array())
	{
		return true;
	}
	
	public function logChanges($host_id = false, $old = array())
	{
		if($host_id and isset($old[$this->Host->alias]) and is_array($old[$this->Host->alias]) and $old[$this->Host->alias])
		{
			if(isset($old[$this->Host->alias]['id'])) unset($old[$this->Host->alias]['id']);
			$old[$this->Host->alias]['host_id'] = $host_id;
			
			$this->create();
			$this->data = $old[$this->Host->alias];
			return $this->save($this->data);
		}
	}
}