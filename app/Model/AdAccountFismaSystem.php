<?php

App::uses('AppModel', 'Model');
class AdAccountFismaSystem extends AppModel 
{
	public $useTable = 'ad_accounts_fisma_systems';
	public $validate = array(
		'ad_account_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'fisma_contact_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'fisma_system_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	public $virtualFields = array(
		'ad_account_contact_type' => 'CONCAT(AdAccountFismaSystem.ad_account_id, "-", AdAccountFismaSystem.fisma_contact_type_id)',
		'fisma_system_contact_type' => 'CONCAT(AdAccountFismaSystem.fisma_system_id, "-", AdAccountFismaSystem.fisma_contact_type_id)',
	);
	
	public $belongsTo = array(
		'AdAccount' => array(
			'className' => 'AdAccount',
			'foreignKey' => 'ad_account_id',
			'multiselect' => true,
			'nameSingle' => 'AD Account',
		),
		'FismaContactType' => array(
			'className' => 'FismaContactType',
			'foreignKey' => 'fisma_contact_type_id',
			'multiselect' => true,
			'nameSingle' => 'FISMA Contact Type',
		),
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
			'multiselect' => true,
			'nameSingle' => 'FISMA System',
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystem.name',
		'AdAccount.name',
		'AdAccount.username',
		'FismaContactType.name',
	);
	
	public $multiselectFields = array();
	
	public function saveAssociatedContacts($fisma_system_id = false, $ad_account_ids = array(), $fisma_contact_type_id = 0, $ad_account_xref_data = array())
	{
		if(!$fisma_system_id) return false;
		if(!$ad_account_ids) $ad_account_ids = array();
		
		// remove the existing records (incase they add a ad_account that is already associated with this fisma_system)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('AdAccountFismaSystem.ad_account_contact_type', 'AdAccountFismaSystem.ad_account_contact_type'),
			'conditions' => array(
				'AdAccountFismaSystem.fisma_system_id' => $fisma_system_id,
			),
		));
		
		$_ad_account_ids = $ad_account_ids;
		$ad_account_ids = array();
		foreach($_ad_account_ids as $ad_account_id)
		{
			$ad_account_ids[$ad_account_id.'-'.$fisma_contact_type_id] = $ad_account_id;
		}
		
		$_ad_account_xref_data = $ad_account_xref_data;
		$ad_account_xref_data = array();
		foreach($_ad_account_xref_data as $ad_account_id => $xrefData)
		{
			$ad_account_xref_data[$ad_account_id.'-'.$fisma_contact_type_id] = $xrefData;
		}
		
		// get just the new ones
		foreach($existing as $ad_account_contact_type)
		{
			if(isset($ad_account_ids[$ad_account_contact_type]))
				unset($ad_account_ids[$ad_account_contact_type]);
		}
		
		// build the proper save array
		$data = array();
		foreach($ad_account_ids as $ad_account => $ad_account_id)
		{
			$data[$ad_account] = array('fisma_system_id' => $fisma_system_id, 'ad_account_id' => $ad_account_id, 'active' => 1);
			
			if($fisma_contact_type_id)
				$data[$ad_account]['fisma_contact_type_id'] = $fisma_contact_type_id;
			
			if(isset($ad_account_xref_data[$ad_account]))
			{
				$data[$ad_account] = array_merge($ad_account_xref_data[$ad_account], $data[$ad_account]);
			}
		}
		
		if(!$data)
			return true;
		
		return $this->saveMany($data);
	}
	
	public function saveAssociatedSystems($ad_account_id = false, $fisma_system_ids = array(), $fisma_contact_type_id = 0, $fisma_system_xref_data = array())
	{
		if(!$ad_account_id) return false;
		if(!$fisma_system_ids) $fisma_system_ids = array();
		
		// remove the existing records (incase they add a fisma_system that is already associated with this ad_account)
		$existing = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('AdAccountFismaSystem.fisma_system_contact_type', 'AdAccountFismaSystem.fisma_system_contact_type'),
			'conditions' => array(
				'AdAccountFismaSystem.ad_account_id' => $ad_account_id,
			),
		));
		
		// get just the new ones
		$_fisma_system_ids = $fisma_system_ids;
		$fisma_system_ids = array();
		foreach($_fisma_system_ids as $fisma_system_id)
		{
			$fisma_system_ids[$fisma_system_id.'-'.$fisma_contact_type_id] = $fisma_system_id;
		}
		
		$_ad_account_xref_data = $fisma_system_xref_data;
		$fisma_system_xref_data = array();
		foreach($_ad_account_xref_data as $fisma_system_id => $xrefData)
		{
			$fisma_system_xref_data[$fisma_system_id.'-'.$fisma_contact_type_id] = $xrefData;
		}
		
		// get just the new ones
		foreach($existing as $fisma_system_contact_type)
		{
			if(isset($fisma_system_ids[$fisma_system_contact_type]))
				unset($fisma_system_ids[$fisma_system_contact_type]);
		}
		
		// build the proper save array
		$data = array();
		foreach($fisma_system_ids as $fisma_system => $fisma_system_id)
		{
			$data[$fisma_system] = array('ad_account_id' => $ad_account_id, 'fisma_system_id' => $fisma_system_id, 'active' => 1);
			
			if($fisma_contact_type_id)
				$data[$ad_account]['fisma_contact_type_id'] = $fisma_contact_type_id;
			
			if(isset($fisma_system_xref_data[$fisma_system]))
			{
				$data[$fisma_system] = array_merge($fisma_system_xref_data[$fisma_system], $data[$fisma_system]);
			}
		}
		
		if(!$data)
			return true;
		
		return $this->saveMany($data);
	}
	
	public function checkAddUpdate($fisma_system_id = false, $ad_account_id = false, $fisma_contact_type_id = false, $extra = array())
	{
		$conditions = array(
			'fisma_system_id' => $fisma_system_id,
			'ad_account_id' => $ad_account_id,
			'fisma_contact_type_id' => $fisma_contact_type_id,
		);
		
		if(!$adAccount_fismaSystem = $this->find('first', array('conditions' => $conditions)))
		{
			// not an existing one, create it
			$this->create();
			$this->data = array_merge(array('fisma_system_id' => $fisma_system_id, 'ad_account_id' => $ad_account_id, 'fisma_contact_type_id' => $fisma_contact_type_id), $extra);
			if($this->save($this->data))
			{
				return $this->id;
			}
		}
		$this->id = $adAccount_fismaSystem[$this->alias]['id'];
		
		/// see if we need to update the record
		$update = array();
		
		// check the extras
		if($extra)
		{
			foreach($extra as $ex_field => $ex_value)
			{
				if($ex_value != $adAccount_fismaSystem[$this->alias][$ex_field])
					$update[$ex_field] = $ex_value;
			}
		}
		
		if($update)
		{
			$this->data = $update;
			$this->save($this->data);
		}
		return $this->id;
	}
	
	public function findPrimaryContacts($fisma_system_id = false)
	{
		return $this->getCachedCounts('all', array(
			'contain' => array('FismaContactType', 'AdAccount', 'AdAccount.Sac', 'AdAccount.Sac.Branch', 'AdAccount.Sac.Branch.Division', 'AdAccount.Sac.Branch.Division.Org'),
			'conditions' => array(
				$this->alias.'.fisma_system_id' => $fisma_system_id,
				'FismaContactType.primary_priority > ' => 0,
			),
			'order' => array(
				'FismaContactType.primary_priority' => 'ASC',
			),
			'limit' => 10,
		));
	}
	
	public function getDaas($fismaSystem_ids = false, $type = 'all')
	{
		$out = array();
		
		$daa_id = $this->FismaContactType->getDaaId();
		
		$conditions = array(
			$this->alias.'.fisma_contact_type_id' => $daa_id,
		);
		
		if($fismaSystem_ids)
			$conditions[$this->alias.'.fisma_system_id'] = $fismaSystem_ids;
		
		if($adAccount_ids = $this->find('list', array(
			'fields' => array($this->alias.'.ad_account_id', $this->alias.'.ad_account_id'),
			'conditions' => $conditions
		)))
		{
			$out = $this->AdAccount->find($type, array(
				'conditions' => array('AdAccount.id' => $adAccount_ids)
			));
		}
		
		return $out;
	}
	
	public function getIssos($fismaSystem_ids = false, $type = 'all')
	{
		$out = array();
		
		$isso_id = $this->FismaContactType->getIssoId();
		
		$conditions = array(
			$this->alias.'.fisma_contact_type_id' => $isso_id,
		);
		
		if($fismaSystem_ids)
			$conditions[$this->alias.'.fisma_system_id'] = $fismaSystem_ids;
		
		if($adAccount_ids = $this->find('list', array(
			'fields' => array($this->alias.'.ad_account_id', $this->alias.'.ad_account_id'),
			'conditions' => $conditions
		)))
		{
			$out = $this->AdAccount->find($type, array(
				'conditions' => array('AdAccount.id' => $adAccount_ids)
			));
		}
		
		return $out;
	}
	
	public function getTechs($fismaSystem_ids = false, $type = 'all')
	{
		$out = array();
		
		$tech_id = $this->FismaContactType->getTechId();
		
		$conditions = array(
			$this->alias.'.fisma_contact_type_id' => $tech_id,
		);
		
		if($fismaSystem_ids)
			$conditions[$this->alias.'.fisma_system_id'] = $fismaSystem_ids;
		
		if($adAccount_ids = $this->find('list', array(
			'fields' => array($this->alias.'.ad_account_id', $this->alias.'.ad_account_id'),
			'conditions' => $conditions
		)))
		{
			$out = $this->AdAccount->find($type, array(
				'conditions' => array('AdAccount.id' => $adAccount_ids)
			));
		}
		
		return $out;
	}
	
	public function transferContacts($data = array())
	{
		$this->modelError = false;
		if(!isset($data['ad_account_from']))
		{
			$this->modelError = __('Unknown "from" %s', __('AD Account'));
		}
		if(!$data['ad_account_from'])
		{
			$this->modelError = __('Unknown "from" %s', __('AD Account'));
		}
		if(!isset($data['ad_account_to']))
		{
			$this->modelError = __('Unknown "to" %s', __('AD Account'));
		}
		if(!$data['ad_account_to'])
		{
			$this->modelError = __('Unknown "to" %s', __('AD Account'));
		}
		if(!isset($data['fisma_contact_type_id']))
		{
			$this->modelError = __('Unknown %s', __('Contact Type'));
		}
		if(!$data['fisma_contact_type_id'])
		{
			$this->modelError = __('Unknown %s', __('Contact Type'));
		}
		
		return $this->updateAll(
			array($this->alias.'.ad_account_id' => $data['ad_account_to']),
			array($this->alias.'.ad_account_id' => $data['ad_account_from'], $this->alias.'.fisma_contact_type_id' => $data['fisma_contact_type_id'])
		);
	}
}
