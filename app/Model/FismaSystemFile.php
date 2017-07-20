<?php
App::uses('AppModel', 'Model');
/**
 * FismaSystemFile Model
 *
 * @property FismaSystem $FismaSystem
 * @property User $User
 */
class FismaSystemFile extends AppModel 
{
	public $displayField = 'filename';
	
	public $validate = array(
		'fisma_system_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'FismaSystemFileState' => array(
			'className' => 'FismaSystemFileState',
			'foreignKey' => 'fisma_system_file_state_id',
		),
	);
	
	public $actsAs = array(
		'Usage.Usage' => array(
			'onCreate' => true,
			'onDelete' => true,
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystem.name',
		'FismaSystemFile.nicename',
		'FismaSystemFile.filename',
		'FismaSystemFileState.name',
	);
	
	public $manageUploads = true;
	
	
	public function beforeSave($options = array()) 
	{
		if(isset($this->data[$this->alias]['nicename']) and !trim($this->data[$this->alias]['nicename']))
		{
			if(isset($this->data[$this->alias]['filename']))
			{
				$nicename = $this->data[$this->alias]['filename'];
				if(stripos($nicename, '.') !== false)
				{
					$fileparts = explode('.', $nicename);
					array_pop($fileparts);
					$nicename = implode('.', $fileparts);
				}
				$nicename = strtolower($nicename);
				$nicename = ucwords($nicename);
				$nicename = Inflector::underscore($nicename);
				$nicename = Inflector::humanize($nicename);
				
				$this->data[$this->alias]['nicename'] = $nicename;
			}
		}
	}
}
