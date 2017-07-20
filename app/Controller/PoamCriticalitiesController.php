<?php
App::uses('AppController', 'Controller');

class PoamCriticalitiesController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->PoamCriticality->recursive = -1;
		$this->paginate['order'] = array('PoamCriticality.name' => 'asc');
		$this->paginate['conditions'] = $this->PoamCriticality->conditions($conditions, $this->passedArgs); 
		$this->set('poamCriticalities', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->PoamCriticality->create();
			
			if ($this->PoamCriticality->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Criticality')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Criticality')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$poamCriticality = $this->PoamCriticality->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Criticality')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->PoamCriticality->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Criticality')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Criticality')));
			}
		}
		else
		{
			$this->request->data = $poamCriticality;
		}
	}
}
