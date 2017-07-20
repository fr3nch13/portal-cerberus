<?php
App::uses('AppModel', 'Model');

class EolReport extends AppModel 
{
	public $displayField = 'name';
	
	public $order = array('EolReport.created' => 'DESC');

	public $validate = array(
		'added_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'modified_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $belongsTo = array(
		'AddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'ModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
	);
	
	public $hasMany = array(
		'EolReportFile' => array(
			'className' => 'EolReportFile',
			'foreignKey' => 'eol_report_id',
			'dependent' => true,
		),
		'EolReportEolResult' => array(
			'className' => 'EolReportEolResult',
			'foreignKey' => 'eol_report_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'EolResult' => array(
			'className' => 'EolResult',
			'joinTable' => 'eol_reports_eol_results',
			'foreignKey' => 'eol_report_id',
			'associationForeignKey' => 'eol_result_id',
			'unique' => 'keepExisting',
			'with' => 'EolReportEolResult',
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
	);
	
	/// allow the Common App Controller to handle the files
	public $manageUploads = true;
	
	
	public function addReport($data = null)
	{
		$this->modelError = false;
		
		$this->data = $data;
		if(!$this->save($this->data))
		{
			return false;
		}
		
		// add the items from the form to this report 
		$results = $this->EolResult->importToReport($this->id, $data);
		
		return $results;
	}
	
	public function findForTrend($options = array())
	{
		if(!isset($options['order']))
			$options['order'] = array($this->alias.'.report_date' => 'ASC');
		
		$reports = $this->find('all', $options);
		
		$out = array(
			'legend' => array(
				'day' => __('Day'),
				$this->alias.'.total' => __('Total Results'),
			),
			'data' => array(),
		);
		
		foreach($reports as $i => $report)
		{
			$niceDate = date('M j, Y', strtotime($report[$this->alias]['report_date']));
			$out['data'][$niceDate] = array(
				'day' => $niceDate,
				$this->alias.'.total' => $this->EolReportEolResult->find('count', array(
					'conditions' => array(
						'EolReportEolResult.eol_report_id' => $report[$this->alias]['id'],
					),
				)),
			);
		}
		
		return $out;
	}
}
