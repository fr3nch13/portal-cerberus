<?php
App::uses('AppController', 'Controller');

class FismaSystemSensitivityRatingsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemSensitivityRating->recursive = -1;
		$this->paginate['order'] = array('FismaSystemSensitivityRating.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemSensitivityRating->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_sensitivity_ratings', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemSensitivityRating->create();
			
			if ($this->FismaSystemSensitivityRating->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Sensitivity Rating')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Sensitivity Rating')) , $this->FismaSystemSensitivityRating->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_sensitivity_rating = $this->FismaSystemSensitivityRating->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Sensitivity Rating')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemSensitivityRating->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Sensitivity Rating')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Sensitivity Rating')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_sensitivity_rating;
		}
	}
}