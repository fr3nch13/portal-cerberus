<?php
App::uses('AppController', 'Controller');

class ReportsSystemTypesController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReportsSystemType->recursive = -1;
		$this->paginate['order'] = array('ReportsSystemType.name' => 'asc');
		$this->paginate['conditions'] = $this->ReportsSystemType->conditions($conditions, $this->passedArgs); 
		$this->set('reports_system_types', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsSystemType->create();
			
			if ($this->ReportsSystemType->saveAssociated($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('Reports System Type')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Reports System Type')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reports_system_type = $this->ReportsSystemType->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Reports System Type')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsSystemType->saveAssociated($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('Reports System Type')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Reports System Type')));
			}
		}
		else
		{
			$this->request->data = $reports_system_type;
		}
	}
}
