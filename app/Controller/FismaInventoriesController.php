<?php
App::uses('AppController', 'Controller');


class FismaInventoriesController extends AppController 
{
	public function search_results()
	{
		return $this->index();
	}
	
	public function index($format = false) 
	{
		$this->Prg->commonProcess();
		
		if($format)
		{
			$this->view = $format;
		}
		
		$conditions = array();
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->paginate['conditions'] = $this->FismaInventory->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->FismaInventory->recursive = 0;
			$this->paginate['contain'] = $this->FismaInventory->containDiscover(array('Tag'));
			$this->paginate['limit'] = $this->FismaInventory->find('count', array('conditions' => $this->paginate['conditions']));
			$this->paginate['maxLimit'] = $this->paginate['limit'];
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->FismaInventory->recursive = 0;
		$this->paginate['contain'] = array(
			'FismaSystem', 
			'FismaSystem.FismaSystemParent',
			'FismaSystem.OwnerContact',
			'FismaSystem.FismaSystemHosting',
			'FismaType', 'FismaStatus', 'FismaSource', 'AddedUser', 'ModifiedUser', 
			'Tag', 'SubnetMember', 'SubnetMember.Subnet'
		);
		$this->paginate['order'] = array('FismaInventory.name' => 'asc');
		
		$this->Filter->Filter();
		$this->set('fisma_inventories', $this->paginate());
		
		$fismaTypes = $this->FismaInventory->FismaType->typeFormList();
		$fismaStatuses = $this->FismaInventory->FismaStatus->typeFormList();
		$fismaSources = $this->FismaInventory->FismaSource->typeFormList();
		$fismaSystems = $this->FismaInventory->FismaSystem->typeFormList();
		$this->set(compact(array('fismaTypes', 'fismaStatuses', 'fismaSources', 'fismaSystems')));
	}

	public function fisma_system($id = null, $format = false) 
	{
		if (!$fisma_system = $this->FismaInventory->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		$this->set('fisma_system', $fisma_system);
		
		if($format)
		{
			$this->view = $format;
		}
		
		$conditions = array(
			'FismaInventory.fisma_system_id' => $id,
		); 
		if(isset($this->conditions))
		{
			$conditions = array_replace_recursive($conditions, $this->conditions);
		}
		
		$this->conditions = $conditions;
		return $this->index(); 
	}
	
	public function fisma_system_all($id = false, $format = false)
	{
		$this->FismaInventory->FismaSystem->id = $id;
		$children_ids = $this->FismaInventory->FismaSystem->find('MyChildren', array(
			'type' => 'list',
			'fields' => array('FismaSystem.id', 'FismaSystem.id'),
		));
		
		if(!count($children_ids))
		{
			$children_ids = $id;
		}
		else
		{
			$children_ids[$id] = $id;
		}
		
		$this->conditions = array(
			'FismaInventory.fisma_system_id' => $children_ids,
		);
		
		return $this->fisma_system($id, $format);
	}
	
	public function fisma_system_children($id = false, $format = false)
	{
		$this->FismaInventory->FismaSystem->id = $id;
		$children_ids = $this->FismaInventory->FismaSystem->find('MyChildren', array(
			'type' => 'list',
			'fields' => array('FismaSystem.id', 'FismaSystem.id'),
		));
		
		$this->conditions = array(
			'FismaInventory.fisma_system_id' => $children_ids,
		);
		
		return $this->fisma_system($id, $format);
	}

	public function type($id = null) 
	{
		if (!$fisma_type = $this->FismaInventory->FismaType->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Type')));
		}
		$this->set('fisma_type', $fisma_type);
		
		$page_subtitle = __('%s: %s', __('FISMA Type'), $fisma_type['FismaType']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$conditions = array(
			'FismaInventory.fisma_type_id' => $id,
		); 
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function status($id = null) 
	{
		if (!$fisma_status = $this->FismaInventory->FismaStatus->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Status')));
		}
		$this->set('fisma_status', $fisma_status);
		
		$page_subtitle = __('%s: %s', __('FISMA Status'), $fisma_status['FismaStatus']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$conditions = array(
			'FismaInventory.fisma_status_id' => $id,
		);
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function source($id = null) 
	{
		if (!$fisma_source = $this->FismaInventory->FismaSource->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Source')));
		}
		$this->set('fisma_source', $fisma_source);
		
		$page_subtitle = __('%s: %s', __('FISMA Source'), $fisma_source['FismaSource']['name']);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$conditions = array(
			'FismaInventory.fisma_source_id' => $id,
		); 
		
		$this->conditions = $conditions;
		return $this->index();
	}

	public function tag($tag_id = null) 
	{
		$tag = $this->FismaInventory->Tag->read(null, $tag_id);
		if (!$tag)
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		
		$conditions = array();
		
		// this is a weird situation where the normal way wasn't working.
		$conditions[$this->FismaInventory->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'FismaInventory'). ' AND'] = true;
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		return $this->index();
	}
	
	public function view($id = false)
	{
		$this->FismaInventory->recursive = 0;
		$this->FismaInventory->contain(array(
			'FismaSystem', 'FismaType', 'FismaStatus', 'FismaSource', 'AddedUser', 'ModifiedUser', 'Tag',
			'FismaSystem.OwnerContact', 'FismaSystem.OwnerContact.Sac', 'FismaSystem.OwnerContact.Sac.Branch', 'FismaSystem.OwnerContact.Sac.Branch.Division', 'FismaSystem.OwnerContact.Sac.Branch.Division.Org',
		));
		if(!$fisma_inventory = $this->FismaInventory->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		
		$this->set('fisma_inventory', $fisma_inventory);
	}
	
	public function saa_add($fisma_system_id = null)
	{
		if ($this->request->is('post'))
		{
			$this->FismaInventory->create();
			$this->request->data['FismaInventory']['added_user_id'] = AuthComponent::user('id');
			if ($this->FismaInventory->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA Inventory')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$msg = __('The %s could not be saved. Please, try again.', __('FISMA Inventory'));
				if($this->FismaInventory->modelError) $msg = __('The %s could not be saved. Reason: %s', __('FISMA Inventory'), $this->FismaInventory->modelError);
				$this->Session->setFlash($msg);
			}
		}
		elseif($fisma_system_id)
		{
			$this->request->data['FismaInventory']['fisma_system_id'] = $fisma_system_id;
		}
		
		$fismaTypeDefaultId = $this->FismaInventory->FismaType->defaultId();
		$this->request->data['FismaInventory']['fisma_type_id'] = $fismaTypeDefaultId;
		
		$fismaStatusDefaultId = $this->FismaInventory->FismaStatus->defaultId();
		$this->request->data['FismaInventory']['fisma_status_id'] = $fismaStatusDefaultId;
		
		$fismaSourceDefaultId = $this->FismaInventory->FismaSource->defaultId();
		$this->request->data['FismaInventory']['fisma_source_id'] = $fismaSourceDefaultId;
		
		$fismaSystems = $this->FismaInventory->FismaSystem->find('list', array('order' => array('FismaSystem.name' => 'ASC') ));
		$fismaTypes = $this->FismaInventory->FismaType->find('list');
		$fismaStatuses = $this->FismaInventory->FismaStatus->find('list');
		$fismaSources = $this->FismaInventory->FismaSource->find('list');
		$this->set(compact('fismaSystems', 'fismaTypes', 'fismaStatuses', 'fismaSources'));
	}

	public function saa_edit($id = null)
	{
		if (!$this->FismaInventory->exists($id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		if ($this->request->is(array('post', 'put'))) 
		{
			$this->request->data['FismaInventory']['modified_user_id'] = AuthComponent::user('id');
			if ($this->FismaInventory->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA Inventory')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$msg = __('The %s could not be saved. Please, try again.', __('FISMA Inventory'));
				if($this->FismaInventory->modelError) $msg = __('The %s could not be saved. Reason: %s', __('FISMA Inventory'), $this->FismaInventory->modelError);
				$this->Session->setFlash($msg);
			}
		}
		else
		{
			$this->FismaInventory->recursive = 0;
			$this->FismaInventory->contain(array('Tag'));
			$this->request->data = $this->FismaInventory->read(null, $id);
		}
		
		$fismaSystems = $this->FismaInventory->FismaSystem->find('list', array('order' => array('FismaSystem.name' => 'ASC') ));
		$fismaTypes = $this->FismaInventory->FismaType->find('list');
		$fismaStatuses = $this->FismaInventory->FismaStatus->find('list');
		$fismaSources = $this->FismaInventory->FismaSource->find('list');
		$this->set(compact('fismaSystems', 'fismaTypes', 'fismaStatuses', 'fismaSources'));
	}
	
	public function saa_delete($id = null) 
	{
		$this->FismaInventory->id = $id;
		if (!$this->FismaInventory->exists()) {
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		
		if ($this->FismaInventory->delete()) {
			$this->Session->setFlash(__('The %s has been deleted.', __('FISMA Inventory')));
		} else {
			$this->Session->setFlash(__('The %s could not be deleted. Please, try again.', __('FISMA Inventory')));
		}
		return $this->redirect(array('action' => 'index', 'saa' => false));
	}
	
	public function saa_batch_add() 
	{
		if ($this->request->is('post'))
		{	
			if ($headers = $this->FismaInventory->batchGetHeaders($this->request->data))
			{
				Cache::write('Csv_headers', $headers);
				Cache::write('Csv_data', $this->request->data);
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'batch_review_headers', 'saa' => true));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Inventory')));
			}
		}
		
		$this->request->data = $this->Session->read('Csv_data');
	}
	
	public function saa_batch_review_headers() 
	{
		if ($this->request->is('post'))
		{
			Cache::write('Csv_header_map', $this->request->data);
			$this->bypassReferer = true;
			return $this->redirect(array('action' => 'batch_review_data', 'saa' => true));
		}
		
		// verify the session headers were extracted
		if(!$headers = Cache::read('Csv_headers'))
		{
			$this->Session->setFlash(__('Unable to detect the headers from the CSV data (review_headers).'));
			$this->bypassReferer = true;
			return $this->redirect(array('action' => 'batch_add', 'saa' => true));
		}
		
		$this->set('headers', $headers);
		$this->set('csv_field_map', $this->FismaInventory->csv_field_map);
	}
	
	public function saa_batch_review_data() 
	{
		// verify the session headers were extracted
		if(!$header_map = Cache::read('Csv_header_map'))
		{
			$this->Session->setFlash(__('Unable to detect the headers from the CSV data (review_data).'));
			$this->bypassReferer = true;
			return $this->redirect(array('action' => 'batch_add', 'saa' => true));
		}
			
		if ($this->request->is('post'))
		{
			$data_append = Cache::read('Csv_data');
			$data_append['FismaInventory']['added_user_id'] = AuthComponent::user('id');
			$data_append['FismaInventory']['fisma_system_id'] = 4;
			
			
			if ($this->FismaInventory->batchSave($this->request->data, $data_append))
			{
				// clear the session
				Cache::delete('Csv_headers');
				Cache::delete('Csv_header_map');
				Cache::delete('Csv_data');
				$this->Session->setFlash(__('The CSV Items been saved.'));
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->request->data = $this->FismaInventory->batchDataToFix;
				// update the session
				
				$this->Session->setFlash(__('Errors occurred. %s CSV Items Saved, %s CSV Items Needs Attention.', $this->FismaInventory->batchSaved, $this->FismaInventory->batchIssues));
			}
		}
		else
		{
			$this->request->data = $this->FismaInventory->batchMapCsv(Cache::read('Csv_data'), $header_map);
			$validate_data = $this->request->data;
			$validate = $this->FismaInventory->validateMany($validate_data);
		}
		
		$fismaTypeDefaultId = $this->FismaInventory->FismaType->defaultId();
		$this->request->data['FismaInventory']['fisma_type_id'] = $fismaTypeDefaultId;
		
		$fismaStatusDefaultId = $this->FismaInventory->FismaStatus->defaultId();
		$this->request->data['FismaInventory']['fisma_status_id'] = $fismaStatusDefaultId;
		
		$fismaSourceDefaultId = $this->FismaInventory->FismaSource->defaultId();
		$this->request->data['FismaInventory']['fisma_source_id'] = $fismaSourceDefaultId;
		
		$fismaSystems = $this->FismaInventory->FismaSystem->find('list');
		$fismaTypes = $this->FismaInventory->FismaType->find('list');
		$fismaStatuses = $this->FismaInventory->FismaStatus->find('list');
		$fismaSources = $this->FismaInventory->FismaSource->find('list');
		$this->set(compact('fismaSystems', 'fismaTypes', 'fismaStatuses', 'fismaSources'));
	}
	
	public function multiselect()
	{
		if(!$this->request->is('post'))
		{
			throw new MethodNotAllowedException();
		}
		
		// forward to a page where the user can choose a value
		$redirect = false;
		if(isset($this->request->data['multiple']))
		{
			$ids = array();
			foreach($this->request->data['multiple'] as $id => $selected) { if($selected) $ids[] = $id; }
			$this->request->data['multiple'] = $this->FismaInventory->find('list', array(
				'fields' => array('FismaInventory.id', 'FismaInventory.id'),
				'conditions' => array('FismaInventory.id' => $ids),
				'recursive' => -1,
			));
		}
		
		if($this->request->data['FismaInventory']['multiselect_option'] == 'fisma_system')
		{
			$redirect = array('action' => 'multiselect_fisma_system', 'saa' => true);
		}
		elseif($this->request->data['FismaInventory']['multiselect_option'] == 'multi_fisma_system')
		{
			$redirect = array('action' => 'multiselect_multi_fisma_system', 'saa' => true);
		}
		if($this->request->data['FismaInventory']['multiselect_option'] == 'fisma_type')
		{
			$redirect = array('action' => 'multiselect_fisma_type', 'saa' => true);
		}
		elseif($this->request->data['FismaInventory']['multiselect_option'] == 'multi_fisma_type')
		{
			$redirect = array('action' => 'multiselect_multi_fisma_type', 'saa' => true);
		}
		if($this->request->data['FismaInventory']['multiselect_option'] == 'fisma_status')
		{
			$redirect = array('action' => 'multiselect_fisma_status', 'saa' => true);
		}
		elseif($this->request->data['FismaInventory']['multiselect_option'] == 'multi_fisma_status')
		{
			$redirect = array('action' => 'multiselect_multi_fisma_status', 'saa' => true);
		}
		if($this->request->data['FismaInventory']['multiselect_option'] == 'fisma_source')
		{
			$redirect = array('action' => 'multiselect_fisma_source', 'saa' => true);
		}
		elseif($this->request->data['FismaInventory']['multiselect_option'] == 'multi_fisma_source')
		{
			$redirect = array('action' => 'multiselect_multi_fisma_source', 'saa' => true);
		}
		if($this->request->data['FismaInventory']['multiselect_option'] == 'tag')
		{
			$redirect = array('action' => 'multiselect_tag', 'saa' => true);
		}
		elseif($this->request->data['FismaInventory']['multiselect_option'] == 'multi_tag')
		{
			$redirect = array('action' => 'multiselect_multi_tag', 'saa' => true);
		}
		
		if($redirect)
		{
			Cache::write('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), $this->request->data, 'sessions');
			$this->bypassReferer = true;
			return $this->redirect($redirect);
		}
		
		if($this->FismaInventory->multiselect($this->request->data))
		{
			$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
		$this->redirect($this->referer());
	}
	
	public function saa_multiselect_fisma_system()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$multiselect_value = (isset($this->request->data['FismaInventory']['fisma_system_id'])?$this->request->data['FismaInventory']['fisma_system_id']:0);
			if($multiselect_value)
			{
				if($this->FismaInventory->multiselect_items($sessionData, $this->request->data)) 
				{
					Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
					$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
					return $this->redirect($this->FismaInventory->multiselectReferer());
				}
				else
				{
					$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
				}
			}
			else
			{
				$this->Session->setFlash(__('Please select a %s', __('FISMA System')));
			}
		}
		
		$selected_items = array();
		if(isset($sessionData['multiple']))
		{
			$_selected_items = $this->FismaInventory->find('all', array(
				'conditions' => array(
					'FismaInventory.id' => $sessionData['multiple'],
				),
				'fields' => array('FismaInventory.id', 'FismaInventory.name', 'FismaInventory.ip_address'),
			));
			
			foreach($_selected_items as $_selected_item)
			{
				$selected_id = $_selected_item['FismaInventory']['id'];
				$selected_name = ($_selected_item['FismaInventory']['name']?$_selected_item['FismaInventory']['name']:($_selected_item['FismaInventory']['ip_address']?$_selected_item['FismaInventory']['ip_address']:$_selected_item['FismaInventory']['id']));
				$selected_items[$selected_id] = $selected_name;
			}
		}
		
		$this->set('selected_items', $selected_items);
		
		$this->set('fismaSystems', $this->FismaInventory->FismaSystem->find('list', array('order' => array('FismaSystem.name' => 'ASC'))));
	}
	
	public function saa_multiselect_multi_fisma_system()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			if($this->FismaInventory->multiselect_items_multiple($sessionData, $this->request->data['FismaInventory'])) 
			{
				Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
				$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
				return $this->redirect($this->FismaInventory->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
			}
		}

		$this->Prg->commonProcess();
		
		$ids = array();
		if(isset($sessionData['multiple']))
		{
			$ids = $sessionData['multiple'];
		}
		
		$conditions = array('FismaInventory.id' => array_keys($ids));
		$this->FismaInventory->recursive = 0;
		$this->paginate['limit'] = count($ids);
		$this->paginate['order'] = array('FismaInventory.created' => 'desc');
		$this->paginate['conditions'] = $this->FismaInventory->conditions($conditions, $this->passedArgs);
		$this->set('fisma_inventories', $this->paginate());
		
		$this->set('fismaSystems', $this->FismaInventory->FismaSystem->find('list', array('order' => array('FismaSystem.name' => 'ASC'))));
	}
	
	public function saa_multiselect_fisma_type()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$multiselect_value = (isset($this->request->data['FismaInventory']['fisma_type_id'])?$this->request->data['FismaInventory']['fisma_type_id']:0);
			if($multiselect_value)
			{
				if($this->FismaInventory->multiselect_items($sessionData, $this->request->data)) 
				{
					Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
					$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
					return $this->redirect($this->FismaInventory->multiselectReferer());
				}
				else
				{
					$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
				}
			}
			else
			{
				$this->Session->setFlash(__('Please select a %s', __('FISMA System')));
			}
		}
		
		$selected_items = array();
		if(isset($sessionData['multiple']))
		{
			$selected_items = $this->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.id' => $sessionData['multiple'],
				),
				'fields' => array('FismaInventory.id', 'FismaInventory.name'),
			));
		}
		
		$this->set('selected_items', $selected_items);
		
		$this->set('fismaTypes', $this->FismaInventory->FismaType->find('list', array('order' => array('FismaType.name' => 'ASC')) ));
	}
	
	public function saa_multiselect_multi_fisma_type()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			if($this->FismaInventory->multiselect_items_multiple($sessionData, $this->request->data['FismaInventory'])) 
			{
				Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
				$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
				return $this->redirect($this->FismaInventory->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
			}
		}

		$this->Prg->commonProcess();
		
		$ids = array();
		if(isset($sessionData['multiple']))
		{
			$ids = $sessionData['multiple'];
		}
		
		$conditions = array('FismaInventory.id' => array_keys($ids));
		$this->FismaInventory->recursive = 0;
		$this->paginate['limit'] = count($ids);
		$this->paginate['order'] = array('FismaInventory.created' => 'desc');
		$this->paginate['conditions'] = $this->FismaInventory->conditions($conditions, $this->passedArgs);
		$this->set('fisma_inventories', $this->paginate());
		
		$this->set('fismaTypes', $this->FismaInventory->FismaType->find('list', array('order' => array('FismaType.name' => 'ASC')) ));
	}
	
	public function saa_multiselect_fisma_status()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$multiselect_value = (isset($this->request->data['FismaInventory']['fisma_status_id'])?$this->request->data['FismaInventory']['fisma_status_id']:0);
			if($multiselect_value)
			{
				if($this->FismaInventory->multiselect_items($sessionData, $this->request->data)) 
				{
					Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
					$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
					return $this->redirect($this->FismaInventory->multiselectReferer());
				}
				else
				{
					$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
				}
			}
			else
			{
				$this->Session->setFlash(__('Please select a %s', __('FISMA System')));
			}
		}
		
		$selected_items = array();
		if(isset($sessionData['multiple']))
		{
			$selected_items = $this->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.id' => $sessionData['multiple'],
				),
				'fields' => array('FismaInventory.id', 'FismaInventory.name'),
			));
		}
		
		$this->set('selected_items', $selected_items);
		
		$this->set('fismaStatuses', $this->FismaInventory->FismaStatus->find('list', array('order' => array('FismaStatus.name' => 'ASC')) ));
	}
	
	public function saa_multiselect_multi_fisma_status()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			if($this->FismaInventory->multiselect_items_multiple($sessionData, $this->request->data['FismaInventory'])) 
			{
				Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
				$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
				return $this->redirect($this->FismaInventory->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
			}
		}

		$this->Prg->commonProcess();
		
		$ids = array();
		if(isset($sessionData['multiple']))
		{
			$ids = $sessionData['multiple'];
		}
		
		$conditions = array('FismaInventory.id' => array_keys($ids));
		$this->FismaInventory->recursive = 0;
		$this->paginate['limit'] = count($ids);
		$this->paginate['order'] = array('FismaInventory.created' => 'desc');
		$this->paginate['conditions'] = $this->FismaInventory->conditions($conditions, $this->passedArgs);
		$this->set('fisma_inventories', $this->paginate());
		
		$this->set('fismaStatuses', $this->FismaInventory->FismaStatus->find('list', array('order' => array('FismaStatus.name' => 'ASC')) ));
	}
	
	public function saa_multiselect_fisma_source()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$multiselect_value = (isset($this->request->data['FismaInventory']['fisma_source_id'])?$this->request->data['FismaInventory']['fisma_source_id']:0);
			if($multiselect_value)
			{
				if($this->FismaInventory->multiselect_items($sessionData, $this->request->data)) 
				{
					Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
					$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
					return $this->redirect($this->FismaInventory->multiselectReferer());
				}
				else
				{
					$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
				}
			}
			else
			{
				$this->Session->setFlash(__('Please select a %s', __('FISMA System')));
			}
		}
		
		$selected_items = array();
		if(isset($sessionData['multiple']))
		{
			$selected_items = $this->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.id' => $sessionData['multiple'],
				),
				'fields' => array('FismaInventory.id', 'FismaInventory.name'),
			));
		}
		
		$this->set('selected_items', $selected_items);
		
		$this->set('fismaSources', $this->FismaInventory->FismaSource->find('list', array('order' => array('FismaSource.name' => 'ASC')) ));
	}
	
	public function saa_multiselect_multi_fisma_source()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			if($this->FismaInventory->multiselect_items_multiple($sessionData, $this->request->data['FismaInventory'])) 
			{
				Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
				$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
				return $this->redirect($this->FismaInventory->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
			}
		}

		$this->Prg->commonProcess();
		
		$ids = array();
		if(isset($sessionData['multiple']))
		{
			$ids = $sessionData['multiple'];
		}
		
		$conditions = array('FismaInventory.id' => array_keys($ids));
		$this->FismaInventory->recursive = 0;
		$this->paginate['limit'] = count($ids);
		$this->paginate['order'] = array('FismaInventory.created' => 'desc');
		$this->paginate['conditions'] = $this->FismaInventory->conditions($conditions, $this->passedArgs);
		$this->set('fisma_inventories', $this->paginate());
		
		$this->set('fismaSources', $this->FismaInventory->FismaSource->find('list', array('order' => array('FismaSource.name' => 'ASC')) ));
	}
	
	public function saa_multiselect_tag()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$multiselect_value = (isset($this->request->data['FismaInventory']['tags'])?$this->request->data['FismaInventory']['tags']:'');
			if($multiselect_value)
			{
				if($this->FismaInventory->multiselect_addTags($sessionData, $this->request->data)) 
				{
					Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
					$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
					return $this->redirect($this->FismaInventory->multiselectReferer());
				}
				else
				{
					$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
				}
			}
			else
			{
				$this->Session->setFlash(__('Please select a %s', __('FISMA System')));
			}
		}
		
		$selected_items = array();
		if(isset($sessionData['multiple']))
		{
			$selected_items = $this->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.id' => $sessionData['multiple'],
				),
				'fields' => array('FismaInventory.id', 'FismaInventory.name'),
			));
		}
		
		$this->set('selected_items', $selected_items);
	}
	
	public function saa_multiselect_multi_tag()
	{
		$sessionData = Cache::read('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			if($this->FismaInventory->multiselect_items_multiple($sessionData, $this->request->data['FismaInventory'])) 
			{
				Cache::delete('Multiselect_'.$this->FismaInventory->alias.'_'. AuthComponent::user('id'), 'sessions');
				$this->Session->setFlash(__('The %s were updated.', __('FISMA Inventory Items')));
				return $this->redirect($this->FismaInventory->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The %s were NOT updated.', __('FISMA Inventory Items')));
			}
		}

		$this->Prg->commonProcess();
		
		$ids = array();
		if(isset($sessionData['multiple']))
		{
			$ids = $sessionData['multiple'];
		}
		
		$conditions = array('FismaInventory.id' => array_keys($ids));
		$this->FismaInventory->recursive = 0;
		$this->paginate['contain'] = array('FismaSystem', 'FismaType', 'FismaStatus', 'FismaSource', 'AddedUser', 'ModifiedUser', 'Tag');
		$this->paginate['limit'] = count($ids);
		$this->paginate['order'] = array('FismaInventory.created' => 'desc');
		$this->paginate['conditions'] = $this->FismaInventory->conditions($conditions, $this->passedArgs);
		$this->set('fisma_inventories', $this->paginate());
	}
	
	public function admin_fisma_system($id = null) 
	{
		return $this->fisma_system($id);
	}
}
