<?php
App::uses('AppController', 'Controller');

class FismaSystemImpactsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemImpact->recursive = -1;
		$this->paginate['order'] = array('FismaSystemImpact.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemImpact->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_impacts', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemImpact->create();
			
			if ($this->FismaSystemImpact->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Impact')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Impact')) , $this->FismaSystemImpact->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_impact = $this->FismaSystemImpact->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Impact')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemImpact->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Impact')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Impact')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_impact;
		}
	}
}