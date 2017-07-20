<?php
App::uses('AppController', 'Controller');

class FismaSystemUniquenessesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemUniqueness->recursive = -1;
		$this->paginate['order'] = array('FismaSystemUniqueness.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemUniqueness->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_uniquenesses', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemUniqueness->create();
			
			if ($this->FismaSystemUniqueness->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Uniqueness')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Uniqueness')) , $this->FismaSystemUniqueness->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_uniqueness = $this->FismaSystemUniqueness->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Uniqueness')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemUniqueness->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Uniqueness')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Uniqueness')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_uniqueness;
		}
	}
}