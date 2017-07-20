<?php
App::uses('AppController', 'Controller');

class PoamReportFilesController extends AppController 
{
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		); 
		
		$this->PoamReportFile->recursive = 0;
		$this->paginate['conditions'] = $this->PoamReportFile->conditions($conditions, $this->passedArgs); 
		
		$this->paginate['order'] = array('PoamReportFile.created' => 'desc');
		$this->set('poamReportFiles', $this->paginate());
	}
	
	public function poam_report($poam_report_id = null) 
	{
		$this->Prg->commonProcess();
		
		if (!$poamReport = $this->PoamReportFile->PoamReport->read(null, $poam_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Report')));
		}
		$this->set('poamReport', $poamReport);
		
		$conditions = array(
			'PoamReportFile.poam_report_id' => $poam_report_id,
		); 
		
		$this->paginate['conditions'] = $this->PoamReportFile->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->PoamReportFile->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('PoamReportFile.created' => 'desc');
		$this->set('poamReportFiles', $this->paginate());
	}
	
	public function add($poam_report_id = null) 
	{
		
		if (!$poamReport = $this->PoamReportFile->PoamReport->read(null, $poam_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Report')));
		}
		$this->set('poamReport', $poamReport);
		
		$this->request->data[$this->PoamReportFile->alias]['poam_report_id'] = $poam_report_id;
		$this->request->data[$this->PoamReportFile->alias]['user_id'] = AuthComponent::user('id');
		
		if ($this->request->is('post')) 
		{
			$this->PoamReportFile->create();
			if ($this->PoamReportFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s', __('POA&M Report'), __('File'))));
				return $this->redirect(array('controller' => 'poam_reports', 'action' => 'view', $poam_report_id, 'tab' => 'attachments'));
			}
			else
			{
				$this->Session->setFlash(__('The %s file could not be saved. Reason: %s', __('%s %s', __('POA&M Report'), __('File')), $this->PoamReportFile->modelError));
			}
		}
	}
	
	public function edit($id = null) 
	{
		$this->PoamReportFile->recursive = -1;
		if (!$poamReportFile = $this->PoamReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('POA&M Report'), __('File'))));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->PoamReportFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s', __('POA&M Report'), __('File'))));
				return $this->redirect(array('controller' => 'poam_reports', 'action' => 'view', $poamReportFile['PoamReportFile']['poam_report_id'], 'tab' => 'attachments'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s %s', __('POA&M Report'), __('File'))));
			}
		}
		else
		{
			$this->request->data = $poamReportFile;
		}
	}
	
	public function delete($id = null)
	{
		$this->PoamReportFile->recursive = -1;
		if (!$poamReportFile = $this->PoamReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('POA&M Report'), __('File'))));
		}
		
		if ($this->PoamReportFile->delete())
		{
			$this->Session->setFlash(__('The %s has been deleted.', __('%s %s', __('POA&M Report'), __('File'))));
		}
		else
		{
			$this->Session->setFlash(__('The %s could not be deleted. Please, try again.', __('%s %s', __('POA&M Report'), __('File'))));
		}
		
		return $this->redirect(array('controller' => 'poam_reports', 'action' => 'view', $poamReportFile['PoamReportFile']['poam_report_id'], 'tab' => 'attachments'));
	}
}
