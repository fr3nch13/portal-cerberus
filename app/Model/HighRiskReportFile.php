<?php
App::uses('AppModel', 'Model');
/**
 * HighRiskReportFile Model
 *
 * @property HighRiskReport $HighRiskReport
 * @property User $User
 */
class HighRiskReportFile extends AppModel 
{
	public $displayField = 'filename';
	
	public $validate = array(
		'high_risk_report_id' => array(
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
		'HighRiskReport' => array(
			'className' => 'HighRiskReport',
			'foreignKey' => 'high_risk_report_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'HighRiskReport.name',
		'HighRiskReportFile.nicename',
		'HighRiskReportFile.filename',
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
