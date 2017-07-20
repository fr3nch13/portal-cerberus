<?php
App::uses('AppController', 'Controller');

class FismaSystemComTotalsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemComTotal->recursive = -1;
		$this->paginate['order'] = array('FismaSystemComTotal.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemComTotal->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_com_totals', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemComTotal->create();
			
			if ($this->FismaSystemComTotal->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Communications Total')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Communications Total')) , $this->FismaSystemComTotal->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_com_total = $this->FismaSystemComTotal->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Communications Total')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemComTotal->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Communications Total')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Communications Total')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_com_total;
		}
	}
}