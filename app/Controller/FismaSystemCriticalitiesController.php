<?php
App::uses('AppController', 'Controller');

class FismaSystemCriticalitiesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemCriticality->recursive = -1;
		$this->paginate['order'] = array('FismaSystemCriticality.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemCriticality->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_criticalities', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemCriticality->create();
			
			if ($this->FismaSystemCriticality->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Criticality')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Criticality')) , $this->FismaSystemCriticality->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_criticality = $this->FismaSystemCriticality->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Criticality')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemCriticality->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Criticality')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Criticality')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_criticality;
		}
	}
}