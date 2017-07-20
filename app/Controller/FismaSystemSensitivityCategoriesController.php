<?php
App::uses('AppController', 'Controller');

class FismaSystemSensitivityCategoriesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemSensitivityCategory->recursive = -1;
		$this->paginate['order'] = array('FismaSystemSensitivityCategory.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemSensitivityCategory->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_sensitivity_categories', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemSensitivityCategory->create();
			
			if ($this->FismaSystemSensitivityCategory->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) , $this->FismaSystemSensitivityCategory->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_sensitivity_category = $this->FismaSystemSensitivityCategory->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemSensitivityCategory->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_sensitivity_category;
		}
	}
}