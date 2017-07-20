<?php
App::uses('AppController', 'Controller');

class FismaSystemNistsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemNist->recursive = -1;
		$this->paginate['order'] = array('FismaSystemNist.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemNist->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_nists', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemNist->create();
			
			if ($this->FismaSystemNist->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('NIST')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('NIST')) , $this->FismaSystemNist->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSystemNist->id = $id;
		if (!$this->FismaSystemNist->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('NIST')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemNist->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('NIST')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('NIST')) ));
			}
		}
		else
		{
			$this->request->data = $this->FismaSystemNist->read(null, $id);
		}
	}
}