<?php
App::uses('AppController', 'Controller');

class UsReportFilesController extends AppController 
{
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		); 
		
		$this->UsReportFile->recursive = 0;
		$this->paginate['conditions'] = $this->UsReportFile->conditions($conditions, $this->passedArgs); 
		
		$this->paginate['order'] = array('UsReportFile.created' => 'desc');
		$this->set('us_report_files', $this->paginate());
	}
	
	public function us_report($us_report_id = null) 
	{
		$this->Prg->commonProcess();
		
		if (!$us_report = $this->UsReportFile->UsReport->read(null, $us_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		$this->set('us_report', $us_report);
		
		$conditions = array(
			'UsReportFile.us_report_id' => $us_report_id,
		); 
		
		$this->paginate['conditions'] = $this->UsReportFile->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->UsReportFile->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('UsReportFile.created' => 'desc');
		$this->set('us_report_files', $this->paginate());
	}
	
	public function add($us_report_id = null) 
	{
		
		if (!$us_report = $this->UsReportFile->UsReport->read(null, $us_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		$this->set('us_report', $us_report);
		
		$this->request->data[$this->UsReportFile->alias]['us_report_id'] = $us_report_id;
		$this->request->data[$this->UsReportFile->alias]['user_id'] = AuthComponent::user('id');
		
		if ($this->request->is('post')) 
		{
			$this->UsReportFile->create();
			if ($this->UsReportFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s', __('US Report'), __('File'))));
				return $this->redirect(array('controller' => 'us_reports', 'action' => 'view', $us_report_id, '#' => 'ui-tabs-2'));
			}
			else
			{
				$this->Session->setFlash(__('The %s file could not be saved. Reason: %s', __('%s %s', __('US Report'), __('File')), $this->UsReportFile->modelError));
			}
		}
	}
	
	public function edit($id = null) 
	{
		$this->UsReportFile->recursive = -1;
		if (!$us_report_file = $this->UsReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('US Report'), __('File'))));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->UsReportFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s', __('US Report'), __('File'))));
				return $this->redirect(array('controller' => 'us_reports', 'action' => 'view', $us_report_file['UsReportFile']['us_report_id'], '#' => 'ui-tabs-2'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s %s', __('US Report'), __('File'))));
			}
		}
		else
		{
			$this->request->data = $us_report_file;
		}
	}
	
	public function delete($id = null)
	{
		$this->UsReportFile->recursive = -1;
		if (!$us_report_file = $this->UsReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('US Report'), __('File'))));
		}
		
		if ($this->UsReportFile->delete())
		{
			$this->Session->setFlash(__('The %s has been deleted.', __('%s %s', __('US Report'), __('File'))));
		}
		else
		{
			$this->Session->setFlash(__('The %s could not be deleted. Please, try again.', __('%s %s', __('US Report'), __('File'))));
		}
		
		return $this->redirect(array('controller' => 'us_reports', 'action' => 'view', $us_report_file['UsReportFile']['us_report_id'], '#' => 'ui-tabs-2'));
	}
	
	public function admin_us_report($us_report_id = null)
	{
		return $this->us_report($us_report_id);
	}
}
