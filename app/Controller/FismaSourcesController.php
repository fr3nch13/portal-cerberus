<?php
App::uses('AppController', 'Controller');
/**
 * FismaSources Controller
 *
 * @property FismaSources $FismaSources
 */
class FismaSourcesController extends AppController 
{

	public $allowAdminDelete = true;
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaSource->recursive = -1;
		$this->paginate['order'] = array('FismaSource.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSource->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_sources', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSource->create();
			
			if ($this->FismaSource->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA Source')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again. %s', __('FISMA Source'), $this->FismaSource->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaSource->id = $id;
		if (!$this->FismaSource->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Source')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSource->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Source')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Source')));
			}
		}
		else
		{
			$this->request->data = $this->FismaSource->read(null, $id);
		}
	}

	public function admin_default($id = null) 
	{
		$this->FismaSource->id = $id;
		if (!$this->FismaSource->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Source')));
		}
		
		// mark all as 0
		if(!$this->FismaSource->updateAll(array('FismaSource.default' => false), array('FismaSource.default' => true)))
		{
			$this->Session->setFlash(__('Unable to set the default %s.', __('FISMA Source')));
			return $this->redirect($this->referer());
		}
		
		$this->FismaSource->id = $id;
		if ($this->FismaSource->saveField('default', true)) 
		{
			$this->Session->setFlash(__('Default %s changed.', __('FISMA Source')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Unable to set the default %s.', __('FISMA Source')));
		return $this->redirect($this->referer());
	}
}