<?php
App::uses('AppModel', 'Model');
class UsReportUsResult extends AppModel 
{
	public $useTable = 'us_reports_us_results';
	
	public $order = array('UsReportUsResult.created' => 'DESC');
	
	public $validate = array(
		'us_report_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'us_result_id' => array(
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
		'UsResult' => array(
			'className' => 'UsResult',
			'foreignKey' => 'us_result_id',
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
		'PhpPdf.PhpPdf', 
		'Utilities.Extractor',
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'UsResult.ip_address',
		'UsResult.host_name',
		'UsResult.mac_address',
		'UsResult.netbios',
		'UsReport.name',
	);
	
	public function saveAssociatedReports($us_result_id = false, $us_report_ids = array(), $us_report_xref_data = array())
	{
		if(!$us_report_ids) $us_report_ids = array();
		
		// remove the existing records (incase they add a us_report that is already associated with this us_result)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('UsReportUsResult.id', 'UsReportUsResult.us_report_id'),
			'conditions' => array(
				'UsReportUsResult.us_result_id' => $us_result_id,
			),
		));
		
		// get just the new ones
		$us_report_ids = array_diff($us_report_ids, $existing);
		
		// build the proper save array
		$data = array();
		foreach($us_report_ids as $us_report => $us_report_id)
		{
			$data[$us_report] = array('us_result_id' => $us_result_id, 'us_report_id' => $us_report_id, 'active' => 1);
			if(isset($us_report_xref_data[$us_report]))
			{
				$data[$us_report] = array_merge($us_report_xref_data[$us_report], $data[$us_report]);
			}
		}
		return $this->saveMany($data);
	}
	
	public function saveAssociatedResults($us_report_id = false, $us_result_ids = array(), $us_result_xref_data = array())
	{
		if(!$us_result_ids) $us_result_ids = array();
		
		// remove the existing records (incase they add a us_result that is already associated with this us_report)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('UsReportUsResult.id', 'UsReportUsResult.us_result_id'),
			'conditions' => array(
				'UsReportUsResult.us_report_id' => $us_report_id,
			),
		));
		
		// get just the new ones
		$us_result_ids = array_diff($us_result_ids, $existing);
		
		if($us_result_ids)
		{
			// build the proper save array
			$data = array();
			foreach($us_result_ids as $us_result => $us_result_id)
			{
				$data[$us_result] = array('us_report_id' => $us_report_id, 'us_result_id' => $us_result_id, 'active' => 1);
				if(isset($us_result_xref_data[$us_result]))
				{
					$data[$us_result] = array_merge($us_result_xref_data[$us_result], $data[$us_result]);
				}
			}
			return $this->saveMany($data);
		}
		return true;
	}
	
	public function updateNewDuplicates($us_report_id = false, $us_result_data = array(), $modified_user_id = false)
	{
	//// updates the us results, then makes sure they have an xref record 
		
		$result_ids = (isset($us_result_data['all_ids']['id'])?$us_result_data['all_ids']['id']:array());
		foreach($us_result_data['UsReport'] as $us_result)
		{
			if(isset($us_result['UsResult']['new']) and $us_result['UsResult']['new'])
			{
				unset($us_result['UsResult']['new']);
				
				if(isset($us_result['UsResult']['id']))
				{
					$existing_us_result = $this->UsResult->read(null, $us_result['UsResult']['id']);
					
					unset($us_result['UsResult']['id']);
					unset($existing_us_result['UsResult']['id']);
					unset($existing_us_result['UsResult']['modified']);
					unset($existing_us_result['UsResult']['modified_user_id']);
					unset($existing_us_result['UsResult']['eol_software_id']);
					$us_result['UsResult'] = array_merge($existing_us_result['UsResult'], $us_result['UsResult']);
					
				}
					
				$this->UsResult->create();
				$us_result['UsResult']['created'] = date('Y-m-d H:i:s');
				$us_result['UsResult']['added_user_id'] = $modified_user_id;
			}
			else
			{
				$this->UsResult->id = $us_result['UsResult']['id'];
				$us_result['UsResult']['modified'] = date('Y-m-d H:i:s');
				$us_result['UsResult']['modified_user_id'] = $modified_user_id;
			}
			
			$this->UsResult->data = $us_result;
			$this->UsResult->save($this->UsResult->data);
			$result_ids[$this->UsResult->id] = $this->UsResult->id;
		}
		
		// make sure we have the xref records
		return $this->saveAssociatedResults($us_report_id, $result_ids);
	}
	
	public function getResultIdsForReport($reportId = false)
	{
		if(!$reportId)
			return [];
		
		return $this->find('list', [
			'conditions' => [
				$this->alias.'.us_report_id' => $reportId,
			],
			'fields' => [$this->alias.'.us_result_id', $this->alias.'.us_result_id'],
		]);
	}
}
