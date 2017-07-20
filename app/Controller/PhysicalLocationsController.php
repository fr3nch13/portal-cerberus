<?php
App::uses('AppController', 'Controller');

class PhysicalLocationsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->paginate['conditions'] = $this->PhysicalLocation->conditions($conditions, $this->passedArgs); 
		
		$physicalLocation = $this->paginate();
		$this->set('physicalLocations', $physicalLocation);
	}

	public function view($id = false)
	{
		if(!$physicalLocation = $this->PhysicalLocation->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Physical Location')));
		}
		
		$this->set('physicalLocation', $physicalLocation);
	}
	
	public function saa_add() 
	{
		if ($this->request->is('post'))
		{
			$this->PhysicalLocation->create();
			
			if ($this->PhysicalLocation->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('Physical Location')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Physical Location')));
			}
		}
		
		$fismaSystems = $this->PhysicalLocation->FismaSystem->find('list');
		$this->set(compact('fismaSystems'));
	}
	
	public function saa_edit($id = null) 
	{
		if(!$physicalLocation = $this->PhysicalLocation->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Physical Location')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->PhysicalLocation->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('Physical Location')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Physical Location')));
			}
		}
		else
		{
			$this->request->data = $physicalLocation;
		}
		
		$fismaSystems = $this->PhysicalLocation->FismaSystem->find('list');
		$this->set(compact('fismaSystems'));
	}
}
