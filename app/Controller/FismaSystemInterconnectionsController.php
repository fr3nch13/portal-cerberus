<?php
App::uses('AppController', 'Controller');

class FismaSystemInterconnectionsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemInterconnection->recursive = -1;
		$this->paginate['order'] = array('FismaSystemInterconnection.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemInterconnection->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_interconnections', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemInterconnection->create();
			
			if ($this->FismaSystemInterconnection->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Interconnection')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Interconnection')) , $this->FismaSystemInterconnection->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSystemInterconnection->id = $id;
		if (!$this->FismaSystemInterconnection->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Interconnection')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemInterconnection->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Interconnection')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Interconnection')) ));
			}
		}
		else
		{
			$this->request->data = $this->FismaSystemInterconnection->read(null, $id);
		}
	}
}