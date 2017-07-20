<?php
App::uses('AppController', 'Controller');
/**
 * FismaSystemPoamStatusLogs Controller
 *
 * @property FismaSystemPoamStatusLog $FismaSystemPoamStatusLog
 * @property PaginatorComponent $Paginator
 */
class FismaSystemPoamStatusLogsController extends AppController 
{
	public function fisma_system_poam($id = null) 
	{
		$this->FismaSystemPoamStatusLog->FismaSystemPoam->id = $id;
		if (!$this->FismaSystemPoamStatusLog->FismaSystemPoam->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('FISMA System'), __('POAM'))));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'FismaSystemPoamStatusLog.fisma_system_poam_id' => $id,
		); 
		
		$this->FismaSystemPoamStatusLog->FismaSystemPoam->recursive = -1;
		$this->set('fisma_system_poam', $this->FismaSystemPoamStatusLog->FismaSystemPoam->read(null, $id));
		
		$this->paginate['conditions'] = $this->FismaSystemPoamStatusLog->conditions($conditions, $this->passedArgs); 
		
		$this->FismaSystemPoamStatusLog->recursive=0;
		$this->paginate['order'] = array('FismaSystemPoamStatusLog.created' => 'desc');
		$this->set('fisma_system_poam_status_logs', $this->paginate());
	}
	
	public function saa_add($fisma_system_poam_id = null) 
	{
		if (!$this->FismaSystemPoamStatusLog->FismaSystemPoam->exists($fisma_system_poam_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('FISMA System'), __('POAM'))));
		}
		
		$this->request->data[$this->FismaSystemPoamStatusLog->alias]['fisma_system_poam_id'] = $fisma_system_poam_id;
		$this->request->data[$this->FismaSystemPoamStatusLog->alias]['user_id'] = AuthComponent::user('id');
		
		if ($this->request->is('post')) 
		{
			$this->FismaSystemPoamStatusLog->create();
			if ($this->FismaSystemPoamStatusLog->save($this->request->data))
			{
				$this->Session->setFlash( __('The %s has been saved.', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log'))) );
				return $this->redirect(array('controller' => 'fisma_system_poams', 'action' => 'view', $fisma_system_poam_id, 'saa' => false));
			}
			else
			{
				$this->Session->setFlash( __('The %s file could not be saved. Please, try again.', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log'))) );
			}
		}
	}
	
	public function saa_edit($id = null) 
	{
		$this->FismaSystemPoamStatusLog->recursive = -1;
		if (!$fisma_system_poam_status_log = $this->FismaSystemPoamStatusLog->read(null, $id))
		{
			throw new NotFoundException( __('Invalid %s', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log'))) );
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->FismaSystemPoamStatusLog->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log'))) );
				return $this->redirect(array('controller' => 'fisma_system_poams', 'action' => 'view', $fisma_system_poam_status_log['FismaSystemPoamStatusLog']['fisma_system_poam_id'], 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log'))) );
			}
		}
		else
		{
			$this->request->data = $fisma_system_poam_status_log;
		}
	}
}
