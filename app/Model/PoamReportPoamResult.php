<?php
App::uses('AppModel', 'Model');
class PoamReportPoamResult extends AppModel 
{
	public $useTable = 'poam_reports_poam_results';
	
	public $order = array('PoamReportPoamResult.created' => 'DESC');
	
	public $validate = array(
		'poam_report_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'poam_result_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'PoamReport' => array(
			'className' => 'PoamReport',
			'foreignKey' => 'poam_report_id',
		),
		'PoamResult' => array(
			'className' => 'PoamResult',
			'foreignKey' => 'poam_result_id',
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
		'PhpExcel.PhpExcel',
		'Utilities.Extractor',
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'PoamReport.name',
	);
	
	public function saveAssociatedReports($poam_result_id = false, $poam_report_ids = array(), $poam_report_xref_data = array())
	{
		if(!$poam_report_ids) $poam_report_ids = array();
		
		// remove the existing records (incase they add a poam_report that is already associated with this poam_result)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('PoamReportPoamResult.id', 'PoamReportPoamResult.poam_report_id'),
			'conditions' => array(
				'PoamReportPoamResult.poam_result_id' => $poam_result_id,
			),
		));
		
		// get just the new ones
		$poam_report_ids = array_diff($poam_report_ids, $existing);
		
		// build the proper save array
		$data = array();
		foreach($poam_report_ids as $poam_report => $poam_report_id)
		{
			$data[$poam_report] = array('poam_result_id' => $poam_result_id, 'poam_report_id' => $poam_report_id, 'active' => 1);
			if(isset($poam_report_xref_data[$poam_report]))
			{
				$data[$poam_report] = array_merge($poam_report_xref_data[$poam_report], $data[$poam_report]);
			}
		}
		return $this->saveMany($data);
	}
	
	public function saveAssociatedResults($poam_report_id = false, $poam_result_ids = array(), $poam_result_xref_data = array())
	{
		if(!$poam_result_ids) $poam_result_ids = array();
		
		// remove the existing records (incase they add a poam_result that is already associated with this poam_report)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('PoamReportPoamResult.id', 'PoamReportPoamResult.poam_result_id'),
			'conditions' => array(
				'PoamReportPoamResult.poam_report_id' => $poam_report_id,
			),
		));
		
		// get just the new ones
		$poam_result_ids = array_diff($poam_result_ids, $existing);
		
		if($poam_result_ids)
		{
			// build the proper save array
			$data = array();
			foreach($poam_result_ids as $poam_result => $poam_result_id)
			{
				$data[$poam_result] = array('poam_report_id' => $poam_report_id, 'poam_result_id' => $poam_result_id, 'active' => 1);
				if(isset($poam_result_xref_data[$poam_result]))
				{
					$data[$poam_result] = array_merge($poam_result_xref_data[$poam_result], $data[$poam_result]);
				}
			}
			return $this->saveMany($data);
		}
		return true;
	}
	
	public function updateNewDuplicates($poam_report_id = false, $poam_result_data = array(), $modified_user_id = false)
	{
	//// updates the poam results, then makes sure they have an xref record 
		
		$result_ids = (isset($poam_result_data['all_ids']['id'])?$poam_result_data['all_ids']['id']:array());
		foreach($poam_result_data['PoamReport'] as $poam_result)
		{
			if(isset($poam_result['PoamResult']['new']) and $poam_result['PoamResult']['new'])
			{
				unset($poam_result['PoamResult']['new']);
				
				if(isset($poam_result['PoamResult']['id']))
				{
					$existing_poam_result = $this->PoamResult->read(null, $poam_result['PoamResult']['id']);
					
					unset($poam_result['PoamResult']['id']);
					unset($existing_poam_result['PoamResult']['id']);
					unset($existing_poam_result['PoamResult']['modified']);
					unset($existing_poam_result['PoamResult']['modified_user_id']);
					unset($existing_poam_result['PoamResult']['eol_software_id']);
					$poam_result['PoamResult'] = array_merge($existing_poam_result['PoamResult'], $poam_result['PoamResult']);
					
				}
					
				$this->PoamResult->create();
				$poam_result['PoamResult']['created'] = date('Y-m-d H:i:s');
				$poam_result['PoamResult']['added_user_id'] = $modified_user_id;
			}
			else
			{
				$this->PoamResult->id = $poam_result['PoamResult']['id'];
				$poam_result['PoamResult']['modified'] = date('Y-m-d H:i:s');
				$poam_result['PoamResult']['modified_user_id'] = $modified_user_id;
			}
			
			$this->PoamResult->data = $poam_result;
			$this->PoamResult->save($this->PoamResult->data);
			$result_ids[$this->PoamResult->id] = $this->PoamResult->id;
		}
		
		// make sure we have the xref records
		return $this->saveAssociatedResults($poam_report_id, $result_ids);
	}
}
