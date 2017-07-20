<?php
App::uses('AppController', 'Controller');

class ReportsSeveritiesController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReportsSeverity->recursive = -1;
		$this->paginate['order'] = array('ReportsSeverity.name' => 'asc');
		$this->paginate['conditions'] = $this->ReportsSeverity->conditions($conditions, $this->passedArgs); 
		$this->set('reports_severities', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsSeverity->create();
			
			if ($this->ReportsSeverity->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Severity')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Severity')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reports_severity = $this->ReportsSeverity->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Reports Severity')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsSeverity->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Severity')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Severity')));
			}
		}
		else
		{
			$this->request->data = $reports_severity;
		}
	}
}
