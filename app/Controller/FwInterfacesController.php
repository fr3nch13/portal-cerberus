<?php
App::uses('AppController', 'Controller');
/**
 * FwInterfaces Controller
 *
 * @property FwInterfaces $FwInterface
 */
class FwInterfacesController extends AppController 
{

	public $allowAdminDelete = true;

//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		// get the counts
		$this->FwInterface->getCounts = array(
			'Rule' => array(
				'all' => array(),
			),
		);
		
		$this->FwInterface->recursive = -1;
		$this->paginate['order'] = array('FwInterface.name' => 'asc');
		$this->paginate['conditions'] = $this->FwInterface->conditions($conditions, $this->passedArgs); 
		$this->set('fw_interfaces', $this->paginate());
	}

//
	public function view($id = false)
	{
		
		$this->FwInterface->id = $id;
		if (!$this->FwInterface->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Interface')));
		}
		
		// get the counts
		$this->FwInterface->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.fw_interface_id' => $id,
					),
				),
			),
		);
		
		$this->FwInterface->recursive = 0;
		$this->set('fw_interface', $this->FwInterface->read(null, $id));
	}

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->FwInterface->recursive = -1;
		$this->paginate['order'] = array('FwInterface.name' => 'asc');
		$this->paginate['conditions'] = $this->FwInterface->conditions($conditions, $this->passedArgs); 
		$this->set('fw_interfaces', $this->paginate());
	}

//
	public function admin_view($id = false)
	{
		
		$this->FwInterface->id = $id;
		if (!$this->FwInterface->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Interface')));
		}
		
		// get the counts
		$this->FwInterface->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.fw_interface_id' => $id,
					),
				),
			),
		);
		$this->FwInterface->recursive = 0;
		$this->set('fw_interface', $this->FwInterface->read(null, $id));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FwInterface->create();
			
			if ($this->FwInterface->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Interface')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Interface')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->FwInterface->id = $id;
		if (!$this->FwInterface->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Interface')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FwInterface->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Interface')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Interface')));
			}
		}
		else
		{
			$this->request->data = $this->FwInterface->read(null, $id);
		}
	}
}
