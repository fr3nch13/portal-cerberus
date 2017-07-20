<?php
App::uses('AppController', 'Controller');

class FismaSystemGssStatusesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemGssStatus->recursive = -1;
		$this->paginate['order'] = array('FismaSystemGssStatus.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemGssStatus->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_gss_statuses', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemGssStatus->create();
			
			if ($this->FismaSystemGssStatus->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('GSS Status')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('GSS Status')) , $this->FismaSystemGssStatus->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSystemGssStatus->id = $id;
		if (!$this->FismaSystemGssStatus->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('GSS Status')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemGssStatus->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('GSS Status')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('GSS Status')) ));
			}
		}
		else
		{
			$this->request->data = $this->FismaSystemGssStatus->read(null, $id);
		}
	}
}