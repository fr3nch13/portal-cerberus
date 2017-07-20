<?php
App::uses('AppController', 'Controller');
/**
 * FismaSystemPoamCompletionStatuses Controller
 *
 * @property FismaSystemPoamCompletionStatus $FismaSystemPoamCompletionStatus
 */
class FismaSystemPoamCompletionStatusesController extends AppController 
{
	public $allowAdminDelete = true;

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() 
	{
		$this->FismaSystemPoamCompletionStatus->recursive = 0;
		$this->set('fisma_system_poam_completion_statuses', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) 
	{
		if (!$this->FismaSystemPoamCompletionStatus->exists($id)) 
		{
			throw new NotFoundException( __('Invalid %s', __('%s %s', __('FISMA system'), __('Poam Completion Status'))) );
		}
		$options = array('conditions' => array('FismaSystemPoamCompletionStatus.' . $this->FismaSystemPoamCompletionStatus->primaryKey => $id));
		$this->set('fisma_system_poam_completion_status', $this->FismaSystemPoamCompletionStatus->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() 
	{
		if ($this->request->is('post')) 
		{
			$this->FismaSystemPoamCompletionStatus->create();
			if ($this->FismaSystemPoamCompletionStatus->save($this->request->data)) 
			{
				$this->Session->setFlash( __('The %s has been saved.', __('%s %s', __('FISMA system'), __('Poam Completion Status'))) );
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash( __('The %s could not be saved. Please, try again.', __('%s %s', __('FISMA system'), __('Poam Completion Status'))) );
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) 
	{
		if (!$this->FismaSystemPoamCompletionStatus->exists($id))
		{
			throw new NotFoundException( __('Invalid %s', __('%s %s', __('FISMA system'), __('Poam Completion Status'))) );
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->FismaSystemPoamCompletionStatus->save($this->request->data))
			{
				$this->Session->setFlash( __('The %s has been saved.', __('%s %s', __('FISMA system'), __('Poam Completion Status'))) );
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash( __('The %s could not be saved. Please, try again.', __('%s %s', __('FISMA system'), __('Poam Completion Status'))) );
			}
		}
		else
		{
			$options = array('conditions' => array('FismaSystemPoamCompletionStatus.' . $this->FismaSystemPoamCompletionStatus->primaryKey => $id));
			$this->request->data = $this->FismaSystemPoamCompletionStatus->find('first', $options);
		}
	}
}
