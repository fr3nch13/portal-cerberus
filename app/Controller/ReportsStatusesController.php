<?php
App::uses('AppController', 'Controller');

class ReportsStatusesController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->ReportsStatus->recursive = -1;
		$this->paginate['order'] = array('ReportsStatus.name' => 'asc');
		$this->paginate['conditions'] = $this->ReportsStatus->conditions($conditions, $this->passedArgs); 
		$this->set('reports_statuses', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsStatus->create();
			
			if ($this->ReportsStatus->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('Reports Status')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Reports Status')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reports_status = $this->ReportsStatus->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Reports Status')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsStatus->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('Reports Status')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Reports Status')));
			}
		}
		else
		{
			$this->request->data = $reports_status;
		}
	}
}
