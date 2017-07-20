<?php
App::uses('AppController', 'Controller');

class FismaSystemNihloginsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemNihlogin->recursive = -1;
		$this->paginate['order'] = array('FismaSystemNihlogin.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemNihlogin->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_nihlogins', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemNihlogin->create();
			
			if ($this->FismaSystemNihlogin->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('NIH login')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('NIH Login')), $this->FismaSystemNihlogin->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_nihlogin = $this->FismaSystemNihlogin->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('NIH Login')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemNihlogin->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('NIH login')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('NIH Login')), $this->FismaSystemNihlogin->modelError ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_nihlogin;
		}
	}
}