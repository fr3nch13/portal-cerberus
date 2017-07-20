<?php
App::uses('AppController', 'Controller');

class ReportsAssignablePartiesController extends AppController 
{
	public $allowAdminDelete = true;

	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReportsAssignableParty->recursive = -1;
		$this->paginate['order'] = array('ReportsAssignableParty.name' => 'asc');
		$this->paginate['conditions'] = $this->ReportsAssignableParty->conditions($conditions, $this->passedArgs); 
		$this->set('reports_assignable_parties', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsAssignableParty->create();
			
			if ($this->ReportsAssignableParty->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Assignable Party')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Assignable Party')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reports_assignable_party = $this->ReportsAssignableParty->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Reports Assignable Party')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsAssignableParty->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Reports Assignable Party')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Reports Assignable Party')));
			}
		}
		else
		{
			$this->request->data = $reports_assignable_party;
		}
	}
}
