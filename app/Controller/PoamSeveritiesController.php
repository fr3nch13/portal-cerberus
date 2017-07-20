<?php
App::uses('AppController', 'Controller');

class PoamSeveritiesController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->PoamSeverity->recursive = -1;
		$this->paginate['order'] = array('PoamSeverity.name' => 'asc');
		$this->paginate['conditions'] = $this->PoamSeverity->conditions($conditions, $this->passedArgs); 
		$this->set('poamSeverities', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->PoamSeverity->create();
			
			if ($this->PoamSeverity->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Severity')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Severity')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$poamSeverity = $this->PoamSeverity->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Severity')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->PoamSeverity->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Severity')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Severity')));
			}
		}
		else
		{
			$this->request->data = $poamSeverity;
		}
	}
}
