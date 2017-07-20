<?php
App::uses('AppController', 'Controller');
/**
 * FismaSystemPoams Controller
 *
 * @property FismaSystemPoam $FismaSystemPoam
 */
class FismaSystemPoamsController extends AppController 
{
	public function fisma_system($id = null) 
	{
		$this->FismaSystemPoam->FismaSystem->id = $id;
		if (!$this->FismaSystemPoam->FismaSystem->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'FismaSystemPoam.fisma_system_id' => $id,
		); 
		
		$this->FismaSystemPoam->FismaSystem->recursive = -1;
		$this->set('fisma_system', $this->FismaSystemPoam->FismaSystem->read(null, $id));
		
		$this->paginate['conditions'] = $this->FismaSystemPoam->conditions($conditions, $this->passedArgs); 
		
		$this->paginate['contain'] = array('FismaSystem', 'FismaSystemPoamCompletionStatus', 'FismaSystemPoamStatusLog' => array('order' => 'FismaSystemPoamStatusLog.created DESC', 'limit' => 1) );
		$this->paginate['order'] = array('FismaSystemPoam.created' => 'desc');
		$this->set('fisma_system_poams', $this->paginate());
	}
	
	public function view($id = false)
	{
		
		$this->FismaSystemPoam->id = $id;
		if (!$this->FismaSystemPoam->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('FISMA System'), __('POAM'))));
		}
		
		$this->FismaSystemPoam->recursive = 0;
		$this->FismaSystemPoam->contain(array('FismaSystem', 'FismaSystemPoamCompletionStatus', 'ModifiedUser', 'AddedUser'));
		$this->set('fisma_system_poam', $this->FismaSystemPoam->read(null, $id));
	}
	
	public function saa_add($fisma_system_id = null)
	{
		if (!$this->FismaSystemPoam->FismaSystem->exists($fisma_system_id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('FISMA System'), __('POAM'))));
		}
		$this->request->data['FismaSystemPoam']['fisma_system_id'] = $fisma_system_id;
		
		if ($this->request->is('post'))
		{
			$this->FismaSystemPoam->create();
			$this->request->data['FismaSystemPoam']['added_user_id'] = AuthComponent::user('id');
			if ($this->FismaSystemPoam->save($this->request->data))
			{
				$this->Session->setFlash( __('The %s has been saved.', __('%s %s', __('FISMA System'), __('POAM'))) );
				return $this->redirect(array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_id, 'saa' => false));
			}
			else
			{
				$msg = __('The %s could not be saved. Please, try again.', __('%s %s', __('FISMA System'), __('POAM')));
				if($this->FismaSystemPoam->modelError) $msg = __('The %s could not be saved. Reason: %s', __('%s %s', __('FISMA System'), __('POAM')), $this->FismaSystemPoam->modelError);
				$this->Session->setFlash($msg);
			}
		}
		
		$fismaSystemPoamCompletionStatuses = $this->FismaSystemPoam->FismaSystemPoamCompletionStatus->find('list');
		$this->set(compact('fismaSystemPoamCompletionStatuses'));
	}

	public function saa_edit($id = null)
	{
		if (!$fisma_system_poam = $this->FismaSystemPoam->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('%s %s', __('FISMA System'), __('POAM'))));
		}
		if ($this->request->is(array('post', 'put'))) 
		{
			$this->request->data['FismaSystemPoam']['modified_user_id'] = AuthComponent::user('id');
			if ($this->FismaSystemPoam->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('%s %s', __('FISMA System'), __('POAM'))));
				return $this->redirect(array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_poam['FismaSystemPoam']['fisma_system_id'], 'saa' => false));
			}
			else
			{
				$msg = __('The %s could not be saved. Please, try again.', __('%s %s', __('FISMA System'), __('POAM')));
				if($this->FismaSystemPoam->modelError) $msg = __('The %s could not be saved. Reason: %s', __('%s %s', __('FISMA System'), __('POAM')), $this->FismaSystemPoam->modelError);
				$this->Session->setFlash($msg);
			}
		}
		else
		{
			$this->request->data = $fisma_system_poam;
		}
		
		$fismaSystemPoamCompletionStatuses = $this->FismaSystemPoam->FismaSystemPoamCompletionStatus->find('list');
		$this->set(compact('fismaSystemPoamCompletionStatuses'));
	}
	
	public function admin_fisma_system($id = null) 
	{
		return $this->fisma_system($id);
	}
}
