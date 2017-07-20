<?php
App::uses('AppController', 'Controller');

class PoamStatusesController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->PoamStatus->recursive = -1;
		$this->paginate['order'] = array('PoamStatus.name' => 'asc');
		$this->paginate['conditions'] = $this->PoamStatus->conditions($conditions, $this->passedArgs); 
		$this->set('poamStatuses', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->PoamStatus->create();
			
			if ($this->PoamStatus->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Status')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Status')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$poamStatus = $this->PoamStatus->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Status')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->PoamStatus->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Status')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Status')));
			}
		}
		else
		{
			$this->request->data = $poamStatus;
		}
	}
}
