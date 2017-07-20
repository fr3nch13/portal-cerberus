<?php
App::uses('AppController', 'Controller');
/**
 * Pogs Controller
 *
 * @property Pogs $Pog
 */
class PogsController extends AppController 
{
	public $allowAdminDelete = true;

//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		// get the counts
		$this->Pog->getCounts = array(
			'SrcRule' => array(
				'all' => array(),
			),
			'DstRule' => array(
				'all' => array(),
			),
		);
		
		$this->Pog->recursive = 0;
		$this->paginate['contain'] = array('Protocol');
		$this->paginate['order'] = array('Pog.name' => 'asc');
		$this->paginate['conditions'] = $this->Pog->conditions($conditions, $this->passedArgs);
		$this->set('pogs', $this->paginate());
	}
	
	public function index_expanded() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$pogs = $this->Pog->find('all', array(
			'conditions' => $this->Pog->conditions($conditions, $this->passedArgs),
			'order' => array('Pog.name' => 'asc'),
		));
		$_pogs = array();
		foreach($pogs as $i => $pog)
		{
			$ports = $pog['Pog']['ports'];
			$ports = preg_split('/\s+/', $ports);
			foreach($ports as  $port)
			{
				$pog['Pog']['port'] = $port;
				$_pogs[] = $pog;
			}
		}
		unset($pogs);
		
		$this->set('pogs', $_pogs);
	}

//
	public function parents($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Pog->id = $id;
		if (!$this->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		$conditions = array(
			'PogsParent.child_id' => $id,
		);
		
		$this->Pog->PogsParent->recursive = 0;
		$this->paginate['order'] = array('Pog.name' => 'asc');
		$this->paginate['conditions'] = $this->Pog->PogsParent->conditions($conditions, $this->passedArgs); 
		$this->set('pogs', $this->paginate('PogsParent'));
	}

//
	public function children($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Pog->id = $id;
		if (!$this->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		$conditions = array(
			'PogsChild.parent_id' => $id,
		);
		
		$this->Pog->PogsChild->recursive = 0;
		$this->paginate['order'] = array('Pog.name' => 'asc');
		$this->paginate['conditions'] = $this->Pog->PogsChild->conditions($conditions, $this->passedArgs); 
		$this->set('pogs', $this->paginate('PogsChild'));
	}
	
	
	public function protocol($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Pog->Protocol->id = $id;
		if (!$this->Pog->Protocol->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Protocol')));
		}
		
		$conditions = array(
			'Pog.protocol_id' => $id,
		);
		
		$this->paginate['order'] = array('Pog.name' => 'asc');
		$this->paginate['conditions'] = $this->Pog->conditions($conditions, $this->passedArgs); 
		$this->set('pogs', $this->paginate());
	}

//
	public function view($id = false)
	{
		
		$this->Pog->id = $id;
		if (!$this->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		// get the counts
		$this->Pog->getCounts = array(
			'SrcRule' => array(
				'all' => array(
					'conditions' => array(
						'SrcRule.src_pog_id' => $id,
					),
				),
			),
			'DstRule' => array(
				'all' => array(
					'conditions' => array(
						'DstRule.dst_pog_id' => $id,
					),
				),
			),
			'PogLog' => array(
				'all' => array(
					'conditions' => array(
						'PogLog.pog_id' => $id,
					),
				),
			),
			'PogsChild' => array(
				'all' => array(
					'conditions' => array(
						'PogsChild.parent_id' => $id,
					),
				),
			),
			'PogsParent' => array(
				'all' => array(
					'conditions' => array(
						'PogsParent.child_id' => $id,
					),
				),
			),
		);
		
		$this->Pog->recursive = 0;
		$this->set('pog', $this->Pog->read(null, $id));
	}

//
	public function tip($id = false)
	{
		if (!$this->request->is('ajax')) 
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Port Object Group'), '1'));
		}
		
		$this->Pog->id = $id;
		if (!$this->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Port Object Group'), '2'));
		}
		
		$this->Pog->recursive = 0;
		$this->set('pog', $this->Pog->read(null, $id));
		
		$pog_children = $this->Pog->PogsChild->find('list', array(
			'recursive' => 0,
			'fields' => array('PogChild.id', 'PogChild.name'),
			'conditions' => array('PogsChild.parent_id' => $id),
		));
		$this->set('pog_children', $pog_children);
		
		$this->layout = 'ajax_nodebug';
	}
	
	public function add() 
	{
		if ($this->request->is('post'))
		{
			$this->Pog->create();
			$this->request->data['Pog']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->Pog->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Port Object Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Port Object Group')));
			}
		}
	}
	
	public function edit($id = null) 
	{
		$this->Pog->id = $id;
		if (!$pog = $this->Pog->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['Pog']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->Pog->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Port Object Group')));
				return $this->redirect(array('action' => 'view', $id));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Port Object Group')));
			}
		}
		else
		{
			$this->request->data = $this->Pog->read(null, $id);
		}
	}

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->paginate['order'] = array('Pog.name' => 'asc');
		$this->paginate['conditions'] = $this->Pog->conditions($conditions, $this->passedArgs); 
		$this->set('pogs', $this->paginate());
	}

//
	public function admin_parents($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Pog->id = $id;
		if (!$this->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		$conditions = array(
			'PogsParent.child_id' => $id,
		);
		
		$this->Pog->PogsParent->recursive = 0;
		$this->paginate['order'] = array('Pog.name' => 'asc');
		$this->paginate['conditions'] = $this->Pog->PogsParent->conditions($conditions, $this->passedArgs); 
		$this->set('pogs', $this->paginate('PogsParent'));
	}

//
	public function admin_children($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Pog->id = $id;
		if (!$this->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		$conditions = array(
			'PogsChild.parent_id' => $id,
		);
		
		$this->Pog->PogsChild->recursive = 0;
		$this->paginate['order'] = array('Pog.name' => 'asc');
		$this->paginate['conditions'] = $this->Pog->PogsChild->conditions($conditions, $this->passedArgs); 
		$this->set('pogs', $this->paginate('PogsChild'));
	}


//
	public function admin_view($id = false)
	{
		
		$this->Pog->id = $id;
		if (!$this->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		// get the counts
		$this->Pog->getCounts = array(
			'SrcRule' => array(
				'all' => array(
					'conditions' => array(
						'SrcRule.src_pog_id' => $id,
					),
				),
			),
			'DstRule' => array(
				'all' => array(
					'conditions' => array(
						'DstRule.dst_pog_id' => $id,
					),
				),
			),
			'PogLog' => array(
				'all' => array(
					'conditions' => array(
						'PogLog.pog_id' => $id,
					),
				),
			),
			'PogsPog' => array(
				'children' => array(
					'conditions' => array(
						'PogsPog.parent_id' => $id,
					),
				),
				'parents' => array(
					'conditions' => array(
						'PogsPog.child_id' => $id,
					),
				),
			),
		);
		
		$this->Pog->recursive = 0;
		$this->set('pog', $this->Pog->read(null, $id));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->Pog->create();
			$this->request->data['Pog']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->Pog->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Port Object Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Port Object Group')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->Pog->id = $id;
		if (!$this->Pog->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['Pog']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->Pog->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Port Object Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Port Object Group')));
			}
		}
		else
		{
			$this->request->data = $this->Pog->read(null, $id);
		}
	}
}
