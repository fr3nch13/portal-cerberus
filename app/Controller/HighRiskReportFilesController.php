<?php
App::uses('AppController', 'Controller');

class HighRiskReportFilesController extends AppController 
{
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		); 
		
		$this->HighRiskReportFile->recursive = 0;
		$this->paginate['conditions'] = $this->HighRiskReportFile->conditions($conditions, $this->passedArgs); 
		
		$this->paginate['order'] = array('HighRiskReportFile.created' => 'desc');
		$this->set('high_risk_report_files', $this->paginate());
	}
	
	public function high_risk_report($high_risk_report_id = null)
	{
		$this->Prg->commonProcess();
		
		if (!$high_risk_report = $this->HighRiskReportFile->HighRiskReport->read(null, $high_risk_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		$this->set('high_risk_report', $high_risk_report);
		
		$conditions = array(
			'HighRiskReportFile.high_risk_report_id' => $high_risk_report_id,
		); 
		
		$this->paginate['conditions'] = $this->HighRiskReportFile->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->HighRiskReportFile->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('HighRiskReportFile.created' => 'desc');
		$this->set('high_risk_report_files', $this->paginate());
	}
	
	public function add($high_risk_report_id = null) 
	{
		if (!$high_risk_report = $this->HighRiskReportFile->HighRiskReport->read(null, $high_risk_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		$this->set('high_risk_report', $high_risk_report);
		
		$this->request->data[$this->HighRiskReportFile->alias]['high_risk_report_id'] = $high_risk_report_id;
		$this->request->data[$this->HighRiskReportFile->alias]['user_id'] = AuthComponent::user('id');
		
		if ($this->request->is('post')) 
		{
			$this->HighRiskReportFile->create();
			if ($this->HighRiskReportFile->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved.', __('%s %s', __('High Risk Report'), __('File'))));
				return $this->redirect(array('controller' => 'high_risk_reports', 'action' => 'view', $high_risk_report_id, '#' => 'ui-tabs-2'));
			}
			else
			{
				$this->Flash->error(__('The %s file could not be saved. Reason: %s', __('%s %s', __('High Risk Report'), __('File')), $this->HighRiskReportFile->modelError));
			}
		}
	}
	
	public function edit($id = null) 
	{
		$this->HighRiskReportFile->recursive = -1;
		if (!$high_risk_report_file = $this->HighRiskReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('High Risk Report'), __('File'))));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->HighRiskReportFile->save($this->request->data))
			{
				$this->Flash->success(__('The 5s has been saved.', __('%s %s', __('High Risk Report'), __('File'))));
				return $this->redirect(array('controller' => 'high_risk_reports', 'action' => 'view', $high_risk_report_file['HighRiskReportFile']['high_risk_report_id'], '#' => 'ui-tabs-2'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('%s %s', __('High Risk Report'), __('File'))));
			}
		}
		else
		{
			$this->request->data = $high_risk_report_file;
		}
	}
	
	public function delete($id = null)
	{
		$this->HighRiskReportFile->recursive = -1;
		if (!$high_risk_report_file = $this->HighRiskReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('High Risk Report'), __('File'))));
		}
		
		if ($this->HighRiskReportFile->delete())
		{
			$this->Flash->success(__('The %s has been deleted.', __('%s %s', __('High Risk Report'), __('File'))));
		}
		else
		{
			$this->Flash->error(__('The %s could not be deleted. Please, try again.', __('%s %s', __('High Risk Report'), __('File'))));
		}
		
		return $this->redirect(array('controller' => 'high_risk_reports', 'action' => 'view', $high_risk_report_file['HighRiskReportFile']['high_risk_report_id'], '#' => 'ui-tabs-2'));
	}
	
	public function admin_high_risk_report($high_risk_report_id = null)
	{
		return $this->high_risk_report($high_risk_report_id);
	}
}
