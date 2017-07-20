<?php
App::uses('AppController', 'Controller');

class EolReportFilesController extends AppController 
{
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		); 
		
		$this->EolReportFile->recursive = 0;
		$this->paginate['conditions'] = $this->EolReportFile->conditions($conditions, $this->passedArgs); 
		
		$this->paginate['order'] = array('EolReportFile.created' => 'desc');
		$this->set('eol_report_files', $this->paginate());
	}
	
	public function eol_report($eol_report_id = null) 
	{
		$this->Prg->commonProcess();
		
		if (!$eol_report = $this->EolReportFile->EolReport->read(null, $eol_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Report')));
		}
		$this->set('eol_report', $eol_report);
		
		$conditions = array(
			'EolReportFile.eol_report_id' => $eol_report_id,
		); 
		
		$this->paginate['conditions'] = $this->EolReportFile->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->EolReportFile->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('EolReportFile.created' => 'desc');
		$this->set('eol_report_files', $this->paginate());
	}
	
	public function add($eol_report_id = null) 
	{
		
		if (!$eol_report = $this->EolReportFile->EolReport->read(null, $eol_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Report')));
		}
		$this->set('eol_report', $eol_report);
		
		$this->request->data[$this->EolReportFile->alias]['eol_report_id'] = $eol_report_id;
		$this->request->data[$this->EolReportFile->alias]['user_id'] = AuthComponent::user('id');
		
		if ($this->request->is('post')) 
		{
			$this->EolReportFile->create();
			if ($this->EolReportFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s', __('EOL Report'), __('File'))));
				return $this->redirect(array('controller' => 'eol_reports', 'action' => 'view', $eol_report_id, '#' => 'ui-tabs-2'));
			}
			else
			{
				$this->Session->setFlash(__('The %s file could not be saved. Reason: %s', __('%s %s', __('EOL Report'), __('File')), $this->EolReportFile->modelError));
			}
		}
	}
	
	public function edit($id = null) 
	{
		$this->EolReportFile->recursive = -1;
		if (!$eol_report_file = $this->EolReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('EOL Report'), __('File'))));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->EolReportFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s', __('EOL Report'), __('File'))));
				return $this->redirect(array('controller' => 'eol_reports', 'action' => 'view', $eol_report_file['EolReportFile']['eol_report_id'], '#' => 'ui-tabs-2'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s %s', __('EOL Report'), __('File'))));
			}
		}
		else
		{
			$this->request->data = $eol_report_file;
		}
	}
	
	public function delete($id = null)
	{
		$this->EolReportFile->recursive = -1;
		if (!$eol_report_file = $this->EolReportFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('EOL Report'), __('File'))));
		}
		
		if ($this->EolReportFile->delete())
		{
			$this->Session->setFlash(__('The %s has been deleted.', __('%s %s', __('EOL Report'), __('File'))));
		}
		else
		{
			$this->Session->setFlash(__('The %s could not be deleted. Please, try again.', __('%s %s', __('EOL Report'), __('File'))));
		}
		
		return $this->redirect(array('controller' => 'eol_reports', 'action' => 'view', $eol_report_file['EolReportFile']['eol_report_id'], '#' => 'ui-tabs-2'));
	}
	
	public function admin_eol_report($eol_report_id = null)
	{
		return $this->eol_report($eol_report_id);
	}
}
