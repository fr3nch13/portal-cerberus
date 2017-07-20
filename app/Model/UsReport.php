<?php
App::uses('AppModel', 'Model');

class UsReport extends AppModel 
{
	public $displayField = 'name';
	
	public $order = array('UsReport.created' => 'DESC');

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
		'UsReportFile' => array(
			'className' => 'UsReportFile',
			'foreignKey' => 'us_report_id',
			'dependent' => true,
		),
		'UsReportUsResult' => array(
			'className' => 'UsReportUsResult',
			'foreignKey' => 'us_report_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'UsResult' => array(
			'className' => 'UsResult',
			'joinTable' => 'us_reports_us_results',
			'foreignKey' => 'us_report_id',
			'associationForeignKey' => 'us_result_id',
			'unique' => 'keepExisting',
			'with' => 'UsReportUsResult',
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
			$this->modelError = __('Unable to save the actual Report.');
			return false;
		}
		
		$reportId = $this->id;
		
		$queueId = $this->Q_createJob('ProcessUsReport', $this->id);
		$this->id = $reportId;
		$this->saveField('queued_task_id', $queueId);
		
		return true;
	}
	
	public function proccessReportTask($id = false, $queueId = false)
	{
		$this->modelError = false;
		$this->UsResult->queueId = $queueId;
		
		$this->shellOut(__('Processing US Report with id: %s.', $id));
		
		// make sure the report actually exists since this runs in a seperate process
		if(!$report = $this->read(null, $id))
		{
			$this->modelError = __('This report no longer exists.');
			return false;
		}
		
		// add the items from the form to this report 
		if(!$results = $this->UsResult->importToReport($id))
		{
			$this->modelError = $this->UsResult->modelError;
			return false;
		}
		
		$results['auto_closed_ids'] = $this->UsResult->autoClose();
		
		// update the counter cache of us results to their software
		$this->UsResult->EolSoftware->updateUsResultCounterCache();
		
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
				$this->alias.'.total' => $this->UsReportUsResult->find('count', array(
					'conditions' => array(
						'UsReportUsResult.us_report_id' => $report[$this->alias]['id'],
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
	
	public function previousReportId($id = false)
	{
		if(!$id)
			return false;
		
		$this->id = $id;
		if(!$report_date = $this->field('report_date'))
			return false;
		
		if($report = $this->find('first', [
			'recursive' => -1,
			'conditions' => [$this->alias.'.report_date < ' => $report_date],
			'order' => [$this->alias.'.report_date' => 'DESC'],
		]))
		{
			return $report[$this->alias]['id'];
		}
		return false;
	}
	
	public function listForDashboard()
	{
		$reports = $this->find('list', [
			'recursive' => -1,
			'order' => [$this->alias.'.report_date' => 'DESC'],
		]);
		return $reports;
	}
}
