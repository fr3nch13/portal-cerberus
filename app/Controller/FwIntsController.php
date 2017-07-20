<?php
App::uses('AppController', 'Controller');
/**
 * FwInts Controller
 *
 * @property FwInts $FwInt
 */
class FwIntsController extends AppController 
{

	public $allowAdminDelete = true;

//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		// get the counts
		$this->FwInt->getCounts = array(
			'Rule' => array(
				'all' => array(),
			),
		);
		
		$this->FwInt->recursive = 0;
		$this->paginate['order'] = array('FwInt.name' => 'asc');
		$this->paginate['conditions'] = $this->FwInt->conditions($conditions, $this->passedArgs); 
		$this->set('fw_ints', $this->paginate());
	}

//
	public function tip($id = false)
	{
		if (!$this->request->is('ajax')) 
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Firewall Path'), '1'));
		}
		
		$this->FwInt->id = $id;
		if (!$this->FwInt->exists())
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Firewall Path'), '2'));
		}
		
		$this->FwInt->recursive = 0;
		$this->set('fw_int', $this->FwInt->read(null, $id));
		
		$this->layout = 'ajax_nodebug';
	}

//
	public function view($id = false)
	{
		
		$this->FwInt->id = $id;
		if (!$this->FwInt->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Path')));
		}
		
		// get the counts
		$this->FwInt->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.fw_int_id' => $id,
					),
				),
			),
		);
		
		$this->FwInt->recursive = 0;
		$this->set('fw_int', $this->FwInt->read(null, $id));
	}

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FwInt->recursive = 0;
		$this->paginate['order'] = array('FwInt.name' => 'asc');
		$this->paginate['conditions'] = $this->FwInt->conditions($conditions, $this->passedArgs); 
		$this->set('fw_ints', $this->paginate());
	}

//
	public function admin_view($id = false)
	{
		
		$this->FwInt->id = $id;
		if (!$this->FwInt->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Path')));
		}
		
		// get the counts
		$this->FwInt->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.fw_int_id' => $id,
					),
				),
			),
		);
		$this->FwInt->recursive = 0;
		$this->set('fw_int', $this->FwInt->read(null, $id));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FwInt->create();
			$this->request->data['FwInt']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->FwInt->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall Path')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall Path')));
			}
		}
		
		$this->set('firewalls', $this->FwInt->Firewall->typeFormList());
		$this->set('fw_interfaces', $this->FwInt->FwInterface->typeFormList());
	}
	
	public function admin_edit($id = null) 
	{
		$this->FwInt->id = $id;
		if (!$this->FwInt->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Path')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['FwInt']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->FwInt->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall Path')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall Path')));
			}
		}
		else
		{
			$this->request->data = $this->FwInt->read(null, $id);
		}
		
		$this->set('firewalls', $this->FwInt->Firewall->typeFormList());
		$this->set('fw_interfaces', $this->FwInt->FwInterface->typeFormList());
	}
}
