<?php
App::uses('AppController', 'Controller');

class FovResultsController extends AppController 
{
	
	public $helpers = [
		'ReportResults',
	];
	
	public $cacheAction = [
	    'db_block_overview' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		'db_block_assignable_party_trend' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		'db_block_remediation_trend' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		'db_block_severity_trend' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		'db_block_status_trend' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		'db_block_verification_trend' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		
	    'db_tab_index' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		'db_tab_status_change' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		'db_tab_gssparent' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
		
		'db_tab_totals' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1], ['system', 2]] ],
		'db_tab_assignable_party' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1]] ],
		'db_tab_remediation' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1]] ],
		'db_tab_severity' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1]] ],
		'db_tab_status' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1]] ],
		'db_tab_verification' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1]] ],
//		'db_tab_system_type' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1]] ],
//		'db_tab_fisma_system' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => [['org', 1], ['division', 1]] ],
		
	//	'db_tab_breakout' => ['callbacks' => true, 'duration' => '1 day', 'recache' => true],
	];

	public function menu_assignable_parties() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = [];
		$this->FovResult->ReportsAssignableParty->typeFormListOrder = ['name' => 'ASC'];
		$reportsAssignableParties = $this->FovResult->ReportsAssignableParty->typeFormList();
		
		foreach($reportsAssignableParties as $reportsAssignableParty_id => $reportsAssignableParty_name)
		{
			$title = $reportsAssignableParty_name;
			
			$items[] = [
				'title' => $title,
				'url' => ['controller' => 'fov_results', 'action' => 'index', 'field' => 'reports_assignable_party_id', 'value' => $reportsAssignableParty_id, 'admin' => false, 'saa' => false, 'plugin' => false]
			];
		}
		return $items;
	}
	
	public function menu_remediations() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = [];
		$this->FovResult->ReportsRemediation->typeFormListOrder = ['name' => 'ASC'];
		$reportsRemediations = $this->FovResult->ReportsRemediation->typeFormList();
		
		foreach($reportsRemediations as $reportsRemediation_id => $reportsRemediation_name)
		{
			$title = $reportsRemediation_name;
			
			$items[] = [
				'title' => $title,
				'url' => ['controller' => 'fov_results', 'action' => 'index', 'field' => 'reports_remediation_id', 'value' => $reportsRemediation_id, 'admin' => false, 'saa' => false, 'plugin' => false]
			];
		}
		return $items;
	}
	
	public function menu_severities() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = [];
		$this->FovResult->ReportsStatus->typeFormListOrder = ['name' => 'ASC'];
		$reportsSeverities = $this->FovResult->ReportsSeverity->typeFormList();
		
		foreach($reportsSeverities as $reportsSeverity_id => $reportsSeverity_name)
		{
			$title = $reportsSeverity_name;
			
			$items[] = [
				'title' => $title,
				'url' => ['controller' => 'fov_results', 'action' => 'index', 'field' => 'reports_severity_id', 'value' => $reportsSeverity_id, 'admin' => false, 'saa' => false, 'plugin' => false]
			];
		}
		return $items;
	}
	
	public function menu_statuses() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = [];
		$this->FovResult->ReportsStatus->typeFormListOrder = ['name' => 'ASC'];
		$reportsStatuses = $this->FovResult->ReportsStatus->typeFormList();
		
		foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
		{
			$title = $reportsStatus_name;
			
			$items[] = [
				'title' => $title,
				'url' => ['controller' => 'fov_results', 'action' => 'index', 'field' => 'reports_status_id', 'value' => $reportsStatus_id, 'admin' => false, 'saa' => false, 'plugin' => false]
			];
		}
		return $items;
	}
	
	public function menu_verifications() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = [];
		$this->FovResult->ReportsVerification->typeFormListOrder = ['name' => 'ASC'];
		$reportsVerifications = $this->FovResult->ReportsVerification->typeFormList();
		
		foreach($reportsVerifications as $reportsVerification_id => $reportsVerification_name)
		{
			$title = $reportsVerification_name;
			
			$items[] = [
				'title' => $title,
				'url' => ['controller' => 'fov_results', 'action' => 'index', 'field' => 'reports_verification_id', 'value' => $reportsVerification_id, 'admin' => false, 'saa' => false, 'plugin' => false]
			];
		}
		return $items;
	}
	
	public function crm_actionable($fisma_system_id = false, $crm_id = false)
	{
		$crm = $this->FovResult->FismaSystem->getCrm($crm_id);
		$crm_id = $crm['AdAccount']['id'];
		$this->set('crm', $crm);
		$this->set('crm_id', $crm_id);
		
		$conditions = [];
		
		$reportsStatuses = $this->FovResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$conditions['FovResult.reports_status_id'] = $reportsStatus_ids;
		
		if($fisma_system_id)
		{
			if (!$fismaSystem = $this->FovResult->FismaSystem->read(null, $fisma_system_id))
			{
				throw new NotFoundException(__('Invalid %s', __('FISMA System')));
			}
			$this->set('fismaSystem', $fismaSystem);
			
			if(!$scopedConditions = $this->FovResult->conditionsforFismaSystem($fisma_system_id))
			{
				$this->paginate['empty'] = true;
			}
			
			$conditions = array_merge($conditions, $scopedConditions);
		}
		
		$this->paginate['conditions'] = $this->FovResult->conditions($conditions, $this->passedArgs); 
		
		$this->FovResult->recursive = 0;
		$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->FovResult->find('count', ['conditions' => $this->paginate['conditions']]);
		
		if($this->paginate['limit'])
			$fovResults = $this->paginate();
		else
			$fovResults = [];
		return $fovResults;
	}
	
	public function owner_actionable($fisma_system_id = false, $owner_id = false)
	{
		$owner = $this->FovResult->FismaSystem->getOwner($owner_id);
		$owner_id = $owner['AdAccount']['id'];
		$this->set('owner', $owner);
		$this->set('owner_id', $owner_id);
		
		$conditions = [];
		
		$reportsStatuses = $this->FovResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$conditions['FovResult.reports_status_id'] = $reportsStatus_ids;
		
		if($fisma_system_id)
		{
			if (!$fismaSystem = $this->FovResult->FismaSystem->read(null, $fisma_system_id))
			{
				throw new NotFoundException(__('Invalid %s', __('FISMA System')));
			}
			$this->set('fismaSystem', $fismaSystem);
			
			if(!$scopedConditions = $this->FovResult->conditionsforFismaSystem($fisma_system_id))
			{
				$this->paginate['empty'] = true;
			}
			
			$conditions = array_merge($conditions, $scopedConditions);
		}
		
		$this->paginate['conditions'] = $this->FovResult->conditions($conditions, $this->passedArgs); 
		
		$this->FovResult->recursive = 0;
		$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->FovResult->find('count', ['conditions' => $this->paginate['conditions']]);
		
		if($this->paginate['limit'])
			$fovResults = $this->paginate();
		else
			$fovResults = [];
		return $fovResults;
	}
	
	public function director_db_block_overview($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$fovResults = $this->FovResult->listforDirector($ad_account_id, 'all', ['recursive' => 0]);
		
		$fovResults = $this->FovResult->dbOverviewUpdate($fovResults);
		
		$reportsStatuses = $this->FovResult->ReportsStatus->typeFormList();
		$this->set(compact('fovResults', 'reportsStatuses'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function director_db_tab_index($ad_account_id = false, $stripped = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		if(!$this->conditions = $this->FovResult->listforDirector($ad_account_id, 'conditions'))
		{
			$this->paginate['empty'] = true;
		}
		
		return $this->db_tab_index($stripped);
	}
	
	public function db_block_overview()
	{
		$this->FovResult->includeHosts = true;
		$fovResults = $this->FovResult->find('all', ['contain' => ['ReportsStatus']]);
		foreach($fovResults as $i => $fovResult)
		{
			$fovResults[$i] = $this->FovResult->attachFismaSystem($fovResult);
		}
		$reportsStatuses = $this->FovResult->ReportsStatus->typeFormList();
		
		$this->set(compact('fovResults', 'reportsStatuses'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_assignable_party_trend()
	{
		$snapshotStats = $this->FovResult->snapshotDashboardGetStats('/^eol_result\.reports_assignable_party\-\d+$/');
		$reportsAssignableParties = $this->FovResult->ReportsAssignableParty->find('list', [
			'fields' => ['ReportsAssignableParty.id', 'ReportsAssignableParty.color_code_hex'],
		]);
		
		$this->set(compact('snapshotStats', 'reportsAssignableParties'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_remediation_trend()
	{
		$snapshotStats = $this->FovResult->snapshotDashboardGetStats('/^eol_result\.reports_remediation\-\d+$/');
		$reportsRemediations = $this->FovResult->ReportsRemediation->find('list', [
			'fields' => ['ReportsRemediation.id', 'ReportsRemediation.color_code_hex'],
		]);
		
		$this->set(compact('snapshotStats', 'reportsRemediations'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_severity_trend()
	{
		$snapshotStats = $this->FovResult->snapshotDashboardGetStats('/^eol_result\.reports_severity\-\d+$/');
		$reportsSeverities = $this->FovResult->ReportsSeverity->find('list', [
			'fields' => ['ReportsSeverity.id', 'ReportsSeverity.color_code_hex'],
		]);
		
		$this->set(compact('snapshotStats', 'reportsSeverities'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_status_trend()
	{
		$snapshotStats = $this->FovResult->snapshotDashboardGetStats('/^eol_result\.reports_status\-\d+$/');
		$reportsStatuses = $this->FovResult->ReportsStatus->find('list', [
			'fields' => ['ReportsStatus.id', 'ReportsStatus.color_code_hex'],
		]);
		
		$this->set(compact('snapshotStats', 'reportsStatuses'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_verification_trend()
	{
		$snapshotStats = $this->FovResult->snapshotDashboardGetStats('/^eol_result\.reports_verification\-\d+$/');
		$reportsVerifications = $this->FovResult->ReportsVerification->find('list', [
			'fields' => ['ReportsVerification.id', 'ReportsVerification.color_code_hex'],
		]);
		
		$this->set(compact('snapshotStats', 'reportsVerifications'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_index($stripped = false)
	{
		$this->Prg->commonProcess();
		
		$conditions = [];
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['FovResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->paginate['conditions'] = $this->FovResult->conditions($conditions, $this->passedArgs); 
		
		$this->FovResult->recursive = 0;
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'FovResult';
		
		$fovResults = $this->paginate($this->paginateModel);
		
		foreach($fovResults as $i => $fovResult)
		{
			$fovResults[$i] = $this->FovResult->attachFismaSystem($fovResult);
		}
		
		$this->set('fovResults', $fovResults);
		$this->set('stripped', $stripped);
		$this->layout = 'Utilities.ajax_nodebug';
		return $this->render();
	}
	
	public function db_tab_status_change($timeAgo = false)
	{
		if(!$timeAgo)
			$timeAgo = '-10 minutes';
		$timeAgo = date('Y-m-d H:i:s', strtotime($timeAgo));
		$conditions = ['FovResult.status_date > ' => $timeAgo];
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->paginate['order'] = ['FovResult.status_date' => 'ASC'];
		$this->set('stripped', true);
		return $this->db_tab_index(true);
	}
	
	public function db_tab_gssparent()
	{
		$fismaSystems = $this->FovResult->FismaSystem->find('AllParents', [
			'order' => ['FismaSystem.name' => 'ASC'],
		]);
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			// get the children
			$this->FovResult->FismaSystem->id = $fismaSystem['FismaSystem']['id'];
			$fismaSystemChildren = $this->FovResult->FismaSystem->find('MyChildren');
			
			$fismaSystemIds = [$fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']];
			
			// get the children related vectors
			foreach($fismaSystemChildren as $j => $fismaSystemChild)
			{
				$fismaSystemIds[$fismaSystemChild['FismaSystem']['id']] = $fismaSystemChild['FismaSystem']['id'];
			}
			
			$conditionsFovResult = $this->FovResult->conditionsforFismaSystem($fismaSystemIds);
			
			if(!isset($conditionsFovResult['OR']))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
				'recursive' => 0,
				'conditions' => $conditionsFovResult,
				'fields' => ['FovResult.id', 'FovResult.id']
			]);
				
			$this->FovResult->includeHosts = true;
			$fovResults = $this->FovResult->find('all', [
				'conditions' => [
					'OR' => [
						'FovResult.id' => $xrefResults,
						'FovResult.fisma_system_id' => $fismaSystemIds,
					],
				],
			]);
			
			if(!$fovResults)
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			$fismaSystems[$i]['FovResults'] = $fovResults;
		}
		
		$this->set(compact([
			'fismaSystems',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_totals($scope = 'org', $as_block = false)
	{
		$conditions = [];
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['FovResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		
		$results = $this->scopedResults($scope, $conditions);
		$reportsStatuses = $this->FovResult->ReportsStatus->find('all');
		
		$this->set(compact([
			'as_block', 'results',
			'reportsStatuses',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_assignable_party($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsAssignableParties = $this->FovResult->ReportsAssignableParty->typeFormList();
		
		$this->set(compact([
			'as_block', 'results',
			'reportsAssignableParties',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_remediation($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsRemediations = $this->FovResult->ReportsRemediation->typeFormList();
		
		$this->set(compact([
			'as_block', 'results',
			'reportsRemediations',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_severity($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsSeverities = $this->FovResult->ReportsSeverity->findforTable();
		
		$this->set(compact([
			'as_block', 'results',
			'reportsSeverities',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_status($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsStatuses = $this->FovResult->ReportsStatus->findforTable();
		
		$this->set(compact([
			'as_block', 'results',
			'reportsStatuses',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_verification($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsVerifications = $this->FovResult->ReportsVerification->typeFormList();
		
		$this->set(compact([
			'results',
			'as_block', 'reportsVerifications',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_breakout($scope = 'division', $as_block = false)
	{
		$reportsStatusOpenId = $this->FovResult->ReportsStatus->getOpenId();
		
		$reportsStatusName = __('All');
		$reportsStatusId = 0;
		if(isset($this->passedArgs['reports_status_id']))
		{
			if($this->passedArgs['reports_status_id'])
			{
				$conditions['FovResult.reports_status_id']  = $this->passedArgs['reports_status_id'];
				$reportsStatusName = __('Status: %s', $this->FovResult->ReportsStatus->field('name', ['ReportsStatus.id' => $this->passedArgs['reports_status_id']]));
				$reportsStatusId = $this->passedArgs['reports_status_id'];
			}
		}
		else
		{
			$this->passedArgs['reports_status_id'] = $reportsStatusOpenId;
			$conditions['FovResult.reports_status_id'] = $reportsStatusOpenId;
			$reportsStatusName = __('Status: %s', __('Open'));
			$reportsStatusId = $reportsStatusOpenId;
		}
		
		$results = $this->scopedResults($scope, $conditions);
		$reportsStatuses = $this->FovResult->ReportsStatus->typeFormList();
		$this->set(compact([
			'as_block', 'results', 'scope', 
			'reportsStatusOpenId', 'reportsStatusId', 'reportsStatusName', 'reportsStatuses',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_crossovers($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		// try to figure out how they're crossing over
		$seenResults = [];
		foreach($results as $resultId => $result)
		{
			foreach($result['FovResults'] as $myResult_id => $myResult)
			{
				if(isset($myResult['FovResult']['fismaSystem_id']) and $myResult['FovResult']['fismaSystem_id'])
					continue;
				if(!isset($seenResults[$myResult_id]))
					$seenResults[$myResult_id] = [];
				$seenResults[$myResult_id][$resultId] = $result;
			}
		}
		
		foreach($seenResults as $seenResult_id => $relatedScopeResults)
		{
			if(count($relatedScopeResults) < 2)
			{
				unset($seenResults[$seenResult_id]);
			}
		}
		
		$results = $this->FovResult->find('all', [
			'conditions' => [
				'FovResult.fisma_system_id' => 0,
				'FovResult.id' => array_keys($seenResults),
			],
		]);
		
		foreach($results as $i => $result)
		{
			$result_id = $result['FovResult']['id'];
			$results[$i]['crossovers'] = $seenResults[$result_id];
		}
		
		$this->set(compact([
			'as_block', 'results',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function search_results()
	{
		return $this->index();
	}
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = [];
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['FovResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		$conditions = array_merge($conditions, $this->conditions);
		
		if(isset($conditions['OR']) and !$conditions['OR'] and !in_array($this->action, ['index', 'admin_index']))
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = (isset($this->viewVars['page_subtitle'])?$this->viewVars['page_subtitle']:__('All'));
		$page_description = (isset($this->viewVars['page_description'])?$this->viewVars['page_description']:'');
		
		$this->_setAttributes();
		
		if(isset($this->passedArgs['field']) and isset($this->passedArgs['value'])) 
		{
			$field = $this->passedArgs['field'];
			if(strpos($field, '.') === false)
				$field = 'FovResult.'. $field;
			$conditions[$field] = $this->passedArgs['value'];
			
			if($this->passedArgs['field'] == 'reports_assignable_party_id' and $this->get('reportsAssignableParties', $this->passedArgs['value']))
			{
				$reportsAssignableParty = $this->FovResult->ReportsAssignableParty->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Assignable Party'), $reportsAssignableParty['ReportsAssignableParty']['name']);
				$page_description = $reportsAssignableParty['ReportsAssignableParty']['details'];
			}
			
			if($this->passedArgs['field'] == 'reports_remediation_id' and $this->get('reportsRemediations', $this->passedArgs['value']) )
			{
				$reportsRemediation = $this->FovResult->ReportsRemediation->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Remediation'), $reportsRemediation['ReportsRemediation']['name']);
				$page_description = $reportsRemediation['ReportsRemediation']['details'];
			}
			
			if($this->passedArgs['field'] == 'reports_status_id' and $this->get('reportsStatuses', $this->passedArgs['value']))
			{
				$reportsStatus = $this->FovResult->ReportsStatus->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Status'), $reportsStatus['ReportsStatus']['name']);
				$page_description = $reportsStatus['ReportsStatus']['details'];
			}
			
			if($this->passedArgs['field'] == 'reports_severity_id' and $this->get('reportsSeverities', $this->passedArgs['value']))
			{
				$reportsSeverity = $this->FovResult->ReportsSeverity->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Status'), $reportsSeverity['ReportsSeverity']['name']);
				$page_description = $reportsSeverity['ReportsSeverity']['details'];
			}
			
			if($this->passedArgs['field'] == 'reports_verification_id' and $this->get('reportsVerifications', $this->passedArgs['value']))
			{
				$reportsVerification = $this->FovResult->ReportsVerification->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Verification'), $reportsVerification['ReportsVerification']['name']);
				$page_description = $reportsVerification['ReportsVerification']['details'];
			}
		}
		
		$this->paginate['conditions'] = $this->FovResult->conditions($conditions, $this->passedArgs);
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->FovResult->getCachedCounts('count', ['conditions' => $this->paginate['conditions']]);
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'FovResult';
		
		if(!isset($this->paginate['contain']) or !$this->paginate['contain'])
			$this->paginate['contain'] = [
				'EolSoftware', 
				'ReportsAssignableParty', 'ReportsOrganization', 'ReportsRemediation', 'ReportsStatus', 'ReportsVerification',
				'FismaSystem', 'FismaSystem.OwnerContact', 'FismaSystem.OwnerContact.Sac', 'FismaSystem.OwnerContact.Sac.Branch', 'FismaSystem.OwnerContact.Sac.Branch.Division', 'FismaSystem.OwnerContact.Sac.Branch.Division.Org', 
			];
		
		$this->FovResult->includeHosts = true;
		$fovResults = $this->paginate($this->paginateModel);
		
		foreach($fovResults as $i => $fovResult)
		{
			$fovResults[$i] = $this->FovResult->attachFismaSystem($fovResult, true);
		}
		
		$this->set('fovResults', $fovResults);
		
		$this->set(compact(['page_subtitle', 'page_description']));
	}
	
	public function orphans() 
	{
		$conditions = $this->FovResult->orphanConditions();
		
		$page_subtitle = __('Not found in any current %s', __('FISMA System'), __('Inventories'));
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function multiple_fisma_systems()
	{
		$conditions = $this->FovResult->conditionsforMultipleFismaSystems();
		
		$page_subtitle = __('Found in multiple %s', __('FISMA Systems'));
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function overridden()
	{
		$conditions = [
			'FovResult.fisma_system_id !=' => 0,
		];
		
		$page_subtitle = __('Results that have been Overridden');
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function eol_software($id = null) 
	{
		if (!$eol_software = $this->FovResult->EolSoftware->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL/US Software')));
		}
		$this->set('eol_software', $eol_software);
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$conditions = [
			'FovResult.eol_software_id' => $id,
		];
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function org($org_id = null, $stripped = false)  
	{
		if (!$org_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		
		$org = $this->FovResult->FismaSystem->OwnerContact->Sac->Branch->Division->Org->find('first', [
			'conditions' => ['Org.id' => $org_id],
		]);
		if (!$org) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		$this->set('object', $org);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->scopedResults('org', [], ['conditions' => ['Org.id' => $org_id]], true);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		$fismaSystem_ids = $this->FovResult->FismaSystem->idsForOrg($org_id);
		
		if($xrefResults)
		{
			$conditions['OR'] = [];
			if($fismaSystem_ids)
				$conditions['OR']['FovResult.fisma_system_id'] = $fismaSystem_ids;
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			if($fismaSystem_ids)
				$conditions['FovResult.fisma_system_id'] = $fismaSystem_ids;
		}
		
		if(!$conditions)
			$this->paginate['empty'] = true;
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function division($division_id = null, $stripped = false)  
	{
		if (!$division_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		
		$division = $this->FovResult->FismaSystem->OwnerContact->Sac->Branch->Division->find('first', [
			'conditions' => ['Division.id' => $division_id],
			'contain' => ['Org'],
		]);
		if (!$division) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		$this->set('object', $division);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->scopedResults('division', [], ['conditions' => ['Division.id' => $division_id]], true);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		$fismaSystem_ids = $this->FovResult->FismaSystem->idsForDivision($division_id);
		
		if($xrefResults)
		{
			$conditions['OR'] = [];
			if($fismaSystem_ids)
				$conditions['OR']['FovResult.fisma_system_id'] = $fismaSystem_ids;
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			if($fismaSystem_ids)
				$conditions['FovResult.fisma_system_id'] = $fismaSystem_ids;
		}
		
		if(!$conditions)
			$this->paginate['empty'] = true;
		
		// find the overidden ones
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function branch($branch_id = null, $stripped = false)  
	{
		if (!$branch_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		
		$branch = $this->FovResult->FismaSystem->OwnerContact->Sac->Branch->find('first', [
			'conditions' => ['Branch.id' => $branch_id],
			'contain' => ['Division', 'Division.Org'],
		]);
		if (!$branch) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		$this->set('object', $branch);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->scopedResults('branch', [], ['conditions' => ['Branch.id' => $branch_id]], true);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		$fismaSystem_ids = $this->FovResult->FismaSystem->idsForBranch($branch_id);
		
		if($xrefResults)
		{
			$conditions['OR'] = [];
			if($fismaSystem_ids)
				$conditions['OR']['FovResult.fisma_system_id'] = $fismaSystem_ids;
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			if($fismaSystem_ids)
				$conditions['FovResult.fisma_system_id'] = $fismaSystem_ids;
		}
		
		if(!$conditions)
			$this->paginate['empty'] = true;
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function sac($sac_id = null, $stripped = false)  
	{
		if (!$sac_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('SAC')));
		}
		
		$sac = $this->FovResult->FismaSystem->OwnerContact->Sac->find('first', [
			'conditions' => ['Sac.id' => $sac_id],
			'contain' => ['Branch', 'Branch.Division', 'Branch.Division.Org'],
		]);
		if (!$sac) 
		{
			throw new NotFoundException(__('Invalid %s', __('SAC')));
		}
		$this->set('object', $sac);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->scopedResults('sac', [], ['conditions' => ['Sac.id' => $sac_id]], true);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		$fismaSystem_ids = $this->FovResult->FismaSystem->idsForSac($sac_id);
		
		if($xrefResults)
		{
			$conditions['OR'] = [];
			if($fismaSystem_ids)
				$conditions['OR']['FovResult.fisma_system_id'] = $fismaSystem_ids;
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			if($fismaSystem_ids)
				$conditions['FovResult.fisma_system_id'] = $fismaSystem_ids;
		}
		
		if(!$conditions)
			$this->paginate['empty'] = true;
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function owner($owner_id = false, $stripped = false)
	{
		if (!$owner_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Contact')));
		}
		
		$ownerContact = $this->FovResult->FismaSystem->OwnerContact->find('first', [
			'conditions' => ['OwnerContact.id' => $owner_id],
			'contain' => ['Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'],
		]);
		$ownerContact['AdAccount'] = $ownerContact['OwnerContact'];
		if (!$ownerContact) 
		{
			throw new NotFoundException(__('Invalid %s', __('Contact')));
		}
		$this->set('object', $ownerContact);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->scopedResults('owner', [], ['conditions' => ['OwnerContact.id' => $owner_id]], true);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		$fismaSystem_ids = $this->FovResult->FismaSystem->idsForOwnerContact($owner_id);
		
		if($xrefResults)
		{
			$conditions['OR'] = [];
			if($fismaSystem_ids)
				$conditions['OR']['FovResult.fisma_system_id'] = $fismaSystem_ids;
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			if($fismaSystem_ids)
				$conditions['FovResult.fisma_system_id'] = $fismaSystem_ids;
		}
		
		if(!$conditions)
			$this->paginate['empty'] = true;
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function crm($crm_id = false, $stripped = false)
	{
		if (!$crm_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		
		$crm = $this->FovResult->FismaSystem->OwnerContact->find('first', [
			'conditions' => ['OwnerContact.id' => $crm_id],
			'contain' => ['Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'],
		]);
		$crm['AdAccount'] = $crm['OwnerContact'];
		if (!$crm) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		$this->set('object', $crm);
		
		$conditions = [];
		$fisma_system_ids = $this->FovResult->FismaSystem->idsForCrm($crm_id);
		
		if($fisma_system_ids)
		{
			$xrefConditions = $this->FovResult->scopedResults('crm', [], ['conditions' => ['FismaSystem.id' => $fisma_system_ids]], true);
			
			$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
				'contain' => ['FovHost'],
				'conditions' => $xrefConditions,
				'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
			]);
			
			if($xrefResults)
			{
				$conditions['OR'] = [];
				$conditions['OR']['FovResult.fisma_system_id'] = $fismaSystem_ids;
				$conditions['OR']['FovResult.id'] = $xrefResults;
			}
			else
			{
				$conditions['FovResult.fisma_system_id'] = $fismaSystem_ids;
			}
		}
		else
		{
			$this->paginate['empty'] = true;
		}
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function fisma_system($id = null, $reports_status_id = false, $stripped = false) 
	{
		if (!$fismaSystem = $this->FovResult->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		$this->set('fismaSystem', $fismaSystem);
		
		$page_subtitle = __('All Results for %s: %s', __('FISMA System'), $fismaSystem['FismaSystem']['name']);
		$page_description = '';
		
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$conditions = [];
		
		// find the dynamic relationship
		$xrefConditions = $this->FovResult->conditionsforFismaSystem($id);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost', 'FovResult'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
			
		if($xrefResults)
		{
			$conditions['OR'] = [];
			$conditions['OR']['FovResult.fisma_system_id'] = $id;
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			$conditions['FovResult.fisma_system_id'] = $id;
		}
		
		if($reports_status_id)
		{
			$reportsStatus = $this->FovResult->ReportsStatus->read(null, $reports_status_id);
			$page_subtitle = __('Results for %s: %s - with %s: %s', __('FISMA System'), $fismaSystem['FismaSystem']['name'], __('Status'), $reportsStatus['ReportsStatus']['name']);
			$conditions['FovResult.reports_status_id'] = $reports_status_id;
		}
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function fisma_inventory($id = null) 
	{
		if (!$fisma_inventory = $this->FovResult->FismaSystem->FismaInventory->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		$this->set('fisma_inventory', $fisma_inventory);
		
		$fisma_inventory_name = $fisma_inventory['FismaInventory']['name'];
		if(!$fisma_inventory_name)
			$fisma_inventory_name = $fisma_inventory['FismaInventory']['asset_tag'];
		if(!$fisma_inventory_name)
			$fisma_inventory_name = $fisma_inventory['FismaInventory']['ip_address'];
		
		$page_subtitle = __('%s: %s', __('FISMA Inventory'), $fisma_inventory_name);
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$conditions = ['OR' => []];
		
		// find the dynamic relationship
		$xrefConditions = $this->FovResult->FovHost->conditionsforInventory($fisma_inventory);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost', 'FovResult'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		if($xrefResults)
		{
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			$this->paginate['empty'] = true;
		}
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function fov_result($id = null) 
	{
		if (!$fovResult = $this->FovResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Result')));
		}
		$this->set('fovResult', $fovResult);
		
		$xrefConditions = $this->FovResult->conditionsforResult('FovResult', $id);
		$result_name = $this->FovResult->nameForResult('FovResult', $fovResult);
		
		$resultIds = $this->FovResult->FovHostFovResult->find('list', [
			'recursive' => 0,
			'conditions' => $xrefConditions,
			'fields' => ['FovResult.id', 'FovResult.id'],
		]);
		
		$conditions = ['FovResult.id' => $resultIds];
		
		$page_subtitle = __('%s: %s', __('FOV Result'), $result_name);
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function us_result($id = null) 
	{
		if (!$us_result = $this->FovResult->FismaSystem->UsResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		$this->set('us_result', $us_result);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->conditionsforResult('UsResult', $us_result);
		$result_name = $this->FovResult->nameForResult('UsResult', $us_result);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost', 'FovResult'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		if($xrefResults)
		{
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = __('%s: %s', __('US Result'), $result_name);
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function eol_result($id = null) 
	{
		if (!$eolResult = $this->FovResult->FismaSystem->EolResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Result')));
		}
		$this->set('eolResult', $eolResult);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->conditionsforResult('EolResult', $eolResult);
		$result_name = $this->FovResult->nameForResult('EolResult', $eolResult);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost', 'FovResult'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		if($xrefResults)
		{
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = __('%s: %s', __('EOL Result'), $result_name);
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function pen_test_result($id = null) 
	{
		if (!$pen_test_result = $this->FovResult->FismaSystem->PenTestResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Pen Test Result')));
		}
		$this->set('pen_test_result', $pen_test_result);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->conditionsforResult('PenTestResult', $pen_test_result);
		$result_name = $this->FovResult->nameForResult('PenTestResult', $pen_test_result);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost', 'FovResult'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		if($xrefResults)
		{
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = __('%s: %s', __('Pen Test Result'), $result_name);
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function high_risk_result($id = null) 
	{
		if (!$high_risk_result = $this->FovResult->FismaSystem->HighRiskResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		$this->set('high_risk_result', $high_risk_result);
		
		$conditions = [];
		
		$xrefConditions = $this->FovResult->conditionsforResult('HighRiskResult', $high_risk_result);
		$result_name = $this->FovResult->nameForResult('HighRiskResult', $high_risk_result);
		
		$xrefResults = $this->FovResult->FovHostFovResult->find('list', [
			'contain' => ['FovHost', 'FovResult'],
			'conditions' => $xrefConditions,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id']
		]);
		
		if($xrefResults)
		{
			$conditions['OR']['FovResult.id'] = $xrefResults;
		}
		else
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = __('%s: %s', __('High Risk Result'), $result_name);
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function tag($tag_id = null) 
	{
		if(!$tag_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		
		$tag = $this->FovResult->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$conditions = [];
		
		$conditions[] = $this->FovResult->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'FovResult');
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function view($id = false)
	{
		$this->FovResult->includeHosts = true;
		$this->FovResult->recursive = 0;
		if (!$fovResult = $this->FovResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Result')));
		}
		
		$fovResult = $this->FovResult->attachFismaSystem($fovResult);
			
		$this->set('fovResult', $fovResult);
	}
	
	public function add()
	{
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->FovResult->create();
			$this->request->data['FovResult']['modified_user_id'] = AuthComponent::user('id');
			if ($this->FovResult->addResult($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('FOV Result')));
				return $this->redirect(['action' => 'view', $this->FovResult->id]);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('FOV Result')));
			}
		}
		
		$this->_setAttributes();
	}
	
	public function edit($id = null)
	{
		$this->FovResult->id = $id;
		if (!$fovResult = $this->FovResult->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Result')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['FovResult']['modified_user_id'] = AuthComponent::user('id');
			if ($this->FovResult->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('FOV Result')));
				return $this->redirect(['action' => 'view', $this->FovResult->id]);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('FOV Result')));
			}
		}
		else
		{
			$this->request->data = $fovResult;
		}
		
		$this->_setAttributes();
	}

	public function admin_index() 
	{
		$this->bypassReferer = true;
		return $this->redirect(['action' => 'index', 'admin' => false]);
	}
	
	public function admin_view($id = false)
	{
		$this->bypassReferer = true;
		return $this->redirect(['action' => 'view', $id, 'admin' => false]);
	}
	
	public function admin_delete($id = null) 
	{
		$this->FovResult->id = $id;
		if (!$this->FovResult->exists()) {
			throw new NotFoundException(__('Invalid %s', __('FOV Result')));
		}
		if ($this->FovResult->delete()) {
			$this->Flash->success(__('%s deleted', __('FOV Result')));
			return $this->redirect(['action' => 'index', 'admin' => false]);
		}
		$this->Flash->error(__('%s was not deleted', __('FOV Result')));
		return $this->redirect(['action' => 'index', 'admin' => false]);
	}
	
/** Support functions **/
	protected function _setAttributes()
	{
		$reportsOrganizations = $this->FovResult->ReportsOrganization->typeFormListBlank();
		$reportsAssignableParties = $this->FovResult->ReportsAssignableParty->typeFormListBlank();
		$reportsRemediations = $this->FovResult->ReportsRemediation->typeFormListBlank();
		$reportsSeverities = $this->FovResult->ReportsSeverity->typeFormListBlank();
		$reportsStatuses = $this->FovResult->ReportsStatus->typeFormListBlank();
		$reportsVerifications = $this->FovResult->ReportsVerification->typeFormListBlank();
		$eolSoftwares = $this->FovResult->EolSoftware->typeFormList();
		$fismaSystems = $this->FovResult->FismaSystem->typeFormList();
		$multiselectOptions = $this->FovResult->multiselectOptions(false, true);
		
		$this->set(compact([
			'reportsOrganizations', 'eolSoftwares', 'fismaSystems', 'multiselectOptions',
			'reportsAssignableParties', 'reportsRemediations', 'reportsSeverities', 'reportsStatuses', 'reportsVerifications',
		]));
	}
}