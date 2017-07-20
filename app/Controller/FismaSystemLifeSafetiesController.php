<?php
App::uses('AppController', 'Controller');

class FismaSystemLifeSafetiesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->FismaSystemLifeSafety->recursive = -1;
		$this->paginate['order'] = array('FismaSystemLifeSafety.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemLifeSafety->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_life_safeties', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemLifeSafety->create();
			
			if ($this->FismaSystemLifeSafety->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Life Safety Option')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Life Safety Option')) , $this->FismaSystemLifeSafety->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_life_safety = $this->FismaSystemLifeSafety->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Life Safety Option')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemLifeSafety->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Life Safety Option')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Life Safety Option')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_life_safety;
		}
	}
}