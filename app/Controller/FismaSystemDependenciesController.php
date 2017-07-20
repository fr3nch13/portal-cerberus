<?php
App::uses('AppController', 'Controller');

class FismaSystemDependenciesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemDependency->recursive = -1;
		$this->paginate['order'] = array('FismaSystemDependency.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemDependency->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_dependencies', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemDependency->create();
			
			if ($this->FismaSystemDependency->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Dependency')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Dependency')) , $this->FismaSystemDependency->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_dependency = $this->FismaSystemDependency->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Dependency')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemDependency->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Dependency')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Dependency')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_dependency;
		}
	}
}