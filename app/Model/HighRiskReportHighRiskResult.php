<?php
App::uses('AppModel', 'Model');
class HighRiskReportHighRiskResult extends AppModel 
{
	public $useTable = 'high_risk_reports_high_risk_results';
	
	public $order = array('HighRiskReportHighRiskResult.created' => 'DESC');
	
	public $validate = array(
		'high_risk_report_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'high_risk_result_id' => array(
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
		'HighRiskResult' => array(
			'className' => 'HighRiskResult',
			'foreignKey' => 'high_risk_result_id',
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
		'PhpExcel.PhpExcel',
		'Utilities.Extractor',
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'HighRiskResult.ip_address',
		'HighRiskResult.host_name',
		'HighRiskResult.vulnerability',
		'HighRiskReport.name',
	);
	
	public function saveAssociatedReports($high_risk_result_id = false, $high_risk_report_ids = array(), $high_risk_report_xref_data = array())
	{
		if(!$high_risk_report_ids) $high_risk_report_ids = array();
		
		// remove the existing records (incase they add a high_risk_report that is already associated with this high_risk_result)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('HighRiskReportHighRiskResult.id', 'HighRiskReportHighRiskResult.high_risk_report_id'),
			'conditions' => array(
				'HighRiskReportHighRiskResult.high_risk_result_id' => $high_risk_result_id,
			),
		));
		
		// get just the new ones
		$high_risk_report_ids = array_diff($high_risk_report_ids, $existing);
		
		// build the proper save array
		$data = array();
		foreach($high_risk_report_ids as $high_risk_report => $high_risk_report_id)
		{
			$data[$high_risk_report] = array('high_risk_result_id' => $high_risk_result_id, 'high_risk_report_id' => $high_risk_report_id, 'active' => 1);
			if(isset($high_risk_report_xref_data[$high_risk_report]))
			{
				$data[$high_risk_report] = array_merge($high_risk_report_xref_data[$high_risk_report], $data[$high_risk_report]);
			}
		}
		return $this->saveMany($data);
	}
	
	public function saveAssociatedResults($high_risk_report_id = false, $high_risk_result_ids = array(), $high_risk_result_xref_data = array())
	{
		if(!$high_risk_result_ids) $high_risk_result_ids = array();
		
		// remove the existing records (incase they add a high_risk_result that is already associated with this high_risk_report)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('HighRiskReportHighRiskResult.id', 'HighRiskReportHighRiskResult.high_risk_result_id'),
			'conditions' => array(
				'HighRiskReportHighRiskResult.high_risk_report_id' => $high_risk_report_id,
			),
		));
		
		// get just the new ones
		$high_risk_result_ids = array_diff($high_risk_result_ids, $existing);
		
		if($high_risk_result_ids)
		{
			// build the proper save array
			$data = array();
			foreach($high_risk_result_ids as $high_risk_result => $high_risk_result_id)
			{
				$data[$high_risk_result] = array('high_risk_report_id' => $high_risk_report_id, 'high_risk_result_id' => $high_risk_result_id, 'active' => 1);
				if(isset($high_risk_result_xref_data[$high_risk_result]))
				{
					$data[$high_risk_result] = array_merge($high_risk_result_xref_data[$high_risk_result], $data[$high_risk_result]);
				}
			}
			return $this->saveMany($data);
		}
		return true;
	}
	
	public function updateNewDuplicates($high_risk_report_id = false, $high_risk_result_data = array(), $modified_user_id = false)
	{
	//// updates the high_risk results, then makes sure they have an xref record 
		
		$result_ids = (isset($high_risk_result_data['all_ids']['id'])?$high_risk_result_data['all_ids']['id']:array());
		foreach($high_risk_result_data['HighRiskReport'] as $high_risk_result)
		{
			if(isset($high_risk_result['HighRiskResult']['new']) and $high_risk_result['HighRiskResult']['new'])
			{
				unset($high_risk_result['HighRiskResult']['new']);
				
				if(isset($high_risk_result['HighRiskResult']['id']))
				{
					$existing_high_risk_result = $this->HighRiskResult->read(null, $high_risk_result['HighRiskResult']['id']);
					
					unset($high_risk_result['HighRiskResult']['id']);
					unset($existing_high_risk_result['HighRiskResult']['id']);
					unset($existing_high_risk_result['HighRiskResult']['modified']);
					unset($existing_high_risk_result['HighRiskResult']['modified_user_id']);
					unset($existing_high_risk_result['HighRiskResult']['high_risk_software_id']);
					$high_risk_result['HighRiskResult'] = array_merge($existing_high_risk_result['HighRiskResult'], $high_risk_result['HighRiskResult']);
					
				}
					
				$this->HighRiskResult->create();
				$high_risk_result['HighRiskResult']['created'] = date('Y-m-d H:i:s');
				$high_risk_result['HighRiskResult']['added_user_id'] = $modified_user_id;
			}
			else
			{
				$this->HighRiskResult->id = $high_risk_result['HighRiskResult']['id'];
				$high_risk_result['HighRiskResult']['modified'] = date('Y-m-d H:i:s');
				$high_risk_result['HighRiskResult']['modified_user_id'] = $modified_user_id;
			}
			$this->HighRiskResult->data = $high_risk_result;
			$this->HighRiskResult->save($this->HighRiskResult->data);
			$result_ids[$this->HighRiskResult->id] = $this->HighRiskResult->id;
		}
		
		// make sure we have the xref records
		return $this->saveAssociatedResults($high_risk_report_id, $result_ids);
	}
}
