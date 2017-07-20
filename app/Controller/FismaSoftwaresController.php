<?php
App::uses('AppController', 'Controller');
/**
 * FismaSoftware Controller
 *
 * @property FismaSoftware $FismaSoftware
 */
class FismaSoftwaresController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		// include all if they're an admin
		if(AuthComponent::user('role') != 'admin')
			$conditions['FismaSoftware.approved'] = true;
		
		$order = array('FismaSoftware.name' => 'asc');
		
		$this->FismaSoftware->includeSystems = true;
		
		$this->FismaSoftware->recursive = 1;
		$this->paginate['contain'] = array('Tag', 'FismaSoftwareGroup', 'FismaSoftwareSource');
		$this->paginate['order'] = $order;
		$this->paginate['conditions'] = $this->FismaSoftware->conditions($conditions, $this->passedArgs); 
		
		$fisma_software = $this->paginate();
		$this->set('fisma_softwares', $fisma_software);
	}
	
	public function tag($tag_id = null) 
	{
		if(!$tag_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		
		$tag = $this->FismaSoftware->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		// include all if they're an admin
		if(AuthComponent::user('role') != 'admin')
			$conditions['FismaSoftware.approved'] = true;
		
		$conditions[] = $this->FismaSoftware->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'FismaSoftware');
		
		$order = array('FismaSoftware.name' => 'asc');
		
		
		$this->FismaSoftware->recursive = 0;
		$this->paginate['order'] = $order;
		$this->paginate['conditions'] = $this->FismaSoftware->conditions($conditions, $this->passedArgs); 
		$this->set('fisma_softwares', $this->paginate());
	}

	public function view($id = false)
	{
		
		$this->FismaSoftware->id = $id;
		if (!$this->FismaSoftware->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Software')));
		}
		
		$this->FismaSoftware->recursive = 0;
		$fisma_software = $this->FismaSoftware->read(null, $id);
		
		$this->set('fisma_software', $fisma_software);
	}
	
	public function saa_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSoftware->create();
			
			if ($this->FismaSoftware->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Software')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Software')));
			}
		}
		
		$fismaSoftwareSources = $this->FismaSoftware->FismaSoftwareSource->find('list');
		$fismaSoftwareGroups = $this->FismaSoftware->FismaSoftwareGroup->find('list');
		$fismaSystems = $this->FismaSoftware->FismaSystem->find('list');
		$this->set(compact('fismaSoftwareSources', 'fismaSoftwareGroups', 'fismaSystems'));
	}
	
	public function saa_edit($id = null) 
	{
		$this->FismaSoftware->id = $id;
		if (!$this->FismaSoftware->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Software')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSoftware->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('FISMA Software')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Software')));
			}
		}
		else
		{
			$this->FismaSoftware->recursive = 1;
			$this->request->data = $this->FismaSoftware->read(null, $id);
		}
		
		$fismaSoftwareSources = $this->FismaSoftware->FismaSoftwareSource->find('list');
		$fismaSoftwareGroups = $this->FismaSoftware->FismaSoftwareGroup->find('list');
		$fismaSystems = $this->FismaSoftware->FismaSystem->find('list');
		$this->set(compact('fismaSoftwareSources', 'fismaSoftwareGroups', 'fismaSystems'));
	}
	
	public function admin_index() 
	{
		return $this->index();
	}
}
