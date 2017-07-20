<?php
App::uses('AppController', 'Controller');
/**
 * ReviewStates Controller
 *
 * @property ReviewStates $ReviewStates
 */
class ReviewStatesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		$order = array('ReviewState.default' => 'desc', 'ReviewState.name' => 'asc');
		
		if ($this->request->is('requested')) 
		{
			$this->ReviewState->typeFormListOrder = $order;
			$review_states = $this->ReviewState->typeFormList();
			
			// format for the menu_items
			$items = array();
			
			$items[] = array(
				'title' => __('All'),
				'url' => array('controller' => 'rules', 'action' => 'index', 'admin' => false, 'plugin' => false)
			);
			
			$items[] = array(
				'title' => __('Duplicates'),
				'url' => array('controller' => 'rules', 'action' => 'duplicates', 'admin' => false, 'plugin' => false)
			);
			
			$items[] = array(
				'title' => __('All with %s', __('FISMA Systems')),
				'url' => array('controller' => 'rules', 'action' => 'fisma_systems', 'ext' => 'csv', 'admin' => false, 'plugin' => false),
				'class' => ['no-icon'],
			);
				
			foreach($review_states as $review_state_id => $review_state_name)
			{
				$title = $review_state_name;
				
				$items[] = array(
					'title' => $title,
					'url' => array('controller' => 'rules', 'action' => 'review_state', $review_state_id, 'admin' => false, 'plugin' => false)
				);
			}
			
			$items[] = array(
				'title' => __('Update Flow Report'),
				'url' => array('controller' => 'rules', 'action' => 'flow_report', 'admin' => false, 'plugin' => false)
			);
			return $items;
		}
		else
		{
			$this->ReviewState->recursive = 0;
			$this->paginate['order'] = $order;
			$this->paginate['conditions'] = $this->ReviewState->conditions($conditions, $this->passedArgs); 
			$this->set('review_states', $this->paginate());
		}
	}
	
	public function defaultname()
	{
		if ($this->request->is('requested')) 
		{
			return $this->ReviewState->field('name', array('default' => true));
		}
	}
	
//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReviewState->recursive = -1;
		$this->paginate['order'] = array('ReviewState.name' => 'asc');
		$this->paginate['conditions'] = $this->ReviewState->conditions($conditions, $this->passedArgs); 
		$this->set('review_states', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReviewState->create();
			
			if ($this->ReviewState->save($this->request->data))
			{
				$this->Session->setFlash(__('The Review State has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Review State could not be saved. Please, try again.'));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->ReviewState->id = $id;
		if (!$this->ReviewState->exists()) 
		{
			throw new NotFoundException(__('Invalid Review State'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReviewState->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The Review State has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Review State could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->ReviewState->read(null, $id);
		}
	}
//
	public function admin_default($id = null) 
	{
		$this->ReviewState->id = $id;
		if (!$this->ReviewState->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Review State')));
		}
		
		// mark all as 0
		if(!$this->ReviewState->updateAll(array('ReviewState.default' => false), array('ReviewState.default' => true)))
		{
			$this->Session->setFlash(__('Unable to set the default %s.', __('Review State')));
			return $this->redirect($this->referer());
		}
		
		$this->ReviewState->id = $id;
		if ($this->ReviewState->saveField('default', true)) 
		{
			$this->Session->setFlash(__('Default %s changes.', __('Review State')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Unable to set the default %s.', __('Review State')));
		return $this->redirect($this->referer());
	}
}