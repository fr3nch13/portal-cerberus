<?php
App::uses('AppController', 'Controller');
App::uses('UtilitiesAppController', 'Utilities.Controller');

class MainController extends AppController 
{	
	public $uses = ['FismaSystem', 'EolResult', 'PenTestResult', 'HighRiskResult', 'PoamResult'];
	
	public $cacheAction = [
	    'project_manager_dashboard' => ['callbacks' => true, 'duration' => '1 hour', 'recache' => true],
	];
	public $subscriptions = [
		'project_manager_dashboard',
		'division_director_dashboard',
	];
	
	public function isAuthorized($user = [])
	{
		$prefixes = Configure::read('Routing.prefixes');
		$prefixSettings = Configure::read('Routing.prefixSettings');
		
		if(!$userRole = AuthComponent::user('role'))
		{
			throw new NotFoundException(__('Unknown User Role (1)'));
		}
		if(!in_array($userRole, $prefixes))
		{
			throw new NotFoundException(__('Unknown User Role (2)'));
		}
		
		return true;
	}
	
	public function search($action = false)
	{	
		$this->Prg->commonProcess();
	}
	
	public function index()
	{
	/* used as the main landing page, and redirects users to their landing pages, based on their roles */
		
		// defaults
		$redirect = ['controller' => 'fisma_systems', 'action' => 'index', 'prefix' => false];
		
		$userRole = AuthComponent::user('role');
		$prefixSettings = Configure::read('Routing.prefixSettings');
		
		if(isset($prefixSettings[$userRole]['home']))
			$redirect = $prefixSettings[$userRole]['home'];
		
		if(is_array($this->passedArgs) and $this->passedArgs)
			$redirect = array_merge($redirect, $this->passedArgs);
		
		
		$this->bypassReferer = true;
		return $this->redirect($redirect);
	}
	
	public function dashboard($ad_account_id = false)
	{
	// send them to another place if it is defined
	// like for the crms, and owners for example
		$redirect = false;
		
		$userRole = AuthComponent::user('role');
		$prefixSettings = Configure::read('Routing.prefixSettings');
		
		if(isset($prefixSettings[$userRole]['dashboard']))
			$redirect = $prefixSettings[$userRole]['dashboard'];
		
		if(is_array($this->passedArgs) and $this->passedArgs)
			$redirect = array_merge($redirect, $this->passedArgs);
		
		if($redirect)
		{
			$this->bypassReferer = true;
			return $this->redirect($redirect);
		}
		
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
	}
	
	public function daa_dashboard($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
	}
	
	public function saa_dashboard($ad_account_id = false)
	{
		// find the contact type that is marked as SA&A
		$this->loadModel('FismaContactType');
		if(!$saa_id = $this->FismaContactType->defaultId(false, 'is_saa'))
		{
			throw new NotFoundException(__('No %s is marked as SA&A', __('%s %s', __('FISMA Contact'), __('Types')) ));
		}
		
		$this->bypassReferer = true;
		return $this->redirect(['controller' => 'fisma_contact_types', 'action' => 'view', $saa_id, 'saa' => false]);
	}
	
	public function isso_dashboard($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
	}
	
	public function division_director_dashboard($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		
		$adAccount = $this->FismaSystem->getDirector($ad_account_id);
		
		$directorOf = $this->FismaSystem->OwnerContact->listDirectorOf($ad_account_id, 'Division');
		
		$directors = [];
		if($this->FismaSystem->roleCheck(['admin']))
			$directors = $this->FismaSystem->getDirectors('Division');
		
		$results = [];
		$daas = [];
		$issos = [];
		$crms = [];
		if(isset($directorOf['divisions']))
		{
			foreach($directorOf['divisions'] as $crm)
				$crms[$crm['DivisionCrm']['email']] = $crm['DivisionCrm']['name'];
			if($fismaSystem_ids = $this->FismaSystem->idsForDirector($ad_account_id))
			{
				if($scopedConditions = $this->PenTestResult->conditionsforFismaSystem($fismaSystem_ids))
				{
					$scopedConditions['PenTestResult.reports_status_id'] = $this->PenTestResult->ReportsStatus->getOpenId();
					$this->PenTestResult->includeCounts = false;
					$results = $this->PenTestResult->find('all', [
						'contain' => ['EolSoftware'],
						'conditions' => $scopedConditions,
					]);
					
					foreach($results as $i => $result)
					{
						$results[$i] = $this->PenTestResult->attachFismaSystem($result);
					}
					
					// get the daas/issos
					$_daas = $this->FismaSystem->AdAccountFismaSystem->getDaas($fismaSystem_ids);
					foreach($_daas as $daa)
						$daas[$daa['AdAccount']['email']] = $daa['AdAccount']['name'];
					
					$_issos = $this->FismaSystem->AdAccountFismaSystem->getIssos($fismaSystem_ids);
					foreach($_issos as $isso)
						$issos[$isso['AdAccount']['email']] = $isso['AdAccount']['name'];
				}
			}
		}
		
		$reportsStatuses = $this->PenTestResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$page_title_prefix = __('Division Director');
		
		$this->set(compact([
			'ad_account_id', 'adAccount',
			'directorOf',
			'directors',
			'page_title_prefix',
			'reportsStatuses',
			'reportsStatus_ids',
			'results',
			'daas', 'issos', 'crms'
		]));
	}
	
	public function project_manager_dashboard()
	{
		$fismaSystem_ids = $this->FismaSystem->find('list', [
			'fields' => ['FismaSystem.id', 'FismaSystem.id'],
		]);
		
		$fismaSystems = [];
		
		$openId = $this->PenTestResult->ReportsStatus->getOpenId();
		
		foreach($fismaSystem_ids as $fismaSystem_id)
		{
			$eolResults = [];
			$penTestResults = [];
			$highRiskResults = [];
			$poamResults = [];
			
			if($scopedConditions = $this->EolResult->conditionsforFismaSystem($fismaSystem_id))
			{
				$scopedConditions['EolResult.reports_status_id'] = $openId;
				$this->EolResult->includeCounts = false;
				$eolResults = $this->EolResult->find('all', [
					'contain' => ['EolSoftware'],
					'conditions' => $scopedConditions,
				]);
			}
			
			if($scopedConditions = $this->PenTestResult->conditionsforFismaSystem($fismaSystem_id))
			{
				$scopedConditions['PenTestResult.reports_status_id'] = $openId;
				$this->PenTestResult->includeCounts = false;
				$penTestResults = $this->PenTestResult->find('all', [
					'contain' => ['EolSoftware'],
					'conditions' => $scopedConditions,
				]);
			}
			
			if($scopedConditions = $this->HighRiskResult->conditionsforFismaSystem($fismaSystem_id))
			{
				$scopedConditions['HighRiskResult.reports_status_id'] = $openId;
				$this->HighRiskResult->includeCounts = false;
				$highRiskResults = $this->HighRiskResult->find('all', [
					'contain' => ['EolSoftware'],
					'conditions' => $scopedConditions,
				]);
			}
			
			if($scopedConditions = $this->PoamResult->conditionsforFismaSystem($fismaSystem_id))
			{
				$scopedConditions['PoamCriticality.show'] = true;
				$scopedConditions['PoamRisk.show'] = true;
				$scopedConditions['PoamSeverity.show'] = true;
				$scopedConditions['PoamStatus.show'] = true;
				$this->PoamResult->includeCounts = false;
				$poamResults = $this->PoamResult->find('all', [
					'contain' => ['PoamCriticality', 'PoamRisk', 'PoamSeverity', 'PoamStatus'],
					'conditions' => $scopedConditions,
				]);
			}
			
			if(!count($eolResults) and !count($penTestResults) and !count($highRiskResults) and !count($poamResults))
			{
				unset($fismaSystem_ids[$fismaSystem_id]);
				continue;
			}
			
			// now get the full fisma system info
			$fismaSystems[$fismaSystem_id] = $this->FismaSystem->find('first', [
				'contain' => [
					'OwnerContact', 'OwnerContact.AdAccountDetail',
					'OwnerContact.Sac', 'OwnerContact.Sac.SacDirector', 'OwnerContact.Sac.SacCrm', 
					'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.BranchDirector',  'OwnerContact.Sac.Branch.BranchCrm', 
					'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.DivisionDirector', 'OwnerContact.Sac.Branch.Division.DivisionCrm', 
					'OwnerContact.Sac.Branch.Division.Org', 'OwnerContact.Sac.Branch.Division.Org.OrgDirector', 'OwnerContact.Sac.Branch.Division.Org.OrgCrm',
				],
				'order' => ['FismaSystem.name'],
				'conditions' => ['FismaSystem.id' => $fismaSystem_id],
			]);
			
			$fismaSystems[$fismaSystem_id]['EolResults'] = $eolResults;
			$fismaSystems[$fismaSystem_id]['PenTestResults'] = $penTestResults;
			$fismaSystems[$fismaSystem_id]['HighRiskResults'] = $highRiskResults;
			$fismaSystems[$fismaSystem_id]['PoamResults'] = $poamResults;
		}
		
		$owners = false;
		if($this->FismaSystem->roleCheck(['admin', 'saa']))
			$owners = $this->FismaSystem->getOwners(true);
		
		$reportsStatuses = $this->FismaSystem->FismaInventory->SubnetMember->EolResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$page_title_prefix = __('Project Manager');
		
		$this->set(compact([
			'page_title_prefix',
			'fismaSystems',
			'reportsStatuses',
			'reportsStatus_ids',
			'owners',
		]));
	}
	
	public function crm_dashboard($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$this->bypassReferer = true;
		return $this->redirect(['controller' => 'fisma_systems', 'action' => 'unresolved', $ad_account_id, 'crm' => true]);
	}
	
	public function lead_dashboard($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
	}
	
	public function owner_dashboard($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$this->bypassReferer = true;
		return $this->redirect(['controller' => 'fisma_systems', 'action' => 'unresolved', $ad_account_id, 'owner' => true]);
	}
	
	public function techpoc_dashboard($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$this->bypassReferer = true;
		return $this->redirect(['controller' => 'fisma_systems', 'action' => 'unresolved', $ad_account_id, 'techpoc' => true]);
	}
}