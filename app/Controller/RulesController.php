<?php
App::uses('AppController', 'Controller');
/**
 * Rules Controller
 *
 * @property Rules $Rules
 */
class RulesController extends AppController 
{

	public function isAuthorized($user = array())
	{
		// All registered users can add and view rules
		if (in_array($this->action, array('add', 'view', 'edit'))) 
		{
			return true;
		}
		
		// only the reviewer can change the state and delete
		if (in_array($this->action, array('toggle', 'edit_state', 'delete'))) 
		{
			if(in_array(AuthComponent::user('role'), array('admin', 'reviewer')))
			{
				return true;
			}
		}

		return parent::isAuthorized($user);
	}

	public function db_block_overview()
	{
	}

	public function index() 
	{
		$this->Prg->commonProcess();
		
		$local_page_subtitle = __('All');
		
		$conditions = array();
		$conditions = array_merge($conditions, $this->conditions);
		
		if(isset($conditions['OR']) and !$conditions['OR'] and !in_array($this->action, array('index', 'admin_index')))
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = (isset($this->viewVars['page_subtitle'])?$this->viewVars['page_subtitle']:$local_page_subtitle);
		$page_description = (isset($this->viewVars['page_description'])?$this->viewVars['page_description']:'');
		
		$this->paginate['conditions'] = $this->Rule->conditions($conditions, $this->passedArgs);
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->Rule->getCachedCounts('count', array('conditions' => $this->paginate['conditions']));
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->Filter->Filter();
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'Rule';
		
		$this->Rule->recursive = 0;
		$rules = $this->paginate($this->paginateModel);
		
		$this->set('rules', $rules);
		$this->set(compact(array('page_subtitle', 'page_description')));
	}

	public function duplicates()
	{
		$rules = $this->Rule->find('all', [
			'recursive' => -1,
			'fields' => ['Rule.hash'],
			'group' => 'Rule.hash HAVING COUNT(*) > 1',
		]);

		// make a nice array with them
		$hashes = array();
		foreach ($rules as $rule) 
		{
			if($rule['Rule']['hash'])
				$hashes[$rule['Rule']['hash']] = $rule['Rule']['hash'];
		}
		
		if(!$hashes)
			$this->paginate['empty'] = true;
		
		$conditions = array('Rule.hash' => $hashes);
		
		$page_subtitle = __('Duplicates');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->paginate['order'] = ['Rule.hash' => 'asc'];
		return $this->index();
	}
	
	public function fisma_systems()
	{
		$this->Prg->commonProcess();
		
		$local_page_subtitle = __('All');
		
		$conditions = [];
		$conditions = array_merge($conditions, $this->conditions);
		$conditions  = $this->Rule->conditions($conditions, $this->passedArgs);
		
		$rules = $this->Rule->fismaBreakout([
			'conditions' => $conditions,
			'contain' => [
				'FwInt', 'Firewall', 'FwInterface', 'Protocol', 'SrcFog', 'DstFog', 'Import'
			],
			'order' => ['Rule.id' => 'desc'],
		]);
		
		$this->set('rules', $rules);
	}

	public function review_state($review_state_id = null) 
	{
		$conditions = array();
		
		if($review_state_id)
		{
			$conditions['Rule.review_state_id'] = $review_state_id;
		}
		else
		{
			$conditions['ReviewState.default'] = true;
		}
		
		$this->Rule->recursive = 0;
		
		if ($this->request->is('requested')) 
		{
			$rules = $this->Rule->find('all', array(
				'recursive' => 0,
				'conditions' => $conditions,
				'contain' => array('ReviewState'),
			));
			
			// format for the menu_items
			$items = array();
			
			foreach($rules as $rules)
			{
				$title = $rules['Rule']['id']. '-';
				
				$items[] = array(
					'title' => $rules['Rule']['id'],
					'url' => array('controller' => 'rules', 'action' => 'view', $rules['Rule']['id'], 'admin' => false, 'plugin' => false)
				);
			}
			return $items;
		}
		else
		{
			$this->Rule->getLatestUpload = true;
			$review_state = $this->Rule->ReviewState->read(null, $review_state_id);
		
			$page_subtitle = __('%s: %s', __('Review State'), $review_state['ReviewState']['name']);
			$page_description = '';
			$this->set(compact(array('page_subtitle', 'page_description')));
			
			$this->conditions = $conditions;
			return $this->index();
			
		}
	}

	public function user($user_id = null, $type = false) 
	{
		$this->Rule->RuleAddedUser->id = $user_id;
		if (!$this->Rule->RuleAddedUser->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('User')));
		}
		
		if(!in_array($type, array('added', 'modified', 'reviewed', 'poc')))
		{
			throw new NotFoundException(__('Invalid %s Relationship', __('User')));
		}
		
		$conditions = array();
		$user = array();
		
		if($type == 'poc')
		{
			$user = $this->Rule->RuleAddedUser->read(array('id', 'name', 'email'), $user_id);
			$user['User'] = array_pop($user);
			$conditions = array(
				'Rule.poc_email' => $user['User']['email'],
			);
		}
		else
		{
			$conditions = array(
				'Rule.'. $type.'_user_id' => $user_id,
			);
		}
		
		$subtitle_prefix = __('Associated with');
		switch($type)
		{
			case 'added':
				$user = $this->Rule->RuleAddedUser->read(array('id', 'name', 'email'), $user_id);
				$user['User'] = array_pop($user);
				$subtitle_prefix = __('Added by');
				break;
			case 'modified':
				$user = $this->Rule->RuleModifiedUser->read(array('id', 'name', 'email'), $user_id);
				$user['User'] = array_pop($user);
				$subtitle_prefix = __('Modified by');
				break;
			case 'reviewed':
				$user = $this->Rule->RuleReviewedUser->read(array('id', 'name', 'email'), $user_id);
				$user['User'] = array_pop($user);
				$subtitle_prefix = __('Reviewed by');
				break;
		}
		
		$this->set('user', $user);
		
		$page_subtitle = __('%s %s: %s', $subtitle_prefix, __('User'), $user['User']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function firewall($firewall_id = 0)
	{
		$this->Rule->Firewall->id = $firewall_id;
		if (!$this->Rule->Firewall->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall')));
		}
		
		$conditions = array('Rule.firewall_id' => $firewall_id);
		
		$firewall = $this->Rule->Firewall->read(null, $firewall_id);
		$this->set('firewall', $firewall);
		
		$page_subtitle = __('%s: %s', __('Firewall'), $firewall['Firewall']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function import($import_id = 0)
	{
		$this->Rule->Import->id = $import_id;
		if (!$this->Rule->Import->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Import')));
		}
		
		$conditions = array('Rule.import_id' => $import_id);
		
		$import = $this->Rule->Import->read(null, $import_id);
		
		$this->set('import', $import);
		
		$page_subtitle = __('%s: %s', __('Import'), $import['Import']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function fisma_system($fisma_system_id = 0)
	{
		$this->Rule->SrcFismaSystem->id = $fisma_system_id;
		if (!$this->Rule->SrcFismaSystem->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		
		$conditions = array(
			'OR' => array(
				'Rule.src_fisma_system_id' => $fisma_system_id,
				'Rule.dst_fisma_system_id' => $fisma_system_id,
			),
		);
		
		$fisma_system = $this->Rule->SrcFismaSystem->read(null, $fisma_system_id);
		
		$this->set('fisma_system', $fisma_system);
		
		$page_subtitle = __('%s: %s', __('FISMA System'), $fisma_system['SrcFismaSystem']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function fog($fog_id = 0)
	{
		$this->Rule->SrcFog->id = $fog_id;
		if (!$this->Rule->SrcFog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		$conditions = array(
			'OR' => array(
				'Rule.src_fog_id' => $fog_id,
				'Rule.dst_fog_id' => $fog_id,
			),
		);
		
		$fog = $this->Rule->SrcFog->read(null, $fog_id);
		
		$this->set('fog', $fog);
		
		$page_subtitle = __('%s: %s', __('F.O.G.'), $fog['SrcFog']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function pog($pog_id = 0)
	{
		$this->Rule->SrcPog->id = $pog_id;
		if (!$this->Rule->SrcPog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		$conditions = array(
			'OR' => array(
				'Rule.src_pog_id' => $pog_id,
				'Rule.dst_pog_id' => $pog_id,
			),
		);
		
		$pog = $this->Rule->SrcPog->read(null, $pog_id);
		
		$this->set('pog', $pog);
		
		$page_subtitle = __('%s: %s', __('P.O.G.'), $pog['SrcPog']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function fw_interface($fw_interface_id = 0)
	{
		$this->Rule->FwInterface->id = $fw_interface_id;
		if (!$this->Rule->FwInterface->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Interface')));
		}
		
		$conditions = array('Rule.fw_interface_id' => $fw_interface_id);
		
		
		$fw_interface = $this->Rule->FwInterface->read(null, $fw_interface_id);
		
		$this->set('fw_interface', $fw_interface);
		
		$page_subtitle = __('%s: %s', __('Interface'), $fw_interface['FwInterface']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function protocol($protocol_id = 0)
	{
		$this->Rule->Protocol->id = $protocol_id;
		if (!$this->Rule->Protocol->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Protocol')));
		}
		
		$conditions = array('Rule.protocol_id' => $protocol_id);
		
		$protocol = $this->Rule->Protocol->read(null, $protocol_id);
		
		$this->set('protocol', $protocol);
		
		$page_subtitle = __('%s: %s', __('Protocol'), $protocol['Protocol']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function fw_int($fw_int_id = 0)
	{
		$this->Rule->FwInt->id = $fw_int_id;
		if (!$this->Rule->FwInt->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Path')));
		}
		
		$conditions = array('Rule.fw_int_id' => $fw_int_id);
		
		$fw_int = $this->Rule->FwInt->read(null, $fw_int_id);
		
		$this->set('fw_int', $fw_int);
		
		$page_subtitle = __('%s: %s', __('Firewall Path'), $fw_int['FwInt']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function subnet($subnet_id = 0, $type = 'both')
	{
		$this->loadModel('Subnet');
		
		$this->Subnet->id = $subnet_id;
		if (!$subnet = $this->Subnet->read(null, $subnet_id))
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		
		// get the ip addresses
		$ip_addresses = $this->Subnet->ipArray($subnet_id);
		
		$conditions = array();
		
		$subtitle_prefix = false;
		
		$src_fog_conditions = array('OR' => array());
		$dst_fog_conditions = array('OR' => array());
		foreach($ip_addresses as $ip_address)
		{
			$src_fog_conditions['OR'][]['SrcFog.ip_addresses LIKE'] = '%'.$ip_address.'%';
			$dst_fog_conditions['OR'][]['DstFog.ip_addresses LIKE'] = '%'.$ip_address.'%';
		}
		
		$src_conditions = array(
			'OR' => array(
				array(
					'Rule.use_src_fog' => false,
					'Rule.src_ip' => $ip_addresses,
				),
				array(
					'Rule.use_src_fog' => true,
					$src_fog_conditions,
				),
			),
		);
		$dst_conditions = array(
			'OR' => array(
				array(
					'Rule.use_dst_fog' => false,
					'Rule.dst_ip' => $ip_addresses,
				),
				array(
					'Rule.use_dst_fog' => true,
					$dst_fog_conditions,
				),
			),
		);
		
		switch($type)
		{
			case 'src':
				$conditions = $src_conditions;
				$subtitle_prefix = __('Source');
				break;
			case 'dst':
				$conditions = $dst_conditions;
				$subtitle_prefix = __('Destination');
				break;
			case 'both':
				$conditions['OR'] = array(
					$src_conditions,
					$dst_conditions,
				);
				$subtitle_prefix = __('Source or Destination');
				break;
			default:
				$this->paginate['empty'] = true;
				break;
		}
		
		$this->set('subnet', $subnet);
		
		$page_subtitle = __('%s %s: %s', $subtitle_prefix, __('Subnet'), __('Rules'));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->paginate['recursive'] = $this->Rule->recursive = 0;
		$this->conditions = $conditions;
		return $this->index();
	}
	
//
	public function view($id = null) 
	{
		$this->Rule->id = $id;
		$this->Rule->recursive = 0;
		if (!$rule = $this->Rule->read(null, $this->Rule->id))
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}
		
		$this->set('rule', $rule);
	}

//
	public function add($rule_id = false, $force = false, $firewall_id = false) 
	{
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->Rule->create();
			$this->request->data['Rule']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->Rule->save($this->request->data))
			{
				$redirect = array('action' => 'view', $this->Rule->id);
				if($this->Rule->saveRedirect)
				{
					$redirect = $this->Rule->saveRedirect;
				}
				$this->Flash->success(__('The %s has been saved', __('Rule')));
				return $this->redirect($redirect);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Rule')));
			}
		}
		// cloning another rule as a new one
		elseif($rule_id)
		{
			$this->Rule->id = $rule_id;
			if (!$this->Rule->exists())
			{
				throw new NotFoundException(__('Unknown %s', __('Rule')));
			}
			
			$this->Rule->recursive = 0;
			$this->request->data = $this->Rule->read(null, $this->Rule->id);
			
			if(!$this->request->data['Rule']['use_fw_int'] and !$force)
			{
				return $this->redirect(array('action' => 'add_advanced', $rule_id));
			}
		}
		elseif($firewall_id)
		{
			return $this->redirect(array('action' => 'add_advanced', 0, $firewall_id));
		}
		
		$this->Rule->Firewall->typeFormListConditions = array('Firewall.simple' => true);
		$this->set('firewalls', $this->Rule->Firewall->typeFormList());
		$this->Rule->FwInterface->typeFormListConditions = array('FwInterface.simple' => true);
		$this->set('fw_interfaces', $this->Rule->FwInterface->typeFormList());
		$this->set('fw_ints', $this->Rule->FwInt->typeFormList());
		$this->Rule->Protocol->typeFormListConditions = array('Protocol.simple' => true);
		$this->set('protocols', $this->Rule->Protocol->typeFormList());
		$this->set('fisma_systems', $this->Rule->SrcFismaSystem->customTypeFormList());
		$this->Rule->SrcFog->typeFormListConditions = array('SrcFog.simple' => true);
		$this->set('fogs', $this->Rule->SrcFog->typeFormList());
		$this->Rule->SrcPog->typeFormListConditions = array('SrcPog.simple' => true);
		$this->set('pogs', $this->Rule->SrcPog->typeFormList());
	}

//
	public function add_advanced($rule_id = false, $firewall_id = false) 
	{
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->Rule->create();
			$this->request->data['Rule']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->Rule->save($this->request->data))
			{
				$redirect = array('action' => 'view', $this->Rule->id);
				if($this->Rule->saveRedirect)
				{
					$redirect = $this->Rule->saveRedirect;
				}
				$this->Flash->success(__('The %s has been saved', __('Rule')));
				return $this->redirect($redirect);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Rule')));
			}
		}
		
		// cloning another rule as a new one
		if($rule_id)
		{
			$this->Rule->id = $rule_id;
			if (!$this->Rule->exists())
			{
				throw new NotFoundException(__('Unknown %s', __('Rule')));
			}
			$this->Rule->recursive = 0;
			$this->request->data = $this->Rule->read(null, $this->Rule->id);
		}
		
		if($firewall_id)
		{
			$this->request->data['Rule']['firewall_id'] = $firewall_id;
		}
		
		$this->set('firewalls', $this->Rule->Firewall->typeFormList());
		$this->set('protocols', $this->Rule->Protocol->typeFormList());
		$this->set('fw_interfaces', $this->Rule->FwInterface->typeFormList());
		$this->set('fisma_systems', $this->Rule->SrcFismaSystem->customTypeFormList());
		$this->set('fogs', $this->Rule->SrcFog->typeFormList());
		$this->set('pogs', $this->Rule->SrcPog->typeFormList());
	}

//
	public function add_asa($rule_id = false, $firewall_id = false) 
	{
		if ($this->request->is('post'))
		{
			$rules_string = '';
			if(isset($this->request->data['Rule']['asa_rules']))
			{
				$rules_string = $this->request->data['Rule']['asa_rules'];
				unset($this->request->data['Rule']['asa_rules']);
			}
			
			$this->request->data['Rule']['added_user_id'] = AuthComponent::user('id');
			
			if ($results = $this->Rule->saveAsa($this->request->data, $rules_string))
			{
				$this->Flash->success($results);
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Rule')));
			}
		}
		
		// cloning another rule as a new one
		if($rule_id)
		{
			$this->Rule->id = $rule_id;
			if (!$this->Rule->exists())
			{
				throw new NotFoundException(__('Unknown %s', __('Rule')));
			}
			$this->Rule->recursive = 0;
			$this->request->data = $this->Rule->read(null, $this->Rule->id);
		}
		
		if($firewall_id)
		{
			$this->request->data['Rule']['firewall_id'] = $firewall_id;
		}
		
		$this->set('firewalls', $this->Rule->Firewall->typeFormListAppend(array(0 => __('-- From Config Below -- ') )));
		$this->set('fisma_systems', $this->Rule->SrcFismaSystem->customTypeFormList());
	}
	
	public function edit($id = null) 
	{
		$this->Rule->id = $id;
		$this->Rule->recursive = 0;
		if (!$rule = $this->Rule->read(null, $this->Rule->id))
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}
		
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data['Rule']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->Rule->save($this->request->data))
			{
				$this->bypassReferer = true;
				$redirect = array('action' => 'view', $this->Rule->id);
				if($this->Rule->saveRedirect)
				{
					$redirect = $this->Rule->saveRedirect;
				}
				$this->Flash->success(__('The %s has been saved', __('Rule')));
				return $this->redirect($redirect);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Rule')));
			}
		}
		else
		{
			$this->request->data = $rule;
		}
		
		$this->set('fw_ints', $this->Rule->FwInt->typeFormList());
		$this->set('firewalls', $this->Rule->Firewall->typeFormList());
		$this->set('protocols', $this->Rule->Protocol->typeFormList());
		$this->set('fw_interfaces', $this->Rule->FwInterface->typeFormList());
		$this->set('fisma_systems', $this->Rule->SrcFismaSystem->customTypeFormList());
		$this->set('fogs', $this->Rule->SrcFog->typeFormList());
		$this->set('pogs', $this->Rule->SrcPog->typeFormList());
	}

//
	public function edit_state($id = null) 
	{
		$this->Rule->id = $id;
		$this->Rule->recursive = 0;
		if (!$rule = $this->Rule->read(null, $this->Rule->id))
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}
		
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data['Rule']['modified'] = false;
			$this->request->data['Rule']['reviewed_user_id'] = AuthComponent::user('id');
			$this->request->data['Rule']['reviewed'] = date('Y-m-d H:i:s');
			
			$review_state_log_data = $this->request->data['ReviewStateLog'];
			unset($this->request->data['ReviewStateLog']);
			$review_state_log_data['old_review_state_id'] = $rule['Rule']['review_state_id'];
			$review_state_log_data['review_state_id'] = $this->request->data['Rule']['review_state_id'];
			$review_state_log_data['user_id'] = AuthComponent::user('id');
			
			if ($this->Rule->save($this->request->data))
			{
				$this->Rule->ReviewStateLog->create();
				$review_state_log_data['rule_id'] = $this->Rule->id;
				$this->Rule->ReviewStateLog->save($review_state_log_data);
				
				$this->bypassReferer = true;
				$redirect = array('action' => 'view', $this->Rule->id);
				if($this->Rule->saveRedirect)
				{
					$redirect = $this->Rule->saveRedirect;
				}
				$this->Flash->success(__('The %s has been saved', __('Rule')));
				return $this->redirect($redirect);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Rule')));
			}
		}
		else
		{
			$this->request->data = $rule;
		}
		
		$this->set('review_states', $this->Rule->ReviewState->find('list', array('order' => array('ReviewState.default' => 'desc', 'ReviewState.name' => 'asc')) ));
	}
	
	public function rescan($id = null) 
	{
		$this->Rule->id = $id;
		if (!$rule = $this->Rule->read(null, $this->Rule->id))
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}
		
		if($this->Rule->rescan($rule))
		{
			$this->Flash->success(__('The %s has been rescanned', __('Rule')));
		}
		else
		{
			$this->Flash->error(__('The %s could not be rescanned. Reason: %s', __('Rule'), $this->Rule->modelError));
		}
		
		$this->bypassReferer = true;
		return $this->redirect(['action' => 'view', $id]);
	}

//
	public function notify($id = null) 
	{
		$this->Rule->id = $id;
		if (!$this->Rule->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}
		
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data['NotifyUser'] = AuthComponent::user();
			if ($this->Rule->notifyUsers($this->request->data))
			{
				$this->Flash->success(__('The Notifications have been sent for this %s.', __('Rule')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$error = __('Error sending Notification for this %s. Please, try again.', __('Rule'));
				if($this->Rule->modelError)
					$error = $this->Rule->modelError;
				$this->Flash->error($error);
			}
		}
		else
		{
			$this->request->data = $this->Rule->read(null, $this->Rule->id);
		}
		
		$this->set('users', $this->Rule->RuleAddedUser->activeEmails());
	}

//
	public function multiselect_notify() 
	{
		if(!$rule_ids = $this->Session->read('Multiselect.NotifyIds'))
		{
			throw new NotFoundException(__('Invalid %s', __('Rules')));
		}
		
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$rule_ids = $this->Rule->multiselectIds($rule_ids);
			
			$this->request->data['NotifyUser'] = AuthComponent::user();
			
			if ($this->Rule->notifyUsersMany($this->request->data, $rule_ids))
			{
				if($referer = $this->Session->read('Multiselect.NotifyReferer'))
				{
					$referer = unserialize($referer);
					$this->Session->delete('Multiselect.NotifyReferer');
				}
				elseif($referer = $this->Session->read('Multiselect.Rules.Rule.multiselect_referer'))
				{
					$referer = unserialize($referer);
				}
				else
				{
					$referer = array('action' => 'index');
				}
				
				$this->Session->delete('Multiselect.NotifyIds');
				$this->Session->delete('Multiselect.Rules');
				
				$this->Flash->success(__('The Notifications have been sent for the %s.', __('Rules')));
				return $this->redirect($referer);
			}
			else
			{
				$error = __('Error sending Notification for the %s. Please, try again.', __('Rules'));
				if($this->Rule->modelError)
					$error = $this->Rule->modelError;
				$this->Flash->error($error);
			}
		}
		
		$this->set('users', $this->Rule->RuleAddedUser->activeEmails());
	}
	
//
	public function multiselect()
	{
	/*
	 * batch manage multiple items
	 */
		if (!$this->request->is('post') and !$this->request->is('put')) 
		{
			throw new MethodNotAllowedException();
		}
		
		if(!isset($this->request->data['Rule']['multiselect_option']))
		{
			$this->Flash->error(__('The %s were NOT updated. (1)', __('Rules')));
			return $this->redirect($this->referer());
		}
		
		if(!$this->request->data['Rule']['multiselect_option'])
		{
			$this->Flash->error(__('The %s were NOT updated. (2)', __('Rules')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->write('Multiselect.Rules', $this->request->data);
		
		// forward to a page where the user can choose a value
		$redirect = false;
		switch ($this->request->data['Rule']['multiselect_option']) 
		{
			case 'review_state':
				$redirect = array('action' => 'multiselect_review_state');
				break;
			case 'notify':
				$this->Session->write('Multiselect.NotifyIds', $this->request->data['multiple']);
				$redirect = array('action' => 'multiselect_notify');
				break;
		}
		
		if($redirect)
		{
			$this->bypassReferer = true;
			return $this->redirect($redirect);
		}
		
		$this->Flash->error(__('The %s were NOT updated.', __('Rules')));
		return $this->redirect($this->referer());
	}
	
//
	public function multiselect_review_state()
	{
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$sessionData = $this->Session->read('Multiselect.Rules');
			
			$this->request->data['Rule']['reviewed_user_id'] = AuthComponent::user('id');
			$this->request->data['Rule']['reviewed'] = "'". date('Y-m-d H:i:s'). "'";
			
			$review_state_log_data = $this->request->data['ReviewStateLog'];
			unset($this->request->data['ReviewStateLog']);
			
			$review_state_log_data['review_state_id'] = $this->request->data['Rule']['review_state_id'];
			$review_state_log_data['user_id'] = AuthComponent::user('id');
			
			// get the active ones to change
			$active_ids = array();
			foreach($sessionData['multiple'] as $rule_id => $active)
			{
				if(!$active) continue;
				$active_ids[$rule_id] = $rule_id;
			}
			
			// get their old review states
			$old_review_states = $this->Rule->find('list', array(
				'fields' => array('Rule.id', 'Rule.review_state_id'),
				'conditions' => array('Rule.id' => $active_ids),
			));
			
			// save a log for each one
			$saveMany = array();
			foreach($active_ids as $rule_id)
			{
				$saveMany[$rule_id] = array_merge($review_state_log_data, array(
					'rule_id' => $rule_id,
					'old_review_state_id' => $old_review_states[$rule_id],
				));
			}
			
			// we want to notify some users about this
			if(isset($this->request->data['Rule']['send_notification']))
			{
				if(isset($sessionData['multiple']))
				{
					$this->Session->write('Multiselect.NotifyIds', $sessionData['multiple']);
				}
				if(isset($sessionData['Rule']['multiselect_referer']))
				{
					$this->Session->write('Multiselect.NotifyReferer', $sessionData['Rule']['multiselect_referer']);
					
					$sessionData['Rule']['multiselect_referer'] = serialize(array('action' => 'multiselect_notify'));
				}
				unset($this->request->data['Rule']['send_notification']);
			}
			
			if($this->Rule->multiselect($sessionData, $this->request->data, AuthComponent::user('id'))) 
			{
				$this->Rule->ReviewStateLog->saveMany($saveMany);
				
				$this->Session->delete('Multiselect.Rules');
				$this->Flash->success(__('The %s were updated.', __('Rules')));
				$this->bypassReferer = true;
				return $this->redirect($this->Rule->multiselectReferer());
			}
			else
			{
				$this->Flash->error(__('The %s were NOT updated.', __('Rules')));
			}
		}
		
		// get the object types
		$this->set('review_states', $this->Rule->ReviewState->typeFormList());
	}
	
//
	public function toggle($field = null, $id = null)
	{
		if ($this->Rule->toggleRecord($id, $field))
		{
			$this->Flash->success(__('The %s has been updated.', __('Rule')));
		}
		else
		{
			$this->Flash->error($this->Rule->modelError);
		}
		
		return $this->redirect($this->referer());
	}
	
	public function flow_report()
	{
		if ($this->request->is('post') || $this->request->is('put'))
		{	
			if ($params = $this->Rule->updateFlowReport($this->request->data))
			{
				$this->viewClass = 'Media';
				$this->set($params);
			}
			else
			{
				$this->Flash->error(__('Unable to update Flow Report, reason:', $this->Rule->modelError));
			}
		}
	}

	public function admin_index()
	{
		return $this->index();
	}

	public function admin_user($user_id = null, $type = false) 
	{
		return $this->user($user_id, $type);
	}

	public function admin_firewall($firewall_id = 0)
	{
		return $this->firewall($firewall_id);
	}

	public function admin_import($import_id = 0)
	{
		return $this->import($import_id);
	}

	public function admin_fisma_system($fisma_system_id = 0)
	{
		return $this->fisma_system($fisma_system_id);
	}

	public function admin_fog($fog_id = 0)
	{
		return $this->fog($fog_id);
	}

	public function admin_pog($pog_id = 0)
	{
		return $this->pog($pog_id);
	}

	public function admin_fw_interface($fw_interface_id = 0)
	{
		return $this->fw_interface($fw_interface_id);
	}

	public function admin_protocol($protocol_id = 0)
	{
		return $this->protocol($protocol_id);
	}

	public function admin_fw_int($fw_int_id = 0)
	{
		return $this->fw_int($fw_int_id);
	}
	
//
	public function admin_view($id = null)
	{
		return $this->redirect(array('action' => 'view', $id, 'admin' => false));
	}

//
	public function admin_edit($id = null) 
	{
		$this->Rule->id = $id;
		if (!$this->Rule->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}
		
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data['Rule']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->Rule->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been updated', __('Rule')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Rule')));
			}
		}
		else
		{
			$this->Rule->recursive = 0;
			$this->request->data = $this->Rule->read(null, $this->Rule->id);
		}
		
		$this->set('firewalls', $this->Rule->Firewall->typeFormList());
		$this->set('protocols', $this->Rule->Protocol->typeFormList());
		$this->set('fw_interfaces', $this->Rule->FwInterface->typeFormList());
		$this->set('fisma_systems', $this->Rule->SrcFismaSystem->customTypeFormList());
		$this->set('fogs', $this->Rule->SrcFog->typeFormList());
		$this->set('pogs', $this->Rule->SrcPog->typeFormList());
	}

//
	public function admin_delete($id = null) 
	{
		$this->Rule->id = $id;
		if (!$this->Rule->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}

		if ($this->Rule->delete()) 
		{
			$this->Flash->success(__('%s deleted', __('Rule')));
			return $this->redirect(array('controller' => 'rules', 'action' => 'index', 'admin' => false));
		}
		
		$this->Flash->error(__('%s was not deleted', __('Rule')));
		return $this->redirect($this->referer());
	}
}