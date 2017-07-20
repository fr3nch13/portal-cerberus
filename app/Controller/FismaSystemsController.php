<?php
App::uses('AppController', 'Controller');

class FismaSystemsController extends AppController 
{
	public $components = array(
		'Batcher' => array(
			'className' => 'Batcher.Batcher',
			'objectName' => 'FISMA System',
			'objectsName' => 'FISMA Systems',
		),
	);
	
	public $cacheAction = array(
	    'db_block_overview' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_fips_ratings' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_pivot' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_index' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_oam' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array(), array('intab' => 1)) ),
		'db_tab_summary' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_orgchart' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_piicount' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1)) ),
		'db_tab_piicount_parent' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array(1)) ),
		'db_tab_us_results' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1)) ),
		'db_tab_eol_results' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1)) ),
		'db_tab_high_risk_results' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1)) ),
		'db_tab_pen_test_results' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('org', 1, 1), array('org', 1, 2)) ),
	);
	
	public $allowAdminDelete = true;
	
	public $subscriptions = [
		'owner_unresolved',
		'crm_unresolved',
		'techpoc_unresolved',
		'isso_db_tab_index',
	];
	
	public function menu_owners($crm_id = false)
	{
		if($this->request->is('requested') and $this->request->param('ext') != 'csv')  
		{
			$crm_owners = false;
			if($this->FismaSystem->roleCheck(array('admin', 'saa', 'crm')))
				$crm_owners = $this->FismaSystem->getCrmOwners($crm_id);
			
			// format for the menu_items
			$items = array();
			
			foreach($crm_owners as $owner_id => $owner_name)
			{
				$items[] = array(
					'title' => $owner_name,
					'url' => array('controller' => 'fisma_systems', 'action' => 'unresolved', $owner_id, $crm_id, 'admin' => false, 'saa' => false, 'owner' => true, 'crm' => false, 'plugin' => false)
				);
			}
			return $items;
		}
	}
	
	public function crm_unresolved($crm_id = false)
	{
		$crm = $this->FismaSystem->getCrm($crm_id);
		$crm_id = $crm['AdAccount']['id'];
		$this->set('crm', $crm);
		$this->set('crm_id', $crm_id);
		
		$allFismaSystems = $this->FismaSystem->find('all', array(
			'order' => array('FismaSystem.owner_contact_id'),
			'contain' => array(
				'FismaSystemFipsRating', 'FismaSystemParent', 
				'OwnerContact', 'OwnerContact.AdAccountDetail', 
				'OwnerContact.Sac', 'OwnerContact.Sac.SacDirector', 'OwnerContact.Sac.SacCrm', 
				'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.BranchDirector',  'OwnerContact.Sac.Branch.BranchCrm', 
				'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.DivisionDirector', 'OwnerContact.Sac.Branch.Division.DivisionCrm', 
				'OwnerContact.Sac.Branch.Division.Org', 'OwnerContact.Sac.Branch.Division.Org.OrgDirector', 'OwnerContact.Sac.Branch.Division.Org.OrgCrm',
			),
			'conditions' => array(
				'FismaSystem.id' => $this->FismaSystem->idsForCrm($crm_id),
			),
		));
		
		$fismaSystemOwner_ids = array();
		
		foreach($allFismaSystems as $i => $fismaSystem)
		{
			$owner_id = $fismaSystem['FismaSystem']['owner_contact_id'];
			$fismaSystemOwner_ids[$owner_id] = $owner_id;
		}
		
		$fismaSystemOwners = $this->FismaSystem->OwnerContact->find('all', array(
			'order' => array('OwnerContact.name'),
			'contain' => array(
				'AdAccountDetail', 
				'Sac', 'Sac.Branch', 'Sac.Branch.BranchDirector', 'Sac.Branch.Division', 'Sac.Branch.Division.DivisionDirector', 'Sac.Branch.Division.Org',
			),
			'conditions' => array(
				'OwnerContact.id' => $fismaSystemOwner_ids,
			)
		));
		
		foreach($fismaSystemOwners as $x => $fismaSystemOwner)
		{
			$fismaSystems = $this->FismaSystem->find('all', array(
				'order' => array('FismaSystem.name'),
				'conditions' => array(
					'FismaSystem.owner_contact_id' => $fismaSystemOwner['OwnerContact']['id'],
				),
			));
			
			foreach($fismaSystems as $i => $fismaSystem)
			{
				$fismaSystemId = $fismaSystem['FismaSystem']['id'];
			
				$fismaSystems[$i]['EolResults'] = $this->requestAction(array('controller' => 'eol_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $crm_id, 'crm' => true));
				$fismaSystems[$i]['PenTestResults'] = $this->requestAction(array('controller' => 'pen_test_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $crm_id, 'crm' => true));
				$fismaSystems[$i]['HighRiskResults'] = $this->requestAction(array('controller' => 'high_risk_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $crm_id, 'crm' => true));
			
				if(!count($fismaSystems[$i]['EolResults']) and !count($fismaSystems[$i]['PenTestResults']) and !count($fismaSystems[$i]['HighRiskResults']))
				{
					unset($fismaSystems[$i]);
				}
			}
			
			if(!count($fismaSystems))
				unset($fismaSystemOwners[$x]);
			else
				$fismaSystemOwners[$x]['FismaSystems'] = $fismaSystems;
		}
		
		$crms = false;
		if($this->FismaSystem->roleCheck(array('admin', 'saa')))
			$crms = $this->FismaSystem->getCrms();
		
		$crm_owners = false;
		if($this->FismaSystem->roleCheck(array('admin', 'saa', 'crm')))
			$crm_owners = $this->FismaSystem->getCrmOwners($crm_id);
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$page_title_prefix = __('CRM');
		
		$this->set(compact(array(
			'page_title_prefix',
			'fismaSystemOwners',
			'reportsStatuses',
			'reportsStatus_ids',
			'crms',
			'crm_owners', 'crm_id',
			'allFismaSystems'
		)));
	}
	
	public function crm_actionable($crm_id = false)
	{
		$crm = $this->FismaSystem->getCrm($crm_id);
		$crm_id = $crm['AdAccount']['id'];
		$this->set('crm', $crm);
		$this->set('crm_id', $crm_id);
		
		$conditions = array(
			'FismaSystem.id' => $this->FismaSystem->idsForCrm($crm_id),
		);
		
		$fismaSystems = $this->FismaSystem->find('all', array(
			'order' => array('FismaSystem.owner_contact_id'),
			'contain' => array(
				'OwnerContact', 'OwnerContact.AdAccountDetail', 
				'OwnerContact.Sac', 'OwnerContact.SacDirector', 
				'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.BranchDirector', 
				'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.DivisionDirector', 
				'OwnerContact.Sac.Branch.Division.Org', 'OwnerContact.Sac.Branch.Division.Org.OrgDirector',
			),
			'conditions' => $conditions,
		));
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->findforTable(true);
		
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystemId = $fismaSystem['FismaSystem']['id'];
			
			$fismaSystems[$i]['EolResults'] = $this->requestAction(array('controller' => 'eol_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $crm_id, 'crm' => true));
			$fismaSystems[$i]['PenTestResults'] = $this->requestAction(array('controller' => 'pen_test_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $crm_id, 'crm' => true));
			$fismaSystems[$i]['HighRiskResults'] = $this->requestAction(array('controller' => 'high_risk_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $crm_id, 'crm' => true));
			
			if(!count($fismaSystems[$i]['EolResults']) and !count($fismaSystems[$i]['PenTestResults']) and !count($fismaSystems[$i]['HighRiskResults']))
			{
				unset($fismaSystems[$i]);
			}
		}
		
		if($this->FismaSystem->roleCheck(array('admin', 'saa')))
			$crms = $this->FismaSystem->getCrms();
		
		$this->set(compact(array(
			'fismaSystems',
			'reportsStatuses',
			'reportsStatus_ids',
			'crms',
		)));
	}
	
	public function owner_unresolved($owner_id = false, $crm_id = false)
	{
		$owner = $this->FismaSystem->getOwner($owner_id);
		$owner_id = $owner['AdAccount']['id'];
		$this->set('owner', $owner);
		$this->set('owner_id', $owner_id);
		
		$fismaSystems = $this->FismaSystem->find('all', array(
			'contain' => array(
				'OwnerContact', 'OwnerContact.AdAccountDetail', 
				'OwnerContact.Sac', 'OwnerContact.Sac.SacDirector', 'OwnerContact.Sac.SacCrm', 
				'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.BranchDirector',  'OwnerContact.Sac.Branch.BranchCrm', 
				'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.DivisionDirector', 'OwnerContact.Sac.Branch.Division.DivisionCrm', 
				'OwnerContact.Sac.Branch.Division.Org', 'OwnerContact.Sac.Branch.Division.Org.OrgDirector', 'OwnerContact.Sac.Branch.Division.Org.OrgCrm',
			),
			'order' => array('FismaSystem.name'),
			'conditions' => array(
				'FismaSystem.owner_contact_id' => $owner_id,
			),
		));
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystemId = $fismaSystem['FismaSystem']['id'];
		
			$fismaSystems[$i]['EolResults'] = $this->requestAction(array('controller' => 'eol_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $owner_id, 'owner' => true));
			$fismaSystems[$i]['PenTestResults'] = $this->requestAction(array('controller' => 'pen_test_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $owner_id, 'owner' => true));
			$fismaSystems[$i]['HighRiskResults'] = $this->requestAction(array('controller' => 'high_risk_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $owner_id, 'owner' => true));
		
			if(!count($fismaSystems[$i]['EolResults']) and !count($fismaSystems[$i]['PenTestResults']) and !count($fismaSystems[$i]['HighRiskResults']))
			{
				unset($fismaSystems[$i]);
			}
		}
		
		$owners = false;
		if($this->FismaSystem->roleCheck(array('admin', 'saa')))
			$owners = $this->FismaSystem->getOwners(true);
			
		$crm_owners = false;
		if($this->FismaSystem->roleCheck(array('admin', 'saa', 'crm')))
			$crm_owners = $this->FismaSystem->getCrmOwners($crm_id);
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$page_title_prefix = __('Owner');
		
		$this->set(compact(array(
			'page_title_prefix',
			'fismaSystems',
			'reportsStatuses',
			'reportsStatus_ids',
			'owners',
			'crm_owners', 'crm_id',
		)));
//		$this->layout = 'Utilities.Emails/html/default';
	}
	
	public function poc_unresolved($ad_account_id = false)
	{
		$adAccount = $this->FismaSystem->AdAccountFismaSystem->AdAccount->read(null, $ad_account_id);
		
		$conditions = $this->conditions;
		
		if(!$conditions)
		{
			$fismaSystem_ids = $this->FismaSystem->idsForContactType($ad_account_id);
			$conditions['FismaSystem.id'] = $fismaSystem_ids;
		}
		
		// there are no fisma Systems for this ad account
		$fismaSystems = $fismaSystemsAll = array();
		if(isset($conditions['FismaSystem.id']) and $conditions['FismaSystem.id'])
		{
			$fismaSystems = $fismaSystemsAll = $this->FismaSystem->find('all', array(
				'contain' => array(
					'FismaSystemFipsRating', 'FismaSystemRiskAssessment', 
					'FismaSystemThreatAssessment', 'FismaSystemHosting', 'FismaSystemInterconnection', 
					'FismaSystemGssStatus', 'FismaSystemParent', 'FismaSystemNist',
					'OwnerContact', 'OwnerContact.AdAccountDetail', 
					'OwnerContact.Sac', 'OwnerContact.Sac.SacDirector', 'OwnerContact.Sac.SacCrm', 
					'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.BranchDirector',  'OwnerContact.Sac.Branch.BranchCrm', 
					'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.DivisionDirector', 'OwnerContact.Sac.Branch.Division.DivisionCrm', 
					'OwnerContact.Sac.Branch.Division.Org', 'OwnerContact.Sac.Branch.Division.Org.OrgDirector', 'OwnerContact.Sac.Branch.Division.Org.OrgCrm',
				),
				'order' => array('FismaSystem.name'),
				'conditions' => $conditions,
			));
		}
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystemId = $fismaSystem['FismaSystem']['id'];
		
			$fismaSystems[$i]['EolResults'] = $this->requestAction(array('controller' => 'eol_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $ad_account_id, 'owner' => true));
			$fismaSystems[$i]['PenTestResults'] = $this->requestAction(array('controller' => 'pen_test_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $ad_account_id, 'owner' => true));
			$fismaSystems[$i]['HighRiskResults'] = $this->requestAction(array('controller' => 'high_risk_results', 'action' => 'actionable', $fismaSystem['FismaSystem']['id'], $ad_account_id, 'owner' => true));
		
			if(!count($fismaSystems[$i]['EolResults']) and !count($fismaSystems[$i]['PenTestResults']) and !count($fismaSystems[$i]['HighRiskResults']))
			{
				unset($fismaSystems[$i]);
			}
		}
		
		$pocs = $this->get('pocs');
		if(!$pocs and $this->FismaSystem->roleCheck(array('admin', 'saa')))
			$pocs = $this->FismaSystem->getPocs();
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$page_title_prefix = ($this->get('page_title_prefix')?$this->get('page_title_prefix'):__('Point of Contact'));
		
		$this->set(compact(array(
			'page_title_prefix',
			'adAccount',
			'fismaSystems',
			'fismaSystemsAll',
			'reportsStatuses',
			'reportsStatus_ids',
			'pocs',
		)));
		
		return $this->render('/FismaSystems/poc_unresolved');
	}
	
	public function techpoc_unresolved($ad_account_id = false)
	{
		$fismaContactType_id = $this->FismaSystem->AdAccountFismaSystem->FismaContactType->getTechId();
		$fismaSystem_ids = $this->FismaSystem->idsForContactType($ad_account_id, $fismaContactType_id);
		
		$this->conditions['FismaSystem.id'] = $fismaSystem_ids;
		
		$pocs = $this->FismaSystem->getPocs($fismaContactType_id);
		$this->set('pocs', $pocs);
		
		$this->set('page_title_prefix', $this->FismaSystem->AdAccountFismaSystem->FismaContactType->getTechName());
		
		return $this->poc_unresolved($ad_account_id);
	}
	
	public function db_block_overview($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$conditions = array();
		$conditions = array_merge($conditions, $this->conditions);
		
		$fismaSystems = $this->FismaSystem->find('all', array('conditions' => $conditions));
		$this->set(compact('fismaSystems'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function director_db_block_overview($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$fismaSystem_ids = $this->FismaSystem->idsForDirector($ad_account_id);
		
		$this->conditions = array('FismaSystem.id' => $fismaSystem_ids);
		
		return $this->db_block_overview($ad_account_id);
	}
	
	public function db_block_piicount($grouped = false, $as_block = false)
	{
		$this->bypassReferer = true;
		$this->redirect(array('action' => 'db_tab_piicount', 'org', true));
	}
	
	public function db_block_fips_ratings()
	{
		$fismaSystems = $this->FismaSystem->find('all', array(
			'contain' => array('FismaSystemFipsRating'),
		));
		
		$fismaSystemFipsRatings = $this->FismaSystem->FismaSystemFipsRating->find('all'); 
		
		$this->set(compact('fismaSystems', 'fismaSystemFipsRatings'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_eol_results($by_division = false, $as_block = false)
	{
		$conditions = array();
		
		$fismaSystems = $this->FismaSystem->EolResult->dbHeatmapBySystem();
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->typeFormList();
		
		$this->set(compact(array('fismaSystems', 'reportsStatuses', 'by_division', 'as_block')));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_index($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$conditions = array();
		$conditions = array_merge($conditions, $this->conditions);
		
		$fismaSystems = $this->FismaSystem->find('all', array(
			'order' => array('FismaSystem.name'),
			'contain' => array(
				'FismaSystemFipsRating', 'FismaSystemRiskAssessment', 
				'FismaSystemThreatAssessment', 'FismaSystemHosting', 'FismaSystemInterconnection', 
				'FismaSystemGssStatus', 'FismaSystemParent', 'FismaSystemNist',
				'OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org',
			),
			'conditions' => $conditions,
		));
		$this->set(compact('fismaSystems'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function director_db_tab_index($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$fismaSystem_ids = $this->FismaSystem->idsForDirector($ad_account_id);
		
		$this->conditions = array('FismaSystem.id' => $fismaSystem_ids);
		
		return $this->db_tab_index($ad_account_id);
	}
	
	public function db_tab_pivot($grouped = false, $as_block = false)
	{
		$fismaSystems = $this->FismaSystem->find('AllParents', array(
			'order' => array('FismaSystem.name' => 'ASC'),
			'contain' => array('OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'),
		));
		
		$pivotList = array();
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystemChildren = $this->FismaSystem->find('all', array(
				'order' => array('FismaSystem.name' => 'ASC'),
				'contain' => array('OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'),
				'conditions' => array(
					'FismaSystem.parent_id' => $fismaSystem['FismaSystem']['id'],
				),
			));
			$fismaSystem['children'] = $fismaSystemChildren;
			
			// the ones that don't have an owner, so no division
			if(!isset($fismaSystem['OwnerContact']['id']) or !$fismaSystem['OwnerContact']['id'])
			{
				if(!isset($pivotList[0]))
					$pivotList[0] = array(
						'Sac' => array('id' => 0, 'name' => __('Unknown'), 'shortname' => __('N/A')),
						'Branch' => array('id' => 0, 'name' => __('Unknown'), 'shortname' => __('N/A')),
						'Division' => array('id' => 0, 'name' => __('Unknown'), 'shortname' => __('N/A')),
						'Org' => array('id' => 0, 'name' => __('Unknown'), 'shortname' => __('N/A')),
						'FismaSystems' => array(),
					);
				$pivotList[0]['FismaSystems'][$fismaSystem['FismaSystem']['id']] = $fismaSystem;
				continue;
			}
			
			$division_id = 0;
			if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['id']))
				$division_id = $fismaSystem['OwnerContact']['Sac']['Branch']['Division']['id'];
			
			if(!isset($pivotList[$division_id]))
			{
				$pivotList[$division_id] = array(
						'Sac' => array(),
						'Branch' => array(),
						'Division' => array(),
						'Org' => array(),
						'FismaSystems' => array(),
					);
			}
			$pivotList[$division_id]['FismaSystems'][$fismaSystem['FismaSystem']['id']] = $fismaSystem;
			
			if(isset($fismaSystem['OwnerContact']['Sac']['id']))
			{
				$pivotList[$division_id]['Sac'] = $fismaSystem['OwnerContact']['Sac'];
			}
			if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['id']))
			{
				$pivotList[$division_id]['Branch'] = $fismaSystem['OwnerContact']['Sac']['Branch'];
			}
			if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['id']))
			{
				$pivotList[$division_id]['Division'] = $fismaSystem['OwnerContact']['Sac']['Branch']['Division'];
			}
			if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['id']))
			{
				$pivotList[$division_id]['Org'] = $fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org'];
			}
		}
		$this->set(compact('pivotList', 'grouped', 'as_block'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_us_results($scope = 'org', $as_block = false)
	{
		$scopeName = '';
		if($scope == 'org')
		{
			$scopeName = __('ORG/IC');
		}
		elseif($scope == 'division')
		{
			$scopeName = __('Division');
		}
		elseif($scope == 'branch')
		{
			$scopeName = __('Branch');
		}
		elseif($scope == 'sac')
		{
			$scopeName = __('SAC');
		}
		elseif($scope == 'owner')
		{
			$scopeName = __('System Owner');
		}
		elseif($scope == 'system')
		{
			$scopeName = __('FISMA System');
		}
		
		$results = $this->FismaSystem->UsResult->scopedResults($scope);
		
		$reportsStatuses = $this->FismaSystem->UsResult->ReportsStatus->find('all');
		
		$this->set(compact(array(
			'as_block',
			'scope', 'scopeName', 'results',
			'reportsStatuses',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_eol_results($scope = 'org', $as_block = false)
	{
		$scopeName = '';
		if($scope == 'org')
		{
			$scopeName = __('ORG/IC');
		}
		elseif($scope == 'division')
		{
			$scopeName = __('Division');
		}
		elseif($scope == 'branch')
		{
			$scopeName = __('Branch');
		}
		elseif($scope == 'sac')
		{
			$scopeName = __('SAC');
		}
		elseif($scope == 'owner')
		{
			$scopeName = __('System Owner');
		}
		elseif($scope == 'system')
		{
			$scopeName = __('FISMA System');
		}
		
		$results = $this->FismaSystem->EolResult->scopedResults($scope);
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->find('all');
		
		$this->set(compact(array(
			'as_block',
			'scope', 'scopeName', 'results',
			'reportsStatuses',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_pen_test_results($scope = 'org', $as_block = false, $reports_severity_id = false)
	{
		$scopeName = '';
		if($scope == 'org')
		{
			$scopeName = __('ORG/IC');
		}
		elseif($scope == 'division')
		{
			$scopeName = __('Division');
		}
		elseif($scope == 'branch')
		{
			$scopeName = __('Branch');
		}
		elseif($scope == 'sac')
		{
			$scopeName = __('SAC');
		}
		elseif($scope == 'owner')
		{
			$scopeName = __('System Owner');
		}
		elseif($scope == 'system')
		{
			$scopeName = __('FISMA System');
		}
		
		$results = $this->FismaSystem->PenTestResult->scopedResults($scope);
		
		$reportsSeverity = array();
		if($reports_severity_id)
		{
			$reportsSeverity = $this->FismaSystem->PenTestResult->ReportsSeverity->read(null, $reports_severity_id);
		}
		
		$reportsSeverities = $this->FismaSystem->PenTestResult->ReportsSeverity->typeFormList();
		$reportsStatuses = $this->FismaSystem->PenTestResult->ReportsStatus->find('all');
		
		$this->set(compact(array(
			'as_block',
			'scope', 'scopeName', 'results',
			'reportsSeverities', 'reportsStatuses',
			'reports_severity_id', 'reportsSeverity',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_high_risk_results($scope = 'org', $as_block = false)
	{
		$scopeName = '';
		if($scope == 'org')
		{
			$scopeName = __('ORG/IC');
		}
		elseif($scope == 'division')
		{
			$scopeName = __('Division');
		}
		elseif($scope == 'branch')
		{
			$scopeName = __('Branch');
		}
		elseif($scope == 'sac')
		{
			$scopeName = __('SAC');
		}
		elseif($scope == 'owner')
		{
			$scopeName = __('System Owner');
		}
		elseif($scope == 'system')
		{
			$scopeName = __('FISMA System');
		}
		
		$results = $this->FismaSystem->HighRiskResult->scopedResults($scope);
		
		$reportsStatuses = $this->FismaSystem->HighRiskResult->ReportsStatus->find('all');
		
		$this->set(compact(array(
			'as_block',
			'scope', 'scopeName', 'results',
			'reportsStatuses',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_piicount($scope = 'org', $as_block = false)
	{
		$scopeName = '';
		if($scope == 'org')
		{
			$scopeName = __('ORG/IC');
		}
		elseif($scope == 'division')
		{
			$scopeName = __('Division');
		}
		elseif($scope == 'branch')
		{
			$scopeName = __('Branch');
		}
		elseif($scope == 'sac')
		{
			$scopeName = __('SAC');
		}
		elseif($scope == 'owner')
		{
			$scopeName = __('System Owner');
		}
		elseif($scope == 'system')
		{
			$scopeName = __('FISMA System');
		}
		
		$results = $this->FismaSystem->unfilteredScopedResults($scope);
		
		foreach($results as $resultId => $result)
		{
			$results[$resultId]['piiCount'] = 0;
			// get the fisma Inventory to find the related pen test results
			foreach($result['fismaSystemIds'] as $fismaSystemId => $fismaSystemCount)
			{
				if(!$piiCount = $this->FismaSystem->getPiiCount($fismaSystemId))
				{
					continue;
				}
				$results[$resultId]['piiCount'] = ($results[$resultId]['piiCount'] + $piiCount);
			}
			
			if(!$results[$resultId]['piiCount'])
			{
				unset($results[$resultId]);
			}
		}
		
		$this->set(compact(array(
			'as_block',
			'scope', 'scopeName', 'results',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_piicount_parent($as_block = false)
	{
		$fismaSystems = $this->FismaSystem->find('AllParents', array(
			'contain' => array('OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'),
			'order' => array('FismaSystem.pii_count' => 'DESC'),
		));
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystems[$i]['AdAccount'] = $fismaSystem['AdAccount'] = $fismaSystem['OwnerContact'];
			$fismaSystems[$i]['piiCount'] = $fismaSystem['FismaSystem']['pii_count'];
			
			$fismaSystemChildren = $this->FismaSystem->find('list', array(
				'conditions' => array(
					'FismaSystem.parent_id' => $fismaSystem['FismaSystem']['id'],
					'FismaSystem.pii_count > ' => 0,
				),
				'fields' => array(
					'FismaSystem.id',
					'FismaSystem.pii_count',
				),
			));
			
			foreach($fismaSystemChildren as $fismaSystemChildId => $childPiiCount)
			{
				$fismaSystems[$i]['piiCount'] = ($fismaSystems[$i]['piiCount'] + $childPiiCount);
			}
			
			if(!$fismaSystems[$i]['piiCount'])
			{
				unset($fismaSystems[$i]);
				continue;
			}
		}
		
		$this->set(compact('fismaSystems', 'as_block'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_oam()
	{
		$fismaSystems = $this->FismaSystem->find('all', array(
			'order' => array('FismaSystem.name'),
			'contain' => array(
				'FismaSystemParent',
				'OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org',
			),
		));
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->findforTable();
		
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystems[$i] = $this->FismaSystem->attachResultsToFismaSystem($fismaSystems[$i], $reportsStatus_ids);
			
			if(!$fismaSystem['FismaSystem']['pii_count'] and !count($fismaSystems[$i]['EolResults']) and !count($fismaSystems[$i]['PenTestResults']) and !count($fismaSystems[$i]['HighRiskResults']))
			{
				unset($fismaSystems[$i]);
			}
		}
		
		$this->set(compact(array(
			'fismaSystems',
			'reportsStatuses',
		)));
		
		if($this->passedArg('intab'))
			$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function isso_db_tab_index()
	{
		$fismaSystems = $this->FismaSystem->find('all', array(
			'order' => array('FismaSystem.name'),
			'contain' => array(
				'FismaSystemParent',
				'OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org',
			),
		));
		
		$openId = $this->FismaSystem->EolResult->ReportsStatus->getOpenId();
		$raId = $this->FismaSystem->EolResult->ReportsStatus->getRaId();
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->find('all', [
			'conditions' => [
				'ReportsStatus.id' => [$openId, $raId],
			]
		]);
		
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystems[$i] = $this->FismaSystem->attachResultsToFismaSystem($fismaSystems[$i], [$openId, $raId]);
			
			if(!$fismaSystem['FismaSystem']['pii_count'] and !count($fismaSystems[$i]['EolResults']) and !count($fismaSystems[$i]['PenTestResults']) and !count($fismaSystems[$i]['HighRiskResults']))
			{
				unset($fismaSystems[$i]);
			}
		}
		
		$this->set(compact(array(
			'fismaSystems',
			'reportsStatuses',
		)));
		
		if($this->passedArg('intab'))
			$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_summary()
	{
		$fismaSystems = $this->FismaSystem->find('all', array(
			'order' => array('FismaSystem.name'),
			'contain' => array(
				'FismaSystemFipsRating', 'FismaSystemRiskAssessment', 
				'FismaSystemThreatAssessment', 'FismaSystemHosting', 'FismaSystemInterconnection', 
				'FismaSystemGssStatus', 'FismaSystemParent', 'FismaSystemNist',
				'OwnerContact', 
				'OwnerContact.Sac', 
				'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.BranchCrm', 
				'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.DivisionCrm', 
				'OwnerContact.Sac.Branch.Division.Org', 'OwnerContact.Sac.Branch.Division.Org.OrgCrm',
			),
		));
		
		$reportsStatuses = $this->FismaSystem->EolResult->ReportsStatus->findforTable();
		
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$fismaContactTypes = $this->FismaSystem->AdAccountFismaSystem->FismaContactType->find('list');
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystemId = $fismaSystem['FismaSystem']['id'];
			
			$fismaSystems[$i]['FismaSystem']['FismaInventory.count'] = $this->FismaSystem->getInventoryCount($fismaSystemId);
			$fismaSystems[$i]['FismaSystem']['FismaSoftwareFismaSystem.count'] = $this->FismaSystem->getSoftwareCount($fismaSystemId);
			$fismaSystems[$i]['FismaSystem']['SrcRule.count'] = $this->FismaSystem->getSrcRuleCount($fismaSystemId);
			
			$fismaSystems[$i]['FismaSystem']['FismaSoftwareFismaSystem.count'] = $this->FismaSystem->getSoftwareCount($fismaSystemId);
			
			$fismaSystems[$i] = $this->FismaSystem->attachResultsToFismaSystem($fismaSystems[$i], $reportsStatus_ids);
		}
		
		$this->set(compact(array(
			'fismaSystems',
			'reportsStatuses',
			'fismaContactTypes'
		)));
		
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_orgchart()
	{
		$list = $this->FismaSystem->Contacts_orgChart();
		$this->set('list', $list);
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function dashboard()
	{
		$reportsSeverities = $this->FismaSystem->PenTestResult->ReportsSeverity->typeFormList();
		$this->set(compact('reportsSeverities'));
	}

	public function index() 
	{
		$this->Prg->commonProcess();
		
		// catch the dashboard users on login
		if($this->Common->dashboardUserRole() and $this->action == 'index')
		{
			return $this->redirect(array('controller' => 'main', 'action' => 'dashboard'));
		}
		
		// catch the CRMs
		if(AuthComponent::user('role') == 'crm' and $this->action == 'index')
		{
			return $this->redirect(array('controller' => 'main', 'action' => 'dashboard', 'crm' => true));
		}
		
		// catch the owners
		if(AuthComponent::user('role') == 'owner' and $this->action == 'index')
		{
			return $this->redirect(array('controller' => 'main', 'action' => 'dashboard', 'owner' => true));
		}
		
		$order = array('FismaSystem.name' => 'ASC');
		
		// for the main menu
		if ($this->request->is('requested') and $this->request->param('action') == 'index' and $this->request->param('ext') != 'csv')  
		{
			$this->FismaSystem->typeFormListOrder = array('name' => 'ASC');
			$fisma_systems = $this->FismaSystem->typeFormList();
			
			// format for the menu_items
			$items = array();
			
			foreach($fisma_systems as $fisma_system_id => $fisma_system_name)
			{
				$title = __('System: %s', ($fisma_system_name?$fisma_system_name:'[NULL]'));
				
				$items[] = array(
					'title' => $title,
					'url' => array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_id, 'admin' => false, 'saa' => false, 'plugin' => false)
				);
			}
			return $items;
		}
		
		$conditions = array();
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->paginate['contain'] = array(
			'FismaSystemFipsRating', 'FismaSystemRiskAssessment', 
			'FismaSystemThreatAssessment', 'FismaSystemHosting', 'FismaSystemInterconnection', 
			'FismaSystemGssStatus', 'FismaSystemParent', 'FismaSystemNist', 'FismaSystemNihlogin', 'FismaSystemLifeSafety',
			'FismaSystemCriticality', 'FismaSystemAffectedParty',
			'OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org',
		);
		$this->paginate['order'] = $order;
		$this->paginate['conditions'] = $this->FismaSystem->conditions($conditions, $this->passedArgs);
		
		$this->Filter->Filter(); 
		
		$fisma_systems = $this->paginate();
		
		$reportsStatuses = $this->FismaSystem->PenTestResult->ReportsStatus->findforTable();
		$fismaSystemNists = $this->FismaSystem->FismaSystemNist->typeFormList();
		$fismaSystemNihlogins = $this->FismaSystem->FismaSystemNihlogin->typeFormList();
		$fismaSystemLifeSafeties = $this->FismaSystem->FismaSystemLifeSafety->typeFormList();
		$fismaSystemCriticalities = $this->FismaSystem->FismaSystemCriticality->typeFormList();
		$fismaSystemAffectedParties = $this->FismaSystem->FismaSystemAffectedParty->typeFormList();
		
		$this->set(compact(array('fisma_systems', 'reportsStatuses', 
			'fismaSystemNists', 'fismaSystemNihlogins', 
			'fismaSystemLifeSafeties', 'fismaSystemCriticalities', 'fismaSystemAffectedParties'
		)));
		
	}
	
	public function org($org_id = null, $contact_type = 'owner')  
	{
		if (!$org_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		
		$org = $this->FismaSystem->OwnerContact->Sac->Branch->Division->Org->find('first', array(
			'conditions' => array('Org.id' => $org_id),
		));
		if (!$org) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		$this->set('object', $org);
		
		$contact_ids = $this->FismaSystem->OwnerContact->idsForOrg($org_id);
		
		$conditions = $this->FismaSystem->_buildIndexConditions($contact_ids, $contact_type);
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function division($division_id = null, $contact_type = 'owner')  
	{
		if (!$division_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		
		$division = $this->FismaSystem->OwnerContact->Sac->Branch->Division->find('first', array(
			'conditions' => array('Division.id' => $division_id),
			'contain' => array('Org'),
		));
		if (!$division) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		$this->set('object', $division);
		
		$contact_ids = $this->FismaSystem->OwnerContact->idsForDivision($division_id);
		
		$conditions = $this->FismaSystem->_buildIndexConditions($contact_ids, $contact_type);
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function branch($branch_id = null, $contact_type = 'owner')  
	{
		if (!$branch_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		
		$branch = $this->FismaSystem->OwnerContact->Sac->Branch->find('first', array(
			'conditions' => array('Branch.id' => $branch_id),
			'contain' => array('Division', 'Division.Org'),
		));
		if (!$branch) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		$this->set('object', $branch);
		
		$contact_ids = $this->FismaSystem->OwnerContact->idsForBranch($branch_id);
		
		$conditions = $this->FismaSystem->_buildIndexConditions($contact_ids, $contact_type);
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function sac($sac_id = null, $contact_type = 'owner')  
	{
		if (!$sac_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('SAC')));
		}
		
		$sac = $this->FismaSystem->OwnerContact->Sac->find('first', array(
			'conditions' => array('Sac.id' => $sac_id),
			'contain' => array('Branch', 'Branch.Division', 'Branch.Division.Org'),
		));
		if (!$sac) 
		{
			throw new NotFoundException(__('Invalid %s', __('SAC')));
		}
		$this->set('object', $sac);
		
		$contact_ids = $this->FismaSystem->OwnerContact->idsForSac($sac_id);
		
		$conditions = $this->FismaSystem->_buildIndexConditions($contact_ids, $contact_type);
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function contact($contact_id = false, $contact_type = 'owner')
	{
		if (!$contact_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Contact')));
		}
		
		$ownerContact = $this->FismaSystem->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $contact_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		$ownerContact['AdAccount'] = $ownerContact['OwnerContact'];
		if (!$ownerContact) 
		{
			throw new NotFoundException(__('Invalid %s', __('Contact')));
		}
		$this->set('object', $ownerContact);
		
		$conditions = $this->FismaSystem->_buildIndexConditions($contact_id, $contact_type);
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function crm($crm_id = false)
	{
		if (!$crm_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		
		$crm = $this->FismaSystem->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $crm_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		$crm['AdAccount'] = $crm['OwnerContact'];
		if (!$crm) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		$this->set('object', $crm);
		
		// find all of the orgs that this user is a crm of
		$fismaSystem_ids = $this->FismaSystem->idsForCrm($crm_id);
		
		$conditions = array(
			'FismaSystem.id' => $fismaSystem_ids,
		);
		
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function parents()
	{
		$this->set('page_subtitle', __('All Parents, or No Family'));
		
		$conditions = array();
		
		$this->paginate['findType'] = 'AllParents';
		$this->paginate['conditions'] = $this->FismaSystem->conditions($conditions, $this->passedArgs);
		
		$conditions = array_merge($conditions, $this->conditions);
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function all_children()
	{
		$this->set('page_subtitle', __('All Children'));
		
		$conditions = array();
		
		$this->paginate['findType'] = 'AllChildren';
		$this->paginate['conditions'] = $this->FismaSystem->conditions($conditions, $this->passedArgs);
		
		$conditions = array_merge($conditions, $this->conditions);
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function no_family()
	{
		$this->set('page_subtitle', __('No Family'));
		
		$conditions = array();
		
		$this->paginate['findType'] = 'NoFamily';
		$this->paginate['conditions'] = $this->FismaSystem->conditions($conditions, $this->passedArgs);
		
		$conditions = array_merge($conditions, $this->conditions);
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function my_children($id = false)
	{
		$this->set('page_subtitle', __('My Children'));
		
		$conditions = array();
		
		$this->FismaSystem->id = $id;
		$this->FismaSystem->recursive = 0;
		if (!$fisma_system = $this->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		
		$this->set('fisma_system', $fisma_system);
		
		$this->paginate['findType'] = 'MyChildren';
		$this->paginate['conditions'] = $this->FismaSystem->conditions($conditions, $this->passedArgs);
		
		$conditions = array_merge($conditions, $this->conditions);
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function owners()
	{
		$this->set('page_subtitle', __('With Owners'));
		
		$conditions = array(
			'FismaSystem.owner_contact_id >' => 0,
		);
		
		$conditions = array_merge($conditions, $this->conditions);
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function no_owner()
	{
		$this->set('page_subtitle', __('No Owner'));
		
		$conditions = array(
			'FismaSystem.owner_contact_id <' => 1,
		);
		
		$conditions = array_merge($conditions, $this->conditions);
		$this->conditions = $conditions;
		$this->index();
	}
	
	public function no_fisma_contact_type($fisma_contact_type_id = false)
	{
		$this->FismaSystem->AdAccountFismaSystem->FismaContactType->recursive = -1;
		if(!$fismaContactType = $this->FismaSystem->AdAccountFismaSystem->FismaContactType->read(null, $fisma_contact_type_id))
		{
			throw new NotFoundException(__('Unknown %s %s', __('FISMA Contact'), __('Type')));
		}
		$this->set('fismaContactType', $fismaContactType);
		
		$existingFismaSystems = $this->FismaSystem->AdAccountFismaSystem->find('list', array(
			'conditions' => array(
				'AdAccountFismaSystem.fisma_contact_type_id' => $fisma_contact_type_id,
			),
			'fields' => array('AdAccountFismaSystem.fisma_system_id', 'AdAccountFismaSystem.fisma_system_id'),
		));
		
		$conditions = array();
		if($existingFismaSystems)
		{
			$conditions['FismaSystem.id NOT IN'] = $existingFismaSystems;
		}
		
		$conditions = array_merge($conditions, $this->conditions);
		$this->conditions = $conditions;
		$this->index();
	}

	public function view($id = false)
	{
		$this->FismaSystem->id = $id;
		$this->FismaSystem->recursive = 0;
		$this->FismaSystem->contain(array_merge(
			array_keys($this->FismaSystem->belongsTo), 
			array(
				'OwnerContact', 
				'OwnerContact.Sac', 
				'OwnerContact.Sac.SacDirector',
				'OwnerContact.Sac.SacCrm',
				'OwnerContact.Sac.Branch.BranchDirector', 
				'OwnerContact.Sac.Branch.BranchCrm', 
				'OwnerContact.Sac.Branch.Division.DivisionDirector', 
				'OwnerContact.Sac.Branch.Division.DivisionCrm', 
				'OwnerContact.Sac.Branch.Division.Org.OrgDirector',
				'OwnerContact.Sac.Branch.Division.Org.OrgCrm',
			)
		));
		if (!$fisma_system = $this->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		
		$reportsStatuses = $this->FismaSystem->PenTestResult->ReportsStatus->find('all');
		
		$this->set('fisma_system', $fisma_system);
		$this->set(compact(array('fisma_system', 'reportsStatuses')));
	}

	public function tip($id = false)
	{
		if (!$this->request->is('ajax')) 
		{
			throw new NotFoundException(__('Invalid %s (%s)', __('FISMA System'), '1'));
		}
		
		$this->FismaSystem->id = $id;
		$this->FismaSystem->recursive = 0;
		if (!$fisma_system = $this->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		
		$this->layout = 'ajax_nodebug';
	}
	
	public function edit_notes($id = null, $field = null) 
	{
		$this->FismaSystem->id = $id;
		
		if (!$fisma_system = $this->FismaSystem->find('first', array(
			'conditions' => array('FismaSystem.id' => $id),
		))) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		if(!isset($fisma_system['FismaSystem'][$field]))
		{
			throw new NotFoundException(__('Invalid %s Notes.', __('FISMA System')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystem->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('FISMA System')));
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'view', $this->FismaSystem->id, 'saa' => false, 'admin' => false, 'tab' => $field));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('FISMA System')));
			}
		}
		else
		{
			$this->request->data = $fisma_system;
		}
		$this->set('field', $field);
	}
	
	public function saa_add() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystem->create();
			
			if ($this->FismaSystem->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('FISMA System')));
				return $this->redirect(array('action' => 'view', $this->FismaSystem->id, 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('FISMA System')));
			}
		}
		
		$fismaSoftwares = $this->FismaSystem->FismaSoftware->listByGroup();
		$physicalLocations = $this->FismaSystem->PhysicalLocation->typeFormList();
		$this->set(compact(array(
			'fismaSoftwares', 'physicalLocations'
		)));
		
		$fismaSystemInterconnections = $this->FismaSystem->FismaSystemInterconnection->typeFormList();
		$fismaSystemGssStatuses = $this->FismaSystem->FismaSystemGssStatus->typeFormList();
		$fismaSystemHostings = $this->FismaSystem->FismaSystemHosting->typeFormList();
		$this->set(compact(array(
			'fismaSystemInterconnections', 'fismaSystemGssStatuses', 'fismaSystemHostings'
		)));
		
		$fismaSystemFipsRatings = $this->FismaSystem->FismaSystemFipsRating->typeFormList();
		$fismaSystemRiskAssessments = $this->FismaSystem->FismaSystemRiskAssessment->typeFormList();
		$fismaSystemThreatAssessments = $this->FismaSystem->FismaSystemThreatAssessment->typeFormList();
		$fismaSystemAmounts = $this->FismaSystem->FismaSystemAmount->typeFormList();
		$fismaSystemComTotals = $this->FismaSystem->FismaSystemComTotal->typeFormList();
		$fismaSystemDependencies = $this->FismaSystem->FismaSystemDependency->typeFormList();
		$fismaSystemImpacts = $this->FismaSystem->FismaSystemImpact->typeFormList();
		$fismaSystemUniquenesses = $this->FismaSystem->FismaSystemUniqueness->typeFormList();
		$fismaSystemSensitivityCategories = $this->FismaSystem->FismaSystemSensitivityCategory->typeFormList();
		$fismaSystemSensitivityRatings = $this->FismaSystem->FismaSystemSensitivityRating->typeFormList();
		$fismaSystemNists = $this->FismaSystem->FismaSystemNist->typeFormList();
		$fismaSystemNihlogins = $this->FismaSystem->FismaSystemNihlogin->typeFormList();
		$fismaSystemLifeSafeties = $this->FismaSystem->FismaSystemLifeSafety->typeFormList();
		$fismaSystemCriticalities = $this->FismaSystem->FismaSystemCriticality->typeFormList();
		$fismaSystemAffectedParties = $this->FismaSystem->FismaSystemAffectedParty->typeFormList();
		$ownerContacts = $this->FismaSystem->OwnerContact->typeFormList();
		
		$fismaSystemParents = $this->FismaSystem->find('AllParents', array(
			'order' => array('FismaSystem.name' => 'ASC'),
			'type' => 'list',
		));

		$this->set(compact(array(
			'fismaSystemFipsRatings', 'fismaSystemRiskAssessments', 'fismaSystemThreatAssessments',
			'fismaSystemAmounts', 'fismaSystemComTotals', 'fismaSystemDependencies', 'fismaSystemImpacts',
			'fismaSystemUniquenesses', 'fismaSystemSensitivityCategories', 'fismaSystemSensitivityRatings', 
			'fismaSystemNists', 'fismaSystemNihlogins', 'fismaSystemLifeSafeties', 'ownerContacts',
			'fismaSystemParents',
			'fismaSystemCriticalities', 'fismaSystemAffectedParties'
		)));
	}
	
	public function saa_edit($id = null) 
	{
		$this->FismaSystem->id = $id;
		
		$this->FismaSystem->recursive = 1;
		$this->FismaSystem->contain = array('FismaSoftware');
		if (!$fisma_system = $this->FismaSystem->find('first', array(
			'recursive' => 1,
			'contain' => array('FismaSoftware'),
			'conditions' => array('FismaSystem.id' => $id),
		)))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->FismaSystem->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('FISMA System')));
				return $this->redirect(array('action' => 'view', $this->FismaSystem->id, 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('FISMA System')));
			}
		}
		else
		{
			$this->request->data = $fisma_system;
		}
		
		$fismaSoftwares = $this->FismaSystem->FismaSoftware->listByGroup();
		$physicalLocations = $this->FismaSystem->PhysicalLocation->typeFormList();
		$this->set(compact(array(
			'fismaSoftwares', 'physicalLocations'
		)));
		
		$fismaSystemInterconnections = $this->FismaSystem->FismaSystemInterconnection->typeFormList();
		$fismaSystemGssStatuses = $this->FismaSystem->FismaSystemGssStatus->typeFormList();
		$fismaSystemHostings = $this->FismaSystem->FismaSystemHosting->typeFormList();
		$this->set(compact(array(
			'fismaSystemInterconnections', 'fismaSystemGssStatuses', 'fismaSystemHostings'
		)));
		
		$fismaSystemFipsRatings = $this->FismaSystem->FismaSystemFipsRating->typeFormList();
		$fismaSystemRiskAssessments = $this->FismaSystem->FismaSystemRiskAssessment->typeFormList();
		$fismaSystemThreatAssessments = $this->FismaSystem->FismaSystemThreatAssessment->typeFormList();
		$fismaSystemAmounts = $this->FismaSystem->FismaSystemAmount->typeFormList();
		$fismaSystemComTotals = $this->FismaSystem->FismaSystemComTotal->typeFormList();
		$fismaSystemDependencies = $this->FismaSystem->FismaSystemDependency->typeFormList();
		$fismaSystemImpacts = $this->FismaSystem->FismaSystemImpact->typeFormList();
		$fismaSystemUniquenesses = $this->FismaSystem->FismaSystemUniqueness->typeFormList();
		$fismaSystemSensitivityCategories = $this->FismaSystem->FismaSystemSensitivityCategory->typeFormList();
		$fismaSystemSensitivityRatings = $this->FismaSystem->FismaSystemSensitivityRating->typeFormList();
		$fismaSystemNists = $this->FismaSystem->FismaSystemNist->typeFormList();
		$fismaSystemNihlogins = $this->FismaSystem->FismaSystemNihlogin->typeFormList();
		$ownerContacts = $this->FismaSystem->OwnerContact->typeFormList();
		$fismaSystemLifeSafeties = $this->FismaSystem->FismaSystemLifeSafety->typeFormList();
		$fismaSystemCriticalities = $this->FismaSystem->FismaSystemCriticality->typeFormList();
		$fismaSystemAffectedParties = $this->FismaSystem->FismaSystemAffectedParty->typeFormList();
		$fismaSystemChildrenCount = $this->FismaSystem->find('MyChildren', array(
			'type' => 'count',
		));
		
		$fismaSystemParents = array();
		if(!$fismaSystemChildrenCount)
		{
			$fismaSystemParents = $this->FismaSystem->find('AllParents', array(
				'conditions' => array(
					'FismaSystem.id !=' => $id, 
				),
				'order' => array('FismaSystem.name' => 'ASC'),
				'type' => 'list',
			));
		}

		$this->set(compact(array(
			'fismaSystemFipsRatings', 'fismaSystemRiskAssessments', 'fismaSystemThreatAssessments',
			'fismaSystemAmounts', 'fismaSystemComTotals', 'fismaSystemDependencies', 'fismaSystemImpacts',
			'fismaSystemUniquenesses', 'fismaSystemSensitivityCategories', 'fismaSystemSensitivityRatings', 
			'fismaSystemNists', 'fismaSystemNihlogins', 'fismaSystemLifeSafeties', 'ownerContacts',
			'fismaSystemChildrenCount', 'fismaSystemParents',
			'fismaSystemCriticalities', 'fismaSystemAffectedParties'
		)));	
	}
	
	public function saa_batcher_step1() 
	{
		$this->Batcher->batcher_step1();
	}
	
	public function saa_batcher_step2() 
	{
		$this->Batcher->batcher_step2();
	}
	
	public function saa_batcher_step3() 
	{
		$this->Batcher->batcher_step3();
	}
	
	public function saa_batcher_step4() 
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'index', 'saa' => false));
	}
	
	public function admin_index() 
	{
		return $this->index();
	}

	public function admin_view($id = false)
	{
		return $this->view($id);
	}
	
	public function admin_import_updater() 
	{
		if ($this->request->is('post'))
		{
			$this->FismaSystem->create();
			
			if ( $counts = $this->FismaSystem->importUpdateSystems($this->request->data))
			{
				$this->Flash->success(__('The %s has been imported/updated. Added: %s, Updated: %s', __('FISMA Systems'), $counts['added'], $counts['updated']));
//				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Flash->error(__('The %s could not be imported/updated. Reason: %s', __('FISMA System'), $this->FismaSystem->modelError));
			}
		}
	}
	
	// the APIs
	public function api_cmindex()
	{
		$_fismaSystems = $this->FismaSystem->find('all', array(
			'recursive' => -1, 
			'contain' => array('OwnerContact'),
			'order' => array('FismaSystem.id' => 'ASC'),
		));
		
		$fismaSystems = array();
		foreach($_fismaSystems as $i => $fismaSystem)
		{
			$id = $fismaSystem['FismaSystem']['id'];
			$fismaSystems[$id] = array(
				'id' => $id,
				'name' => $fismaSystem['FismaSystem']['name'],
				'fullname' => $fismaSystem['FismaSystem']['fullname'],
				'owner_adaccount' => (isset($fismaSystem['OwnerContact']['username'])?$fismaSystem['OwnerContact']['username']:false),
				'owner_name' => (isset($fismaSystem['OwnerContact']['name'])?$fismaSystem['OwnerContact']['name']:false),
			);
		}
		
		$this->set(array(
			'fismaSystems' => $fismaSystems,
			'_serialize' => array('fismaSystems')
		));
	}
}
