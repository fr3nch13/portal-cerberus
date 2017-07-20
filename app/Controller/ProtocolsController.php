<?php
App::uses('AppController', 'Controller');
/**
 * Protocols Controller
 *
 * @property Protocols $Protocol
 */
class ProtocolsController extends AppController 
{

	public $allowAdminDelete = true;

//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		// get the counts
		$this->Protocol->getCounts = array(
			'Rule' => array(
				'all' => array(),
			),
			'Pog' => array(
				'all' => array(),
			),
		);
		
		$this->Protocol->recursive = -1;
		$this->paginate['order'] = array('Protocol.name' => 'asc');
		$this->paginate['conditions'] = $this->Protocol->conditions($conditions, $this->passedArgs); 
		$this->set('protocols', $this->paginate());
	}

//
	public function view($id = false)
	{
		
		$this->Protocol->id = $id;
		if (!$this->Protocol->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Protocol')));
		}
		
		// get the counts
		$this->Protocol->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.protocol_id' => $id,
					),
				),
			),
			'Pog' => array(
				'all' => array(
					'conditions' => array(
						'Pog.protocol_id' => $id,
					),
				),
			),
		);
		
		$this->Protocol->recursive = 0;
		$this->set('protocol', $this->Protocol->read(null, $id));
	}

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->Protocol->recursive = -1;
		$this->paginate['order'] = array('Protocol.name' => 'asc');
		$this->paginate['conditions'] = $this->Protocol->conditions($conditions, $this->passedArgs); 
		$this->set('protocols', $this->paginate());
	}

//
	public function admin_view($id = false)
	{
		
		$this->Protocol->id = $id;
		if (!$this->Protocol->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Protocol')));
		}
		
		// get the counts
		$this->Protocol->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.protocol_id' => $id,
					),
				),
			),
		);
		$this->Protocol->recursive = 0;
		$this->set('protocol', $this->Protocol->read(null, $id));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->Protocol->create();
			
			if ($this->Protocol->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Protocol')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Protocol')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->Protocol->id = $id;
		if (!$this->Protocol->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Protocol')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->Protocol->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Protocol')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Protocol')));
			}
		}
		else
		{
			$this->request->data = $this->Protocol->read(null, $id);
		}
	}
}
