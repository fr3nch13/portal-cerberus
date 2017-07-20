<?php
App::uses('AppController', 'Controller');
/**
 * AdAccountFismaSystems Controller
 *
 * @property AdAccountFismaSystem $AdAccountFismaSystem
 */
class AdAccountsFismaSystemsController extends AppController 
{
	public $uses = array('AdAccountFismaSystem');
	
	public function index()
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->paginate['contain'] = array(
			'FismaSystem', 'FismaContactType',
			'AdAccount', 'AdAccount.Sac', 'AdAccount.Sac.Branch', 'AdAccount.Sac.Branch.Division', 'AdAccount.Sac.Branch.Division.Org',
		);
		$this->paginate['order'] = array('FismaSystem.name' => 'ASC', 'FismaContactType.primary_priority' => 'ASC');
		$this->paginate['conditions'] = $this->AdAccountFismaSystem->conditions($conditions, $this->passedArgs);
		$adAccounts_fismaSystems = $this->paginate();
		$this->set(compact('adAccounts_fismaSystems'));
		
		$fismaContactTypes = $this->AdAccountFismaSystem->FismaContactType->typeFormList();
		$multiselectOptions = $this->AdAccountFismaSystem->multiselectOptions(false, true);
		$this->set(compact('fismaContactTypes', 'multiselectOptions'));
	}
	
	public function ad_account($ad_account_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->AdAccountFismaSystem->AdAccount->recursive = -1;
		if(!$adAccount = $this->AdAccountFismaSystem->AdAccount->read(null, $ad_account_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA Contact')));
		}
		$this->set('adAccount', $adAccount);
		
		$conditions = array(
			'AdAccountFismaSystem.ad_account_id' => $ad_account_id, 
		);
		$conditions = $this->AdAccountFismaSystem->conditions($conditions, $this->passedArgs);
		
		$adAccounts_fismaSystems = $this->AdAccountFismaSystem->find('all', array(
			'contain' => array('AdAccount', 'FismaContactType', 'FismaSystem'),
			'conditions' => $conditions,
			'order' => array('FismaSystem.name' => 'ASC', 'FismaContactType.primary_priority' => 'ASC'),
		));
		
		if(isset($this->passedArgs['getcount']))
		{
			echo count($adAccounts_fismaSystems);
			exit;
		}
		
		$this->set(compact('adAccounts_fismaSystems'));
		
		$fismaContactTypes = $this->AdAccountFismaSystem->FismaContactType->typeFormList();
		$multiselectOptions = $this->AdAccountFismaSystem->multiselectOptions(false, true);
		$this->set(compact('fismaContactTypes', 'multiselectOptions'));
	}
	
	public function admin_ad_account($id = null) 
	{
		return $this->ad_account($id);
	}
	
	public function fisma_system($fisma_system_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->AdAccountFismaSystem->FismaSystem->recursive = -1;
		if(!$fismaSystem = $this->AdAccountFismaSystem->FismaSystem->read(null, $fisma_system_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA System')));
		}
		$this->set('fismaSystem', $fismaSystem);
		
		$conditions = array(
			'AdAccountFismaSystem.fisma_system_id' => $fisma_system_id, 
		);
		$conditions = $this->AdAccountFismaSystem->conditions($conditions, $this->passedArgs);
		
		$adAccounts_fismaSystems = $this->AdAccountFismaSystem->find('all', array(
			'contain' => array('AdAccount', 'FismaContactType', 'FismaSystem', 'AdAccount.Sac', 'AdAccount.Sac.Branch', 'AdAccount.Sac.Branch.Division', 'AdAccount.Sac.Branch.Division.Org'),
			'order' => array('FismaContactType.primary_priority' => 'ASC'),
			'conditions' => $conditions,
		));
		
		$this->set(compact('adAccounts_fismaSystems'));
		
		$adAccounts = $this->AdAccountFismaSystem->AdAccount->typeFormList();
		$fismaContactTypes = $this->AdAccountFismaSystem->FismaContactType->typeFormList();
		$multiselectOptions = $this->AdAccountFismaSystem->multiselectOptions(false, true);
		$this->set(compact('adAccounts', 'fismaContactTypes', 'multiselectOptions'));
		
		if(isset($this->passedArgs['getcount']))
		{
			$this->set('count', count($adAccounts_fismaSystems));
			return $this->render('Utilities./Elements/getcount', 'ajax_nodebug');
		}
		
	}
	
	public function fisma_contact_type($fisma_contact_type_id = false) 
	{
		$this->AdAccountFismaSystem->FismaContactType->recursive = -1;
		if(!$fismaContactType = $this->AdAccountFismaSystem->FismaContactType->read(null, $fisma_contact_type_id))
		{
			throw new NotFoundException(__('Unknown %s %s', __('FISMA Contact'), __('Type')));
		}
		$this->set('fismaContactType', $fismaContactType);
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'AdAccountFismaSystem.fisma_contact_type_id' => $fisma_contact_type_id, 
		);
		
		$this->paginate['contain'] = array(
			'FismaContactType', 
			'AdAccount',
			'FismaSystem', 'FismaSystem.FismaModifiedUser',
			'FismaSystem.FismaSystemFipsRating',
			'FismaSystem.PhysicalLocation',
			'FismaSystem.OwnerContact', 'FismaSystem.OwnerContact.AdAccountDetail',
		);
		$this->paginate['order'] = array('AdAccountFismaSystem.ad_account_id');
		$this->paginate['conditions'] = $this->AdAccountFismaSystem->conditions($conditions, $this->passedArgs);
		$adAccounts_fismaSystems = $this->paginate();
		
		foreach($adAccounts_fismaSystems as $i => $adAccounts_fismaSystem)
		{
			$adAccounts_fismaSystems[$i]['FismaSystem']['FismaInventoryLastModified'] = array();
			$fismaLastInventory = $this->AdAccountFismaSystem->FismaSystem->FismaInventory->find('first', array(
				'conditions' => array('FismaInventory.fisma_system_id' => $adAccounts_fismaSystem['FismaSystem']['id']),
				'order' => array('FismaInventory.modified' => 'DESC'),
			));
			if(isset($fismaLastInventory['FismaInventory']))
				$adAccounts_fismaSystems[$i]['FismaSystem']['FismaInventoryLastModified'] = $fismaLastInventory['FismaInventory'];
			
			$adAccounts_fismaSystems[$i]['FismaSystem']['FismaSystemFileLastAdded'] = array();
			$fismaLastFileAdded = $this->AdAccountFismaSystem->FismaSystem->FismaSystemFile->find('first', array(
				'conditions' => array('FismaSystemFile.fisma_system_id' => $adAccounts_fismaSystem['FismaSystem']['id']),
				'order' => array('FismaSystemFile.created' => 'DESC'),
			));
			if(isset($fismaLastFileAdded['FismaSystemFile']))
				$adAccounts_fismaSystems[$i]['FismaSystem']['FismaSystemFileLastAdded'] = $fismaLastFileAdded['FismaSystemFile'];
			
			if(isset($adAccounts_fismaSystems[$i]['AdAccount']['id']) and $adAccounts_fismaSystems[$i]['AdAccount']['id'])
			{
				$adAccount = $this->AdAccountFismaSystem->AdAccount->find('first', array(
					'conditions' => array('AdAccount.id' => $adAccounts_fismaSystems[$i]['AdAccount']['id']),
					'contain' => array(
						'Sac', 
						'Sac.Branch', 'Sac.Branch.BranchCrm', 
						'Sac.Branch.Division', 'Sac.Branch.Division.DivisionCrm', 
						'Sac.Branch.Division.Org', 'Sac.Branch.Division.Org.OrgCrm'
					),
				));
				$adAccounts_fismaSystems[$i]['AdAccount'] = $adAccount['AdAccount'];
				$adAccounts_fismaSystems[$i]['AdAccount']['Sac'] = $adAccount['Sac'];
			}
			if(isset($adAccounts_fismaSystems[$i]['FismaSystem']['owner_contact_id']) and $adAccounts_fismaSystems[$i]['FismaSystem']['owner_contact_id'])
			{
				$adAccount = $this->AdAccountFismaSystem->AdAccount->find('first', array(
					'conditions' => array('AdAccount.id' => $adAccounts_fismaSystems[$i]['FismaSystem']['owner_contact_id']),
					'contain' => array(
						'AdAccountDetail', 
						'Sac', 
						'Sac.Branch', 'Sac.Branch.BranchCrm', 
						'Sac.Branch.Division', 'Sac.Branch.Division.DivisionCrm', 
						'Sac.Branch.Division.Org', 'Sac.Branch.Division.Org.OrgCrm'
					),
				));
				$adAccounts_fismaSystems[$i]['FismaSystem']['OwnerContact'] = $adAccount['AdAccount'];
				$adAccounts_fismaSystems[$i]['FismaSystem']['OwnerContact']['Sac'] = $adAccount['Sac'];
				$adAccounts_fismaSystems[$i]['FismaSystem']['OwnerContact']['AdAccountDetail'] = $adAccount['AdAccountDetail'];
			}
			
		}
		
		$this->set(compact('adAccounts_fismaSystems'));
		
		$adAccounts = $this->AdAccountFismaSystem->AdAccount->typeFormList();
		$this->set(compact('adAccounts'));
		
		
	}
	
	public function admin_fisma_system($id = null) 
	{
		return $this->fisma_system($id);
	}
	
	public function saa_add_ad_accounts($fisma_system_id = false) 
	{
		$this->AdAccountFismaSystem->FismaSystem->recursive = 1;
		if(!$fisma_system = $this->AdAccountFismaSystem->FismaSystem->read(null, $fisma_system_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA System')));
		}
		$this->set('fisma_system', $fisma_system);
		
		if ($this->request->is('post'))
		{
			if ($this->AdAccountFismaSystem->saveAssociatedContacts($fisma_system_id, $this->request->data['AdAccountFismaSystem']['AdAccount']))
			{
				$this->Flash->success(__('The %s have been added to the %s', __('FISMA Contacts'), __('FISMA System')));
				$this->bypassReferer = true;
				return $this->redirect(array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_id, 'saa' => false, 'tab' => 'fisma_contacts'));
			}
			else
			{
				$this->Flash->error(__('The %s could NOT be added to the %s. Please, try again.', __('FISMA Contacts'), __('FISMA System')));
			}
		}
		
		
		$adAccounts = $this->AdAccountFismaSystem->AdAccount->typeFormList();
		$this->set(compact('adAccounts'));

	}
	
	public function saa_add_systems($ad_account_id = false) 
	{
		$this->AdAccountFismaSystem->AdAccount->recursive = 1;
		if(!$ad_account = $this->AdAccountFismaSystem->AdAccount->read(null, $ad_account_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA Contact')));
		}
		$this->set('ad_account', $ad_account);
		
		if ($this->request->is('post'))
		{
			if ($this->AdAccountFismaSystem->saveAssociatedSystems($ad_account_id, $this->request->data['AdAccountFismaSystem']['FismaSystem']))
			{
				$this->Flash->success(__('The %s have been added to the %s', __('FISMA Systems'), __('FISMA Contact')));
				$this->bypassReferer = true;
				return $this->redirect(array('controller' => 'ad_accounts', 'action' => 'view', $ad_account_id, 'saa' => false, '#' => 'ui-tabs-2'));
			}
			else
			{
				$this->Flash->error(__('The %s could NOT be added to the %s. Please, try again.', __('FISMA Systems'), __('FISMA Contact')));
			}
		}
		
		
		$fismaSystems = $this->AdAccountFismaSystem->FismaSystem->find('list');
		$this->set(compact('fismaSystems'));

	}
	
	public function saa_transfer_contacts()
	{
		if ($this->request->is('post'))
		{
			if ($this->AdAccountFismaSystem->transferContacts($this->request->data['AdAccountFismaSystem']))
			{
				$this->Flash->success(__('The %s have been updated. - %s', __('FISMA Contacts'), $this->AdAccountFismaSystem->modelError));
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could NOT be updated. Please, try again.', __('FISMA Contacts')));
			}
		}
		
		$adAccounts = $this->AdAccountFismaSystem->AdAccount->typeFormList();
		$fismaContactTypes = $this->AdAccountFismaSystem->FismaContactType->typeFormList();
		$this->set(compact('adAccounts', 'fismaContactTypes'));
	}
	
	public function saa_delete($id = null) 
	{
		$this->bypassReferer = true;
		$this->AdAccountFismaSystem->id = $id;
		if (!$this->AdAccountFismaSystem->exists()) 
		{
			throw new NotFoundException(__('Invalid %s Relationship', __('FISMA Contact')));
		}
		
		if ($this->AdAccountFismaSystem->delete()) 
		{
			$this->Flash->success(__('The %s/%s relation has been removed.', __('FISMA System'), __('FISMA Contact')));
		} 
		else 
		{
			$this->Flash->error(__('The %s/%s could not be deleted. Please, try again.', __('FISMA System'), __('FISMA Contact')));
		}
		return $this->redirect($this->referer());
	}
}
