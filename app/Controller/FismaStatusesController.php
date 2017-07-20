<?php
App::uses('AppController', 'Controller');
/**
 * FismaStatuses Controller
 *
 * @property FismaStatuses $FismaStatuses
 */
class FismaStatusesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaStatus->recursive = -1;
		$this->paginate['order'] = array('FismaStatus.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaStatus->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_statuses', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaStatus->create();
			
			if ($this->FismaStatus->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Status')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Status')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaStatus->id = $id;
		if (!$this->FismaStatus->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Status')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaStatus->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Status')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Status')));
			}
		}
		else
		{
			$this->request->data = $this->FismaStatus->read(null, $id);
		}
	}

	public function admin_default($id = null) 
	{
		$this->FismaStatus->id = $id;
		if (!$this->FismaStatus->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Status')));
		}
		
		// mark all as 0
		if(!$this->FismaStatus->updateAll(array('FismaStatus.default' => false), array('FismaStatus.default' => true)))
		{
			$this->Session->setFlash(__('Unable to set the default %s.', __('FISMA Status')));
			return $this->redirect($this->referer());
		}
		
		$this->FismaStatus->id = $id;
		if ($this->FismaStatus->saveField('default', true)) 
		{
			$this->Session->setFlash(__('Default %s changed.', __('FISMA Status')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Unable to set the default %s.', __('FISMA Status')));
		return $this->redirect($this->referer());
	}
}