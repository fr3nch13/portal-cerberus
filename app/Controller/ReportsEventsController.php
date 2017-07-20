<?php
App::uses('AppController', 'Controller');

class ReportsEventsController extends AppController 
{
	public $allowAdminDelete = true;

	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->ReportsEvent->recursive = -1;
		$this->paginate['conditions'] = $this->ReportsEvent->conditions($conditions, $this->passedArgs); 
		$this->set('reportsEvents', $this->paginate());
	}
	
	public function view($id = false)
	{
		
		$this->ReportsEvent->id = $id;
		$this->ReportsEvent->recursive = 0;
		if (!$reportsEvent = $this->ReportsEvent->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Reports Event')));
		}
		
		$this->set('reportsEvent', $reportsEvent);
	}

	public function admin_index() 
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
	
	public function admin_view($id = false)
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'view', $id, 'admin' => false));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReportsEvent->create();
			
			if ($this->ReportsEvent->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('Event')));
				return $this->redirect(array('action' => 'index', 'admin' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Event')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$reportsEvent = $this->ReportsEvent->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Event')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReportsEvent->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('Event')));
				return $this->redirect(array('action' => 'index', 'admin' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Event')));
			}
		}
		else
		{
			$this->request->data = $reportsEvent;
		}
	}
}
