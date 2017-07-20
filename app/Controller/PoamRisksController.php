<?php
App::uses('AppController', 'Controller');

class PoamRisksController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->PoamRisk->recursive = -1;
		$this->paginate['order'] = array('PoamRisk.name' => 'asc');
		$this->paginate['conditions'] = $this->PoamRisk->conditions($conditions, $this->passedArgs); 
		$this->set('poamRisks', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->PoamRisk->create();
			
			if ($this->PoamRisk->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Risk')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Risk')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$poamRisk = $this->PoamRisk->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Risk')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->PoamRisk->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Risk')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Risk')));
			}
		}
		else
		{
			$this->request->data = $poamRisk;
		}
	}
}
