<?php
App::uses('AppController', 'Controller');

class ReportsRemediationsController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReportsRemediation->recursive = -1;
		$this->paginate['order'] = array('ReportsRemediation.name' => 'asc');
		$this->paginate['conditions'] = $this->ReportsRemediation->conditions($conditions, $this->passedArgs); 
		$this->set('reports_remediations', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsRemediation->create();
			
			if ($this->ReportsRemediation->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Remediation')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Remediation')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reports_remediation = $this->ReportsRemediation->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Reports Remediation')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsRemediation->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Remediation')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Remediation')));
			}
		}
		else
		{
			$this->request->data = $reports_remediation;
		}
	}
}
