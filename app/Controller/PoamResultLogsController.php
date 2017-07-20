<?php
class PoamResultLogsController extends AppController 
{
	public function poam_result($id = null) 
	{
		if (!$poamResult = $this->PoamResultLog->PoamResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Result')));
		}
		$this->set('poamResult', $poamResult);
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'PoamResultLog.poam_result_id' => $id,
		); 
		
		$this->paginate['conditions'] = $this->PoamResultLog->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->PoamResultLog->recursive = -1;
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->PoamResultLog->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->set('poamResultLogs', $this->paginate());
	}
	
	public function saveAssociatedResults($poam_report_id = false, $poam_result_ids = array(), $poam_result_xref_data = array())
	{
		if(!$poam_result_ids) $poam_result_ids = array();
		
		// remove the existing records (incase they add a poam_result that is already associated with this us_report)
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
}