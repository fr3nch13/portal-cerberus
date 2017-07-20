<?php
App::uses('AppModel', 'Model');
class EolReportEolResult extends AppModel 
{
	public $useTable = 'eol_reports_eol_results';
	
	public $order = array('EolReportEolResult.created' => 'DESC');
	
	public $validate = array(
		'eol_report_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'eol_result_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	
	public $belongsTo = array(
		'EolReport' => array(
			'className' => 'EolReport',
			'foreignKey' => 'eol_report_id',
		),
		'EolResult' => array(
			'className' => 'EolResult',
			'foreignKey' => 'eol_result_id',
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
		'PhpPdf.PhpPdf', 
		'Utilities.Extractor',
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'EolResult.ip_address',
		'EolResult.host_name',
		'EolResult.mac_address',
		'EolResult.netbios',
		'EolReport.name',
	);
	
	public function saveAssociatedReports($eol_result_id = false, $eol_report_ids = array(), $eol_report_xref_data = array())
	{
		if(!$eol_report_ids) $eol_report_ids = array();
		
		// remove the existing records (incase they add a eol_report that is already associated with this eol_result)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('EolReportEolResult.id', 'EolReportEolResult.eol_report_id'),
			'conditions' => array(
				'EolReportEolResult.eol_result_id' => $eol_result_id,
			),
		));
		
		// get just the new ones
		$eol_report_ids = array_diff($eol_report_ids, $existing);
		
		// build the proper save array
		$data = array();
		foreach($eol_report_ids as $eol_report => $eol_report_id)
		{
			$data[$eol_report] = array('eol_result_id' => $eol_result_id, 'eol_report_id' => $eol_report_id, 'active' => 1);
			if(isset($eol_report_xref_data[$eol_report]))
			{
				$data[$eol_report] = array_merge($eol_report_xref_data[$eol_report], $data[$eol_report]);
			}
		}
		return $this->saveMany($data);
	}
	
	public function saveAssociatedResults($eol_report_id = false, $eol_result_ids = array(), $eol_result_xref_data = array())
	{
		if(!$eol_result_ids) $eol_result_ids = array();
		
		// remove the existing records (incase they add a eol_result that is already associated with this eol_report)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('EolReportEolResult.id', 'EolReportEolResult.eol_result_id'),
			'conditions' => array(
				'EolReportEolResult.eol_report_id' => $eol_report_id,
			),
		));
		
		// get just the new ones
		$eol_result_ids = array_diff($eol_result_ids, $existing);
		
		if($eol_result_ids)
		{
			// build the proper save array
			$data = array();
			foreach($eol_result_ids as $eol_result => $eol_result_id)
			{
				$data[$eol_result] = array('eol_report_id' => $eol_report_id, 'eol_result_id' => $eol_result_id, 'active' => 1);
				if(isset($eol_result_xref_data[$eol_result]))
				{
					$data[$eol_result] = array_merge($eol_result_xref_data[$eol_result], $data[$eol_result]);
				}
			}
			return $this->saveMany($data);
		}
		return true;
	}
	
	public function updateNewDuplicates($eol_report_id = false, $eol_result_data = array(), $modified_user_id = false)
	{
	//// updates the eol results, then makes sure they have an xref record 
		
		$result_ids = (isset($eol_result_data['all_ids']['id'])?$eol_result_data['all_ids']['id']:array());
		foreach($eol_result_data['EolReport'] as $eol_result)
		{
			if(isset($eol_result['EolResult']['new']) and $eol_result['EolResult']['new'])
			{
				unset($eol_result['EolResult']['new']);
				
				if(isset($eol_result['EolResult']['id']))
				{
					$existing_eol_result = $this->EolResult->read(null, $eol_result['EolResult']['id']);
					
					unset($eol_result['EolResult']['id']);
					unset($existing_eol_result['EolResult']['id']);
					unset($existing_eol_result['EolResult']['modified']);
					unset($existing_eol_result['EolResult']['modified_user_id']);
					unset($existing_eol_result['EolResult']['eol_software_id']);
					$eol_result['EolResult'] = array_merge($existing_eol_result['EolResult'], $eol_result['EolResult']);
					
				}
					
				$this->EolResult->create();
				$eol_result['EolResult']['created'] = date('Y-m-d H:i:s');
				$eol_result['EolResult']['added_user_id'] = $modified_user_id;
			}
			else
			{
				$this->EolResult->id = $eol_result['EolResult']['id'];
				$eol_result['EolResult']['modified'] = date('Y-m-d H:i:s');
				$eol_result['EolResult']['modified_user_id'] = $modified_user_id;
			}
			
			$this->EolResult->data = $eol_result;
			$this->EolResult->save($this->EolResult->data);
			$result_ids[$this->EolResult->id] = $this->EolResult->id;
		}
		
		// make sure we have the xref records
		return $this->saveAssociatedResults($eol_report_id, $result_ids);
	}
}
