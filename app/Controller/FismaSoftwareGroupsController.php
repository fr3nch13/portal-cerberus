<?php
App::uses('AppController', 'Controller');
/**
 * FismaSoftwareGroups Controller
 *
 * @property FismaSoftwareGroups $FismaSoftwareGroups
 */
class FismaSoftwareGroupsController extends AppController 
{

	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSoftwareGroup->recursive = -1;
		$this->paginate['order'] = array('FismaSoftwareGroup.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSoftwareGroup->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_software_groups', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSoftwareGroup->create();
			
			if ($this->FismaSoftwareGroup->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA Software Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('FISMA Software Group'), $this->FismaSoftwareGroup->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSoftwareGroup->id = $id;
		if (!$this->FismaSoftwareGroup->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Software Group')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSoftwareGroup->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Software Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Software Group')));
			}
		}
		else
		{
			$this->request->data = $this->FismaSoftwareGroup->read(null, $id);
		}
	}
}