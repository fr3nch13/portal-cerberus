<?php
App::uses('AppController', 'Controller');

class FismaSystemFileStatesController extends AppController 
{

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemFileState->recursive = -1;
		$this->paginate['order'] = array('FismaSystemFileState.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemFileState->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_file_states', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemFileState->create();
			
			if ($this->FismaSystemFileState->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA System File')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA System File')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_file_state = $this->FismaSystemFileState->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System File')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemFileState->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA System File')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA System File')));
			}
		}
		else
		{
			$this->request->data = $fisma_system_file_state;
		}
	}

//
	public function admin_delete($id = null) 
	{
		$this->FismaSystemFileState->id = $id;
		if (!$this->FismaSystemFileState->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System File')));
		}

		if ($this->FismaSystemFileState->delete()) 
		{
			$this->Session->setFlash(__('%s deleted', __('FISMA System File')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('%s was not deleted', __('FISMA System File')));
		return $this->redirect($this->referer());
	}
}
