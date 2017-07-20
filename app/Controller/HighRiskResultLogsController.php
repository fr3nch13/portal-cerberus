<?php
class HighRiskResultLogsController extends AppController 
{
	public function high_risk_result($id = null) 
	{
		if (!$high_risk_result = $this->HighRiskResultLog->HighRiskResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		$this->set('high_risk_result', $high_risk_result);
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'HighRiskResultLog.high_risk_result_id' => $id,
		); 
		
		$this->paginate['conditions'] = $this->HighRiskResultLog->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->HighRiskResultLog->recursive = -1;
			$this->paginate['limit'] = $this->HighRiskResultLog->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->HighRiskResultLog->recursive = 0;
		$this->set('high_risk_result_logs', $this->paginate());
		
		$reportsAssignableParties = $this->HighRiskResultLog->ReportsAssignableParty->typeFormList();
		$reportsRemediations = $this->HighRiskResultLog->ReportsRemediation->typeFormList();
		$reportsStatuses = $this->HighRiskResultLog->ReportsStatus->typeFormList();
		$reportsSystemTypes = $this->HighRiskResultLog->ReportsSystemType->typeFormList();
		$reportsVerifications = $this->HighRiskResultLog->ReportsVerification->typeFormList();
		$multiselectOptions = $this->HighRiskResultLog->multiselectOptions(false, true);
		$this->set(compact(array(
			'reportsAssignableParties', 'reportsRemediations', 
			'reportsStatuses', 'reportsSystemTypes',
			'reportsVerifications', 'multiselectOptions'
		)));
	}
}