<?php
App::uses('AppController', 'Controller');
/**
 * FismaTypes Controller
 *
 * @property FismaTypes $FismaTypes
 */
class FismaTypesController extends AppController 
{

	public $allowAdminDelete = true;
//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		$order = array('FismaType.default' => 'desc', 'FismaType.name' => 'asc');
		
		if ($this->request->is('requested')) 
		{
			$fisma_types = $this->FismaType->find('all', array(
				'order' => $order,
			));
			
			// format for the menu_items
			$items = array();
			
			$items[] = array(
				'title' => __('All'),
				'url' => array('controller' => 'fisma_systems', 'action' => 'index', 'admin' => false, 'plugin' => false)
			);
				
			foreach($fisma_types as $fisma_type)
			{
				$title = $fisma_type['FismaType']['name'];
				
				if($fisma_type['FismaType']['default'])
				{
//					$title = '- '. $title;
				}
				
				$items[] = array(
					'title' => $title,
					'url' => array('controller' => 'fisma_systems', 'action' => 'fisma_type', $fisma_type['FismaType']['id'], 'admin' => false, 'plugin' => false)
				);
			}
			return $items;
		}
		else
		{
			$this->FismaType->recursive = 0;
			$this->paginate['order'] = $order;
			$this->paginate['conditions'] = $this->FismaType->conditions($conditions, $this->passedArgs); 
			$this->set('fisma_types', $this->paginate());
		}
	}
	
	public function defaultname()
	{
		if ($this->request->is('requested')) 
		{
			return $this->FismaType->field('name', array('default' => true));
		}
	}
	
//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FismaType->recursive = -1;
		$this->paginate['order'] = array('FismaType.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaType->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_types', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaType->create();
			
			if ($this->FismaType->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Type')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Type')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FismaType->id = $id;
		if (!$this->FismaType->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Type')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaType->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Type')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Type')));
			}
		}
		else
		{
			$this->request->data = $this->FismaType->read(null, $id);
		}
	}

//
	public function admin_default($id = null) 
	{
		$this->FismaType->id = $id;
		if (!$this->FismaType->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Type')));
		}
		
		// mark all as 0
		if(!$this->FismaType->updateAll(array('FismaType.default' => false), array('FismaType.default' => true)))
		{
			$this->Session->setFlash(__('Unable to set the default %s.', __('FISMA Type')));
			return $this->redirect($this->referer());
		}
		
		$this->FismaType->id = $id;
		if ($this->FismaType->saveField('default', true)) 
		{
			$this->Session->setFlash(__('Default %s changed.', __('FISMA Type')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Unable to set the default %s.', __('FISMA Type')));
		return $this->redirect($this->referer());
	}
}