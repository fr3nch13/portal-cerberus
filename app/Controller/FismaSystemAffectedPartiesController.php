<?php
App::uses('AppController', 'Controller');

class FismaSystemAffectedPartiesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemAffectedParty->recursive = -1;
		$this->paginate['order'] = array('FismaSystemAffectedParty.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemAffectedParty->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_affected_parties', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemAffectedParty->create();
			
			if ($this->FismaSystemAffectedParty->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Affected Party')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Affected Party')) , $this->FismaSystemAffectedParty->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_affected_party = $this->FismaSystemAffectedParty->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Affected Party')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemAffectedParty->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Affected Party')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Affected Party')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_affected_party;
		}
	}
}