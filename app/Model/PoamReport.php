<?php
App::uses('AppModel', 'Model');

class PoamReport extends AppModel 
{
	public $displayField = 'name';
	
	public $order = array('PoamReport.created' => 'DESC');

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
		'report_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $belongsTo = array(
		'PoamReportAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'PoamReportModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
	);
	
	public $hasMany = array(
		'PoamReportFile' => array(
			'className' => 'PoamReportFile',
			'foreignKey' => 'poam_report_id',
			'dependent' => true,
		),
		'PoamReportPoamResult' => array(
			'className' => 'PoamReportPoamResult',
			'foreignKey' => 'poam_report_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'PoamResult' => array(
			'className' => 'PoamResult',
			'joinTable' => 'poam_reports_poam_results',
			'foreignKey' => 'poam_report_id',
			'associationForeignKey' => 'poam_result_id',
			'unique' => 'keepExisting',
			'with' => 'PoamReportPoamResult',
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
		'Usage.Usage' => array(
			'onCreate' => true,
			'onDelete' => true,
		),
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
			),
		),
	);
	
	/// allow the Common App Controller to handle the files
	public $manageUploads = true;
	
	
	public function addReport($data = null)
	{
		$this->modelError = false;
		
		$this->data = $data;
		
		if(!$this->save($this->data))
		{
			$this->modelError = __('Unable to save the actual report.');
			return false;
		}
		
		// add the items from the form to this report 
		if(!$results = $this->PoamResult->importToReport($this->id, $data))
		{
			$this->modelError = $this->PoamResult->modelError;
			return false;
		}
		
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
				$this->alias.'.total' => $this->PoamReportPoamResult->find('count', array(
					'conditions' => array(
						'PoamReportPoamResult.poam_report_id' => $report[$this->alias]['id'],
					),
				)),
			);
		}
		
		return $out;
	}
	
	public function latestReportId()
	{
		if($report = $this->find('first', [
			'recursive' => -1,
			'order' => [$this->alias.'.report_date' => 'DESC'],
		]))
		{
			return $report[$this->alias]['id'];
		}
		return false;
	}
}
