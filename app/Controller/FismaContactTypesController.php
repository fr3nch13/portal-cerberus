<?php

App::uses('AppController', 'Controller');
class FismaContactTypesController extends AppController 
{

	public $allowAdminDelete = true;
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->FismaContactType->recursive = -1;
		$this->paginate['conditions'] = $this->FismaContactType->conditions($conditions, $this->passedArgs); 
		$fisma_contact_types = $this->paginate();
		
		$crm = array();
		$owner = array();
		$this->set(compact('fisma_contact_types', 'crm', 'owner'));
	}

	public function view($id = null) 
	{
		$this->FismaContactType->recursive = 0;
		if(!$fisma_contact_type = $this->FismaContactType->read(null, $id))
		{
			throw new NotFoundException(__('Unknown %s', __('%s %s', __('FISMA Contact'), __('Types'))));
		}
		$this->set('fisma_contact_type', $fisma_contact_type);
	}
	
	public function admin_index()
	{
		$this->bypassReferer = false;
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaContactType->create();
			
			if ($this->FismaContactType->save($this->request->data))
			{
				$this->Flash->success(__('The %s %s has been saved.', __('FISMA Contact'), __('Type')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s %s could not be saved. Please, try again. %s', __('FISMA Contact'), __('Type'), $this->FismaContactType->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaContactType->id = $id;
		if (!$this->FismaContactType->exists()) 
		{
			throw new NotFoundException(__('Invalid %s %s', __('FISMA Contact Type'), __('Type')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaContactType->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s %s has been saved', __('FISMA Contact'), __('Type')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s %s could not be saved. Please, try again.', __('FISMA Contact'), __('Type')));
			}
		}
		else
		{
			$this->request->data = $this->FismaContactType->read(null, $id);
		}
	}
	
	public function admin_setdefault($field = null, $id = null)
	{
	/*
	 * Used to mark an object as the primary/default one
	 */
		if ($this->FismaContactType->defaultRecord($id, $field))
		{
			$this->Flash->success(__('The %s %s has been saved', __('FISMA Contact'), __('Type')));
		}
		else
		{
			$this->Flash->error($this->FismaContactType->modelError);
		}
		
		return $this->redirect($this->referer());
	}
}