<?php
App::uses('AppModel', 'Model');
/**
 * UsReportFile Model
 *
 * @property UsReport $UsReport
 * @property User $User
 */
class UsReportFile extends AppModel 
{
	public $displayField = 'filename';
	
	public $validate = array(
		'us_report_id' => array(
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
		'UsReport' => array(
			'className' => 'UsReport',
			'foreignKey' => 'us_report_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'UsReport.name',
		'UsReportFile.nicename',
		'UsReportFile.filename',
	);
	
	/// allow the Common App Controller to handle the files
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
