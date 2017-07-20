<?php
class HostAliasesController extends AppController 
{
//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->paginate['order'] = array('HostAlias.name' => 'asc');
		$this->paginate['conditions'] = $this->HostAlias->conditions($conditions, $this->passedArgs); 
		$this->set('host_aliases', $this->paginate());
	}
	
	public function lookup_ip()
	{
	/*
	 * Used to lookup and ip address to see what it's hostname is
	 */
		$this->autoRender = FALSE;
		if($this->RequestHandler->isAjax())
		{
			$this->autoRender = false;
			$this->layout = false;
				
			$ip_address = (isset($this->request->data['value'])?$this->request->data['value']:false);
			
			if($ip_address == 'TBD')
			{
				return true;
			}
			
			// try to find it in our host aliases table
			
			if($aliases = $this->HostAlias->IpLookup($ip_address))
			{
				echo implode(', ', $aliases);
			}
		}
	}

//
	public function tip($host = false)
	{
/*
		if (!$this->request->is('ajax')) 
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Host Alias'), '1'));
		}
*/
		$host = base64_decode($host);
		if (!trim($host))
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('Host Alias'), '2'));
		}
		
		$this->set('aliases', $this->HostAlias->IpLookup(trim($host)));
		
		$this->layout = 'ajax_nodebug';
	}
	
	public function add() 
	{
		if ($this->request->is('post'))
		{
			$this->HostAlias->create();
			$this->request->data['HostAlias']['added_user_id'] = AuthComponent::user('id');
			
			if ($this->HostAlias->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Host Alias')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Host Alias')));
			}
		}
	}
	
	public function edit($id = null) 
	{
		$this->HostAlias->id = $id;
		if (!$fog = $this->HostAlias->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Host Alias')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['HostAlias']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->HostAlias->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Host Alias')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Host Alias')));
			}
		}
		else
		{
			$this->request->data = $this->HostAlias->read(null, $id);
		}
	}

}