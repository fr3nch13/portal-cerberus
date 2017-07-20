<?php
App::uses('AppController', 'Controller');

class FismaSystemRiskAssessmentsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemRiskAssessment->recursive = -1;
		$this->paginate['order'] = array('FismaSystemRiskAssessment.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemRiskAssessment->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_risk_assessments', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemRiskAssessment->create();
			
			if ($this->FismaSystemRiskAssessment->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) , $this->FismaSystemRiskAssessment->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSystemRiskAssessment->id = $id;
		if (!$this->FismaSystemRiskAssessment->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemRiskAssessment->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) ));
			}
		}
		else
		{
			$this->request->data = $this->FismaSystemRiskAssessment->read(null, $id);
		}
	}
}