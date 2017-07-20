<?php

App::uses('ContactsAdAccountsController', 'Contacts.Controller');

class AdAccountsController extends ContactsAdAccountsController
{
	public function fisma_system_owners()
	{
		$ownerIds = $this->AdAccount->OwnerContact->getOwners();
		
		$this->paginate['contain'] = array('AdAccountDetail');
		$this->conditions = array(
			'AdAccount.id' => array_keys($ownerIds),
		);
		
		$page_title = __('%s Owners', __('FISMA System'));
		$this->set('page_title', $page_title);
		$this->set('search_placeholder', $page_title);
		
		return $this->index();
	}
	
	public function gridedit()
	{
		if(isset($this->request->data['AdAccountDetail']) and isset($this->request->data['AdAccount']))
		{
			if(!isset($this->request->data['AdAccountDetail']['id']) and isset($this->request->data['AdAccount']['id']))
			{
				$this->request->data['AdAccountDetail']['id'] = $this->AdAccount->AdAccountDetail->checkAddUpdate($this->request->data['AdAccount']['id']);
			}
		}
		return parent::gridedit();
	}
}
