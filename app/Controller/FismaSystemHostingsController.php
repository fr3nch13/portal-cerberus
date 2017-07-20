<?php
App::uses('AppController', 'Controller');

class FismaSystemHostingsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemHosting->recursive = -1;
		$this->paginate['order'] = array('FismaSystemHosting.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemHosting->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_hostings', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemHosting->create();
			
			if ($this->FismaSystemHosting->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('AHE Hosting')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('AHE Hosting')) , $this->FismaSystemHosting->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSystemHosting->id = $id;
		if (!$this->FismaSystemHosting->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('AHE Hosting')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemHosting->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('AHE Hosting')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('AHE Hosting')) ));
			}
		}
		else
		{
			$this->request->data = $this->FismaSystemHosting->read(null, $id);
		}
	}
}