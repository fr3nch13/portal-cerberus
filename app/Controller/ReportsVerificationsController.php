<?php
App::uses('AppController', 'Controller');

class ReportsVerificationsController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReportsVerification->recursive = -1;
		$this->paginate['order'] = array('ReportsVerification.name' => 'asc');
		$this->paginate['conditions'] = $this->ReportsVerification->conditions($conditions, $this->passedArgs); 
		$this->set('reports_verifications', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsVerification->create();
			
			if ($this->ReportsVerification->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Verification')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Verification')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reports_verification = $this->ReportsVerification->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Reports Verification')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsVerification->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Verification')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Verification')));
			}
		}
		else
		{
			$this->request->data = $reports_verification;
		}
	}
}
