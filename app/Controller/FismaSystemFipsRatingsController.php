<?php
App::uses('AppController', 'Controller');

class FismaSystemFipsRatingsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemFipsRating->recursive = -1;
		$this->paginate['order'] = array('FismaSystemFipsRating.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemFipsRating->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_fips_ratings', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemFipsRating->create();
			
			if ($this->FismaSystemFipsRating->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('Fips Rating')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('Fips Rating')) , $this->FismaSystemFipsRating->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSystemFipsRating->id = $id;
		if (!$this->FismaSystemFipsRating->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('Fips Rating')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemFipsRating->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('Fips Rating')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('Fips Rating')) ));
			}
		}
		else
		{
			$this->request->data = $this->FismaSystemFipsRating->read(null, $id);
		}
	}
}