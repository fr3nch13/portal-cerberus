<?php
App::uses('AppController', 'Controller');
/**
 * FismaSoftwareSources Controller
 *
 * @property FismaSoftwareSources $FismaSoftwareSources
 */
class FismaSoftwareSourcesController extends AppController 
{

	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSoftwareSource->recursive = -1;
		$this->paginate['order'] = array('FismaSoftwareSource.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSoftwareSource->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_software_sources', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSoftwareSource->create();
			
			if ($this->FismaSoftwareSource->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA Software Source')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('FISMA Software Source'), $this->FismaSoftwareSource->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSoftwareSource->id = $id;
		if (!$this->FismaSoftwareSource->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Software Source')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSoftwareSource->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Software Source')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Software Source')));
			}
		}
		else
		{
			$this->request->data = $this->FismaSoftwareSource->read(null, $id);
		}
	}
}