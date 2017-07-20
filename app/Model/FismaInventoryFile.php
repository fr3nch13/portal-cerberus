<?php
App::uses('AppModel', 'Model');
/**
 * FismaInventoryFile Model
 *
 * @property FismaInventory $FismaInventory
 * @property User $User
 */
class FismaInventoryFile extends AppModel 
{
	public $displayField = 'filename';
	
	public $validate = array(
		'fisma_inventory_id' => array(
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
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'fisma_inventory_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);
	
	public $actsAs = array(
		'Usage.Usage' => array(
			'onCreate' => true,
			'onDelete' => true,
		),
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
				$nicename = Inflector::underscore($nicename);
				$nicename = Inflector::humanize($nicename);
				
				$this->data[$this->alias]['nicename'] = $nicename;
			}
		}
	}
}
