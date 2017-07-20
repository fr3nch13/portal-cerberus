<?php
App::uses('AppController', 'Controller');
/**
 * Fogs Controller
 *
 * @property Fogs $Fog
 */
class FogsController extends AppController 
{
	public $allowAdminDelete = true;

//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		// get the counts
		$this->Fog->getCounts = array(
			'SrcRule' => array(
				'all' => array(),
			),
			'DstRule' => array(
				'all' => array(),
			),
		);
		
		$this->paginate['order'] = array('Fog.name' => 'asc');
		$this->paginate['conditions'] = $this->Fog->conditions($conditions, $this->passedArgs); 
		$this->set('fogs', $this->paginate());
	}
	
	public function index_expanded() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$fogs = $this->Fog->find('all', array(
			'conditions' => $this->Fog->conditions($conditions, $this->passedArgs),
			'order' => array('Fog.name' => 'asc'),
		));
		$_fogs = array();
		foreach($fogs as $i => $fog)
		{
			$ip_addresses = $fog['Fog']['ip_addresses'];
			$ip_addresses = preg_split('/\s+/', $ip_addresses);
			foreach($ip_addresses as  $ip_address)
			{
				$fog['Fog']['ip_address'] = $ip_address;
				$_fogs[] = $fog;
			}
		}
		unset($fogs);
		
		$this->set('fogs', $_fogs);
	}

//
	public function parents($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Fog->id = $id;
		if (!$this->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		$conditions = array(
			'FogsParent.child_id' => $id,
		);
		
		$this->Fog->FogsParent->recursive = 0;
		$this->paginate['order'] = array('Fog.name' => 'asc');
		$this->paginate['conditions'] = $this->Fog->FogsParent->conditions($conditions, $this->passedArgs); 
		$this->set('fogs', $this->paginate('FogsParent'));
	}

//
	public function children($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Fog->id = $id;
		if (!$this->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		$conditions = array(
			'FogsChild.parent_id' => $id,
		);
		
		$this->Fog->FogsChild->recursive = 0;
		$this->paginate['order'] = array('Fog.name' => 'asc');
		$this->paginate['conditions'] = $this->Fog->FogsChild->conditions($conditions, $this->passedArgs); 
		$this->set('fogs', $this->paginate('FogsChild'));
	}

//
	public function view($id = false)
	{
		
		$this->Fog->id = $id;
		if (!$this->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		// get the counts
		$this->Fog->getCounts = array(
			'SrcRule' => array(
				'all' => array(
					'conditions' => array(
						'SrcRule.src_fog_id' => $id,
					),
				),
			),
			'DstRule' => array(
				'all' => array(
					'conditions' => array(
						'DstRule.dst_fog_id' => $id,
					),
				),
			),
			'FogLog' => array(
				'all' => array(
					'conditions' => array(
						'FogLog.fog_id' => $id,
					),
				),
			),
			'FogsChild' => array(
				'all' => array(
					'conditions' => array(
						'FogsChild.parent_id' => $id,
					),
				),
			),
			'FogsParent' => array(
				'all' => array(
					'conditions' => array(
						'FogsParent.child_id' => $id,
					),
				),
			),
		);
		
		$this->Fog->recursive = 0;
		$this->set('fog', $this->Fog->read(null, $id));
	}

//
	public function tip($id = false)
	{
		if (!$this->request->is('ajax')) 
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Firewall Object Group'), '1'));
		}
		
		$this->Fog->id = $id;
		if (!$this->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Firewall Object Group'), '2'));
		}
		
		$this->Fog->recursive = 0;
		$this->set('fog', $this->Fog->read(null, $id));
		
		$fog_children = $this->Fog->FogsChild->find('list', array(
			'recursive' => 0,
			'fields' => array('FogChild.id', 'FogChild.name'),
			'conditions' => array('FogsChild.parent_id' => $id),
		));
		$this->set('fog_children', $fog_children);
		
		$this->layout = 'ajax_nodebug';
	}
	
	public function add() 
	{
		if ($this->request->is('post'))
		{
			$this->Fog->create();
			$this->request->data['Fog']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->Fog->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall Object Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall Object Group')));
			}
		}
	}
	
	public function edit($id = null) 
	{
		$this->Fog->id = $id;
		if (!$fog = $this->Fog->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['Fog']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->Fog->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall Object Group')));
				return $this->redirect(array('action' => 'view', $id));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall Object Group')));
			}
		}
		else
		{
			$this->request->data = $this->Fog->read(null, $id);
		}
	}

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->paginate['order'] = array('Fog.name' => 'asc');
		$this->paginate['conditions'] = $this->Fog->conditions($conditions, $this->passedArgs); 
		$this->set('fogs', $this->paginate());
	}

//
	public function admin_parents($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Fog->id = $id;
		if (!$this->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		$conditions = array(
			'FogsParent.child_id' => $id,
		);
		
		$this->Fog->FogsParent->recursive = 0;
		$this->paginate['order'] = array('Fog.name' => 'asc');
		$this->paginate['conditions'] = $this->Fog->FogsParent->conditions($conditions, $this->passedArgs); 
		$this->set('fogs', $this->paginate('FogsParent'));
	}

//
	public function admin_children($id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->Fog->id = $id;
		if (!$this->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		$conditions = array(
			'FogsChild.parent_id' => $id,
		);
		
		$this->Fog->FogsChild->recursive = 0;
		$this->paginate['order'] = array('Fog.name' => 'asc');
		$this->paginate['conditions'] = $this->Fog->FogsChild->conditions($conditions, $this->passedArgs); 
		$this->set('fogs', $this->paginate('FogsChild'));
	}


//
	public function admin_view($id = false)
	{
		
		$this->Fog->id = $id;
		if (!$this->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		// get the counts
		$this->Fog->getCounts = array(
			'SrcRule' => array(
				'all' => array(
					'conditions' => array(
						'SrcRule.src_fog_id' => $id,
					),
				),
			),
			'DstRule' => array(
				'all' => array(
					'conditions' => array(
						'DstRule.dst_fog_id' => $id,
					),
				),
			),
			'FogLog' => array(
				'all' => array(
					'conditions' => array(
						'FogLog.fog_id' => $id,
					),
				),
			),
			'FogsChild' => array(
				'all' => array(
					'conditions' => array(
						'FogsChild.parent_id' => $id,
					),
				),
			),
			'FogsParent' => array(
				'all' => array(
					'conditions' => array(
						'FogsParent.child_id' => $id,
					),
				),
			),
		);
		
		$this->Fog->recursive = 0;
		$this->set('fog', $this->Fog->read(null, $id));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->Fog->create();
			$this->request->data['Fog']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->Fog->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall Object Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall Object Group')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->Fog->id = $id;
		if (!$this->Fog->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['Fog']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->Fog->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall Object Group')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall Object Group')));
			}
		}
		else
		{
			$this->request->data = $this->Fog->read(null, $id);
		}
	}

/*/
	public function admin_delete($id = null) 
	{
		$this->Fog->id = $id;
		if (!$this->Fog->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}

		if ($this->Fog->delete()) 
		{
			$this->Session->setFlash(__('%s deleted', __('Firewall Object Group')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('%s was not deleted', __('Firewall Object Group')));
		return $this->redirect($this->referer());
	}
*/
}
