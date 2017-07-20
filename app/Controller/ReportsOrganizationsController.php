<?php
App::uses('AppController', 'Controller');

class ReportsOrganizationsController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReportsOrganization->recursive = -1;
		$this->paginate['order'] = array('ReportsOrganization.name' => 'asc');
		$this->paginate['conditions'] = $this->ReportsOrganization->conditions($conditions, $this->passedArgs); 
		$this->set('reportsOrganizations', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsOrganization->create();
			
			if ($this->ReportsOrganization->saveAssociated($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('Organization')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Organization')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reportsOrganization = $this->ReportsOrganization->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Organization')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsOrganization->saveAssociated($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('Organization')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Organization')));
			}
		}
		else
		{
			$this->request->data = $reportsOrganization;
		}
	}
}
