<?php
App::uses('AppController', 'Controller');

class FismaSystemThreatAssessmentsController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSystemThreatAssessment->recursive = -1;
		$this->paginate['order'] = array('FismaSystemThreatAssessment.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemThreatAssessment->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_system_threat_assessments', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystemThreatAssessment->create();
			
			if ($this->FismaSystemThreatAssessment->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s - %s', __('FISMA System'), __('FO Threat Assessment')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('%s - %s', __('FISMA System'), __('FO Threat Assessment')) , $this->FismaSystemThreatAssessment->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		if (!$fisma_system_threat_assessment = $this->FismaSystemThreatAssessment->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s - %s', __('FISMA System'), __('FO Threat Assessment')) ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystemThreatAssessment->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('%s - %s', __('FISMA System'), __('FO Threat Assessment')) ));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s - %s', __('FISMA System'), __('FO Threat Assessment')) ));
			}
		}
		else
		{
			$this->request->data = $fisma_system_threat_assessment;
		}
	}
}