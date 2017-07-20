<?php
App::uses('AppController', 'Controller');

class SubnetsController extends AppController 
{
	public $components = array(
		'Batcher' => array(
			'className' => 'Batcher.Batcher',
			'objectName' => 'Subnet',
			'objectsName' => 'Subnets',
		),
	);
	
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->Subnet->includeStats = true;
		$this->Subnet->recursive = 0;
		$this->paginate['order'] = array('Subnet.cidr' => 'asc');
		$this->paginate['conditions'] = $this->Subnet->conditions($conditions, $this->passedArgs); 
		
		$this->set('subnets', $this->paginate());
	}
	
	public function admin_view($id = null) 
	{
		if(!$subnet = $this->Subnet->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		$this->set('subnet', $subnet);
	}
	
	public function admin_batcher_step1() 
	{
		$this->Batcher->batcher_step1();
	}
	
	public function admin_batcher_step2() 
	{
		$this->Batcher->batcher_step2();
	}
	
	public function admin_batcher_step3() 
	{
		$this->Batcher->batcher_step3();
	}
	
	public function admin_batcher_step4() 
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'index'));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post')) 
		{
			$this->Subnet->create();
			if ($this->Subnet->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved.', __('Subnet')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Subnet')));
			}
		}
	}
	
	public function admin_subnet_check()
	{
		if (!$this->request->is('ajax')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
		if ($this->request->is('post')) 
		{
			if($results = $this->Subnet->calcNetwork($this->request->data))
			{
				return new CakeResponse(array('body'=> json_encode(array('data' => $results)),'status' => 200));
			}
			return new CakeResponse(array('body'=> json_encode(array('error_msg' => $this->Subnet->modelError )),'status' => 500));
			
		}
		return new CakeResponse(array('body'=> json_encode(array('error_msg'=>__('Not a POST'))),'status' => 403));
	}
	
	public function admin_edit($id = null) 
	{
		if (!$subnet = $this->Subnet->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->Subnet->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved.', __('Subnet')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('Subnet')));
			}
		}
		else
		{
			$this->request->data = $subnet;
		}
	}
	
	public function admin_rescan($id = null) 
	{
		$this->Subnet->id = $id;
		if (!$this->Subnet->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		
		$this->Subnet->shell_input = false;
		$out = $this->Subnet->rescan($this->Subnet->id);
		
		$this->Flash->success(__('The %s has been rescanned.', __('Subnet')));
		
		return $this->redirect($this->referer());
	}
	
	public function admin_rescan_all() 
	{	
		$this->Subnet->shell_input = false;
		$out = $this->Subnet->rescanAll();
		
		$this->Flash->success(__('ALL %s have been rescanned.', __('Subnets')));
		
		return $this->redirect($this->referer());
	}
	
	public function admin_delete($id = null) 
	{
		$this->Subnet->id = $id;
		if (!$this->Subnet->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		
		if ($this->Subnet->delete()) 
		{
			$this->Flash->success(__('The %s has been deleted.', __('Subnet')));
		} 
		else 
		{
			$this->Flash->error(__('The %s could not be deleted. Please, try again.', __('Subnet')));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
