<?php
App::uses('AppController', 'Controller');

class FismaSystemAmountsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemAmount->recursive = -1;
		$this->paginate['order'] = array('FismaSystemAmount.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemAmount->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_amounts', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemAmount->create();
			
			if ($this->FismaSystemAmount->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Amount')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Amount')) , $this->FismaSystemAmount->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_amount = $this->FismaSystemAmount->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Amount')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemAmount->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Amount')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Amount')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_amount;
		}
	}
}