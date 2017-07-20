<?php
App::uses('AppController', 'Controller');

class UsResultsController extends AppController 
{
	public $cacheAction = array(
	    'db_block_overview' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_assignable_party_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_remediation_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_status_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_verification_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		
	    'db_tab_index' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_gssparent' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		
		'db_tab_totals' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_tab_assignable_party' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		'db_tab_remediation' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		'db_tab_status' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		'db_tab_software' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		'db_tab_verification' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		
		'db_tab_breakout' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
	);
	
	public $subscriptions = [
		'isso_open_counts'
	];
	
	public function menu_assignable_parties() 
	{
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->UsResult->ReportsAssignableParty->typeFormListOrder = array('name' => 'ASC');
		$reportsAssignableParties = $this->UsResult->ReportsAssignableParty->typeFormList();
		
		foreach($reportsAssignableParties as $reportsAssignableParty_id => $reportsAssignableParty_name)
		{
			$title = $reportsAssignableParty_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('action' => 'index', 'field' => 'reports_assignable_party_id', 'value' => $reportsAssignableParty_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function menu_remediations() 
	{
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->UsResult->ReportsRemediation->typeFormListOrder = array('name' => 'ASC');
		$reportsRemediations = $this->UsResult->ReportsRemediation->typeFormList();
		
		foreach($reportsRemediations as $reportsRemediation_id => $reportsRemediation_name)
		{
			$title = $reportsRemediation_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('action' => 'index', 'field' => 'reports_remediation_id', 'value' => $reportsRemediation_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function menu_verifications() 
	{
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->UsResult->ReportsVerification->typeFormListOrder = array('name' => 'ASC');
		$reportsVerifications = $this->UsResult->ReportsVerification->typeFormList();
		
		foreach($reportsVerifications as $reportsVerification_id => $reportsVerification_name)
		{
			$title = $reportsVerification_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('action' => 'index', 'field' => 'reports_verification_id', 'value' => $reportsVerification_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
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
		$items = array();
		$this->UsResult->ReportsStatus->typeFormListOrder = array('name' => 'ASC');
		$reportsStatuses = $this->UsResult->ReportsStatus->typeFormList();
		
		foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
		{
			$title = $reportsStatus_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'us_results', 'action' => 'index', 'field' => 'reports_status_id', 'value' => $reportsStatus_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function crm_actionable($fisma_system_id = false, $crm_id = false)
	{
		$crm = $this->UsResult->FismaSystem->getCrm($crm_id);
		$crm_id = $crm['AdAccount']['id'];
		$this->set('crm', $crm);
		$this->set('crm_id', $crm_id);
		
		$conditions = array();
		
		$reportsStatuses = $this->UsResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$conditions['UsResult.reports_status_id'] = $reportsStatus_ids;
		
		if($fisma_system_id)
		{
			if (!$fisma_system = $this->UsResult->FismaSystem->read(null, $fisma_system_id))
			{
				throw new NotFoundException(__('Invalid %s', __('FISMA System')));
			}
			$this->set('fisma_system', $fisma_system);
			
			if(!$scopedConditions = $this->UsResult->conditionsforFismaSystem($fisma_system_id))
			{
				$this->paginate['empty'] = true;
			}
			
			$conditions = array_merge($conditions, $scopedConditions);
		}
		
		$this->paginate['conditions'] = $this->UsResult->conditions($conditions, $this->passedArgs); 
		
		$this->UsResult->recursive = 0;
		$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->UsResult->find('count', array('conditions' => $this->paginate['conditions']));
		
		if($this->paginate['limit'])
			$us_results = $this->paginate();
		else
			$us_results = array();
		return $us_results;
	}
	
	public function director_db_block_overview($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$usResults = $this->UsResult->listforDirector($ad_account_id, 'all', array('recursive' => 0));
		
		$usResults = $this->UsResult->dbOverviewUpdate($usResults);
		
		$reportsStatuses = $this->UsResult->ReportsStatus->typeFormList();
		$this->set(compact('usResults', 'reportsStatuses'));
		
	}
	
	public function director_db_tab_index($ad_account_id = false, $stripped = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		if(!$this->conditions = $this->UsResult->listforDirector($ad_account_id, 'conditions'))
		{
			$this->paginate['empty'] = true;
		}
		
		return $this->db_tab_index($stripped);
	}
	
	public function db_block_overview($us_report_id = false)
	{
		$conditions = [];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$usResults = $this->UsResult->find('all', [
			'contain' => ['ReportsStatus'],
			'conditions' => $conditions,
		]);
		
		foreach($usResults as $i => $usResult)
		{
			$usResults[$i] = $this->UsResult->attachFismaSystem($usResult);
		}
		
		$reportsStatuses = $this->UsResult->ReportsStatus->typeFormList();
		$this->set(compact('usResults', 'reportsStatuses'));
		
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_assignable_party_trend()
	{
		$snapshotStats = $this->UsResult->snapshotDashboardGetStats('/^us_result\.reports_assignable_party\-\d+$/');
		
		$this->set(compact('snapshotStats'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_remediation_trend()
	{
		$snapshotStats = $this->UsResult->snapshotDashboardGetStats('/^us_result\.reports_remediation\-\d+$/');
		
		$this->set(compact('snapshotStats'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_status_trend()
	{
		$snapshotStats = $this->UsResult->snapshotDashboardGetStats('/^us_result\.reports_status\-\d+$/');
		$reportsStatuses = $this->UsResult->ReportsStatus->find('list', array(
			'fields' => array('ReportsStatus.id', 'ReportsStatus.color_code_hex'),
		));
		
		$this->set(compact('snapshotStats', 'reportsStatuses'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_verification_trend()
	{
		$snapshotStats = $this->UsResult->snapshotDashboardGetStats('/^us_result\.reports_verification\-\d+$/');
		
		$this->set(compact('snapshotStats'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_index($stripped = false, $us_report_id = false)
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['UsResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$conditions = array_merge($conditions, $this->conditions);
		
		if(isset($conditions['OR']) and !$conditions['OR'] and !in_array($this->action, array('db_tab_index')))
		{
			$this->paginate['empty'] = true;
		}
		
		$this->paginate['contain'] = $this->UsResult->containOverride;
		$this->paginate['conditions'] = $this->UsResult->conditions($conditions, $this->passedArgs); 
		
		$this->UsResult->recursive = 0;
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'UsResult';
		
		if($stripped and $this->request->is('ajax'))
		{
			$this->passedArgs['showall'] = true;
		}
		
		$usResults = $this->paginate($this->paginateModel);
		
		foreach($usResults as $i => $usResult)
		{
			$usResults[$i] = $this->UsResult->attachFismaSystem($usResult);
		}
		
		$this->set(compact(['usResults', 'stripped', 'us_report_id']));
		
		$this->layout = 'Utilities.ajax_nodebug';
		return $this->render();
	}
	
	public function db_tab_gssparent($us_report_id = false)
	{
		$fismaSystems = $this->UsResult->FismaSystem->find('AllParents', array(
			'order' => array('FismaSystem.name' => 'ASC'),
		));
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			// get the children
			$this->UsResult->FismaSystem->id = $fismaSystem['FismaSystem']['id'];
			$fismaSystemChildren = $this->UsResult->FismaSystem->find('MyChildren');
			
			$fismaSystemIds = array($fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']);
			
			// get the children related vectors
			foreach($fismaSystemChildren as $j => $fismaSystemChild)
			{
				$fismaSystemIds[$fismaSystemChild['FismaSystem']['id']] = $fismaSystemChild['FismaSystem']['id'];
			}
			
			$conditionsUsResult = $this->UsResult->conditionsforFismaSystem($fismaSystemIds);
			
			if(!isset($conditionsUsResult['OR']))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			if($us_report_id > 0)
			{
				$conditionsUsResult['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
			}
			
			if(!$usResults = $this->UsResult->find('all', array(
				'conditions' => $conditionsUsResult,
			)))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			$fismaSystems[$i]['UsResults'] = $usResults;
		}
		
		$this->set(compact(array(
			'fismaSystems',
			'us_report_id',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_totals($scope = 'org', $as_block = false, $us_report_id = false)
	{
		$conditions = array();
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['UsResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->scopedResults($scope, $conditions);
		$reportsStatuses = $this->UsResult->ReportsStatus->find('all');
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsStatuses',
			'us_report_id',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_assignable_party($scope = 'org', $as_block = false, $us_report_id = false)
	{
		$this->UsResult->recursive = 0;
		$this->UsResult->contain($this->UsResult->containOverrideTab);
		
		$conditions = [];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->scopedResults($scope, $conditions);
		
		$reportsAssignableParties = $this->UsResult->EolSoftware->ReportsAssignableParty->typeFormList();
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsAssignableParties',
			'us_report_id',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_remediation($scope = 'org', $as_block = false, $us_report_id = false)
	{
		$this->UsResult->recursive = 0;
		$this->UsResult->contain($this->UsResult->containOverrideTab);
		
		$conditions = [];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->scopedResults($scope, $conditions);
		
		$reportsRemediations = $this->UsResult->EolSoftware->ReportsRemediation->typeFormList();
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsRemediations',
			'us_report_id',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_status($scope = 'org', $as_block = false, $us_report_id = false)
	{
		$conditions = [];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->scopedResults($scope, $conditions);
		
		$reportsStatuses = $this->UsResult->ReportsStatus->findforTable();
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsStatuses',
			'us_report_id',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_verification($scope = 'org', $as_block = false, $us_report_id = false)
	{
		$this->UsResult->recursive = 0;
		$this->UsResult->contain($this->UsResult->containOverrideTab);
		
		$conditions = [];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->scopedResults($scope, $conditions);
		
		$reportsVerifications = $this->UsResult->EolSoftware->ReportsVerification->typeFormList();
		
		$this->set(compact(array(
			'results',
			'as_block', 'reportsVerifications',
			'us_report_id',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_software($scope = 'org', $as_block = false, $us_report_id = false)
	{
		$subtitle = __('All Results');
		
		$this->UsResult->EolSoftware->typeFormListConditions = array('EolSoftware.is_us' => true);
		$eolSoftwares = $this->UsResult->EolSoftware->typeFormList();
		$reportsStatuses = $this->UsResult->ReportsStatus->typeFormList();
		
		$conditions = array();
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
		{
			$subtitle = __('By Status: %s', (isset($reportsStatuses[$this->passedArgs['reports_status_id']])?$reportsStatuses[$this->passedArgs['reports_status_id']]:''));
			$conditions['UsResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		}
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->scopedResults($scope, $conditions);
		
		$this->set(compact(array(
			'as_block', 'results', 'subtitle',
			'eolSoftwares', 'reportsStatuses',
			'us_report_id',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_software_all($us_report_id = false)
	{
		$subtitle = __('All Results');
		
		$conditions = [];
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->UsResult->find('all', [
			'contain' => ['EolSoftware'],
			'conditions' => $conditions
		]);
		
		$this->set(compact([
			'results', 'subtitle',
			'us_report_id',
		]));
	}
	
	public function db_tab_breakout($scope = 'division', $as_block = false, $us_report_id = false)
	{
		$conditions = array();
		
		$reportsStatusOpenId = $this->UsResult->ReportsStatus->getOpenId();
		
		$reportsStatusName = __('All');
		$reportsStatusId = 0;
		if(isset($this->passedArgs['reports_status_id']))
		{
			if($this->passedArgs['reports_status_id'])
			{
				$conditions['UsResult.reports_status_id']  = $this->passedArgs['reports_status_id'];
				$reportsStatusName = __('Status: %s', $this->UsResult->ReportsStatus->field('name', array('ReportsStatus.id' => $this->passedArgs['reports_status_id'])));
				$reportsStatusId = $this->passedArgs['reports_status_id'];
			}
		}
		else
		{
			$conditions['UsResult.reports_status_id'] = $reportsStatusOpenId;
			$reportsStatusName = __('Status: %s', __('Open'));
			$reportsStatusId = $reportsStatusOpenId;
		}
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$results = $this->scopedResults($scope, $conditions);
		
		$results = $this->scopedResults($scope, $conditions);
		$reportsStatuses = $this->UsResult->ReportsStatus->typeFormList();
		$this->set(compact(array(
			'as_block', 'results', 'scope', 
			'reportsStatusOpenId', 'reportsStatusId', 'reportsStatusName', 'reportsStatuses',
			'us_report_id'
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_crossovers($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		// try to figure out how they're crossing over
		$seenResults = array();
		foreach($results as $resultId => $result)
		{
			foreach($result['UsResults'] as $myResult_id => $myResult)
			{
				if(isset($myResult['UsResult']['fisma_system_id']) and $myResult['UsResult']['fisma_system_id'])
					continue;
				if(!isset($seenResults[$myResult_id]))
					$seenResults[$myResult_id] = array();
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
		
		$results = $this->UsResult->find('all', array(
			'conditions' => array(
				'UsResult.id' => array_keys($seenResults),
			),
		));
		
		foreach($results as $i => $result)
		{
			$result_id = $result['UsResult']['id'];
			$results[$i]['crossovers'] = $seenResults[$result_id];
		}
		
		$this->set(compact(array(
			'as_block', 'results',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function dashboard($us_report_id = false)
	{
		if($us_report_id !== false)
			$this->UsResult->setReportId($us_report_id);
		
		$us_report_id = $this->UsResult->getReportId();
		
		$usReports = $this->UsResult->UsReport->listForDashboard();
		$this->set(compact(['usReports', 'us_report_id']));
		
	}
	
	public function search_results()
	{
		return $this->index();
	}
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$reportsOrganizations = $this->UsResult->ReportsOrganization->typeFormList();
		$reportsStatuses = $this->UsResult->ReportsStatus->typeFormList();
		$eolSoftwares = $this->UsResult->EolSoftware->typeFormList();
		$multiselectOptions = $this->UsResult->multiselectOptions(false, true);
		$fismaSystems = $this->UsResult->FismaSystem->typeFormList();
		$this->set(compact(array(
			'reportsOrganizations', 'reportsStatuses',
			'eolSoftwares', 'multiselectOptions', 
			'fismaSystems'
		)));
		
		$local_page_subtitle = __('All');
		$conditions = array();
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
		{
			$local_page_subtitle = __('By Status: %s', (isset($reportsStatuses[$this->passedArgs['reports_status_id']])?$reportsStatuses[$this->passedArgs['reports_status_id']]:''));
			$conditions['UsResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		}
		
		$conditions = array_merge($conditions, $this->conditions);
		
		if(in_array($this->action, ['us_report', 'us_report_added', 'us_report_removed']))
		{
			if(!isset($conditions['UsResult.id']))
				$this->paginate['empty'] = true;
		}
		else
		{
			if(isset($this->passedArgs['latest']) and $this->passedArgs['latest'])
			{
				$local_page_subtitle = __('From the latest Report.');
				$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($this->UsResult->UsReport->latestReportId());
			}
		}
		
		if(isset($conditions['OR']) and !$conditions['OR'] and !in_array($this->action, ['index', 'admin_index']))
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = (isset($this->viewVars['page_subtitle'])?$this->viewVars['page_subtitle']:$local_page_subtitle);
		$page_description = (isset($this->viewVars['page_description'])?$this->viewVars['page_description']:'');
		
		if(isset($this->passedArgs['field']) and isset($this->passedArgs['value'])) 
		{
			$field = $this->passedArgs['field'];
			if(strpos($field, '.') === false)
				$field = 'UsResult.'. $field;
			$conditions[$field] = $this->passedArgs['value'];
			
			if($this->passedArgs['field'] == 'reports_status_id' and isset($reportsStatuses[$this->passedArgs['value']]))
			{
				$reportsStatus = $this->UsResult->ReportsStatus->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Status'), $reportsStatus['ReportsStatus']['name']);
				$page_description = $reportsStatus['ReportsStatus']['details'];
			}
		}
		
		$this->paginate['conditions'] = $this->UsResult->conditions($conditions, $this->passedArgs);
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->UsResult->getCachedCounts('count', array('conditions' => $this->paginate['conditions']));
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'UsResult';
		
		$this->paginate['contain'] = $this->UsResult->containOverride;
		$this->UsResult->includeCounts = false;
		
		$us_results = $this->paginate($this->paginateModel);
		
		foreach($us_results as $i => $us_result)
		{
			$us_results[$i] = $this->UsResult->attachFismaSystem($us_result, true);
		}
		
		$this->set('us_results', $us_results);
		
		$this->set(compact(array('page_subtitle', 'page_description')));
	}
	
	public function duplicates() 
	{
		$conditions = array();
		
		$page_subtitle = __('%s that are possible duplicates', __('US Results'));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function orphans($us_report_id = false) 
	{
		$conditions = $this->UsResult->orphanConditions();
		
		if($us_report_id > 0)
		{
			$conditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		$page_subtitle = __('Not found in any current %s', __('FISMA System'), __('Inventories'));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function multiple_fisma_systems()
	{
		$conditions = $this->UsResult->conditionsforMultipleFismaSystems();
		
		$page_subtitle = __('Found in multiple %s', __('FISMA Systems'));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function overridden()
	{
		$conditions = array(
			'UsResult.fisma_system_id !=' => 0,
		);
		
		$page_subtitle = __('Results that have been Overridden');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function isso_open($ad_account_id = false)
	{
		$resultIds = $this->UsResult->UsReportUsResult->find('list', [
			'conditions' => [
				'UsReportUsResult.us_report_id' => $this->UsResult->UsReport->latestReportId(),
			],
			'fields' => ['UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'],
		]);
		
		$openId = $this->UsResult->ReportsStatus->getOpenId();
		
		$conditions = [
			'UsResult.id' => $this->UsResult->getResultIdsForReport($this->UsResult->UsReport->latestReportId()),
			'UsResult.reports_status_id' => $openId,
		];
		
		$page_subtitle = __('Open Individual Results');
		$page_description = '';
		$no_options = true;
		$this->set(compact(['page_title', 'page_subtitle', 'page_description', 'no_options']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function isso_open_counts($ad_account_id = false)
	{
		$resultIds = $this->UsResult->UsReportUsResult->find('list', [
			'conditions' => [
				'UsReportUsResult.us_report_id' => $this->UsResult->UsReport->latestReportId(),
			],
			'fields' => ['UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'],
		]);
		
		$openId = $this->UsResult->ReportsStatus->getOpenId();
		
		$results = $this->UsResult->find('all', [
			'contain' => ['FismaSystem.OwnerContact.Sac.Branch.Division.Org'],
			'conditions' => [
				'UsResult.id' => $resultIds,
				'UsResult.reports_status_id' => $openId,
			],
		]);
		
		foreach($results as $i => $result)
		{
			$results[$i] = $this->UsResult->attachFismaSystem($result);
		}
		
		$this->set(compact(['results']));
	}
	
	public function us_report($id = null) 
	{
		if (!$us_report = $this->UsResult->UsReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		$this->set('us_report', $us_report);
		
		$this->UsResult->UsReportUsResult->recursive = -1;
		$usResultIds = $this->UsResult->UsReportUsResult->find('list', array(
			'conditions' => array(
				'UsReportUsResult.us_report_id' => $id,
			),
			'fields' => array('UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'),
		));
		$conditions = array(
			'UsResult.id' => $usResultIds,
		);
		
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function us_report_added($id = null) 
	{
		if (!$us_report = $this->UsResult->UsReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		$this->set('us_report', $us_report);
		
		if(!$previousReportId = $this->UsResult->UsReport->previousReportId($id))
		{
			throw new NotFoundException(__('No previous %s found to compare.', __('US Report')));
		}
		
		$this->UsResult->UsReportUsResult->recursive = -1;
		$currentResultIds = $this->UsResult->UsReportUsResult->find('list', [
			'conditions' => [
				'UsReportUsResult.us_report_id' => $id,
			],
			'fields' => ['UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'],
			'order' => ['UsReportUsResult.us_result_id' => 'ASC'],
		]);
		
		$previousResultIds = $this->UsResult->UsReportUsResult->find('list', [
			'conditions' => [
				'UsReportUsResult.us_report_id' => $previousReportId,
			],
			'fields' => ['UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'],
			'order' => ['UsReportUsResult.us_result_id' => 'ASC'],
		]);
		$newResultIds = [];
		foreach($currentResultIds as $currentResultId)
		{
			if(!isset($previousResultIds[$currentResultId]))
				$newResultIds[$currentResultId] = $currentResultId;
		}
		
		$conditions = array(
			'UsResult.id' => $newResultIds,
		);
		
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function us_report_removed($id = null) 
	{
		if (!$us_report = $this->UsResult->UsReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		$this->set('us_report', $us_report);
		
		if(!$previousReportId = $this->UsResult->UsReport->previousReportId($id))
		{
			throw new NotFoundException(__('No previous %s found to compare.', __('US Report')));
		}
		
		$this->UsResult->UsReportUsResult->recursive = -1;
		$currentResultIds = $this->UsResult->UsReportUsResult->find('list', [
			'conditions' => [
				'UsReportUsResult.us_report_id' => $id,
			],
			'fields' => ['UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'],
			'order' => ['UsReportUsResult.us_result_id' => 'ASC'],
		]);
		
		$previousResultIds = $this->UsResult->UsReportUsResult->find('list', [
			'conditions' => [
				'UsReportUsResult.us_report_id' => $previousReportId,
			],
			'fields' => ['UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'],
			'order' => ['UsReportUsResult.us_result_id' => 'ASC'],
		]);
		$newResultIds = [];
		foreach($previousResultIds as $previousResultId)
		{
			if(!isset($currentResultIds[$previousResultId]))
				$newResultIds[$previousResultId] = $previousResultId;
		}
		
		$conditions = array(
			'UsResult.id' => $newResultIds,
		);
		
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function fisma_software($id = null) 
	{
		if (!$fisma_software = $this->UsResult->FismaSoftware->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Whitelisted Software')));
		}
		$this->set('fisma_software', $fisma_software);
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$conditions = array(
			'UsResult.fisma_software_id' => $id,
		); 
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function eol_software($id = null) 
	{
		if (!$eol_software = $this->UsResult->EolSoftware->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL/US Software')));
		}
		$this->set('eol_software', $eol_software);
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$conditions = array(
			'UsResult.eol_software_id' => $id,
		); 
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function org($org_id = null, $stripped = false)  
	{
		if (!$org_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		
		$org = $this->UsResult->FismaSystem->OwnerContact->Sac->Branch->Division->Org->find('first', array(
			'conditions' => array('Org.id' => $org_id),
		));
		if (!$org) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		$this->set('object', $org);
		
		$conditions = $this->UsResult->scopedResults('org', array(), array('conditions' => array('Org.id' => $org_id)), true);
		$conditions = array_merge($conditions, $this->conditions);
		if(!$conditions['OR'])
			$this->paginate['empty'] = true;
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function division($division_id = null, $stripped = false, $us_report_id = false)  
	{
		if (!$division_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		
		$division = $this->UsResult->FismaSystem->OwnerContact->Sac->Branch->Division->find('first', [
			'conditions' => ['Division.id' => $division_id],
			'contain' => ['Org'],
		]);
		if (!$division) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		$this->set('object', $division);
		
		$scopedConditions = [];
		
		if($us_report_id > 0)
		{
			$scopedConditions['UsResult.id'] = $this->UsResult->getResultIdsForReport($us_report_id);
		}
		
		
		$conditions = $this->UsResult->scopedResults('division', $scopedConditions, ['conditions' => ['Division.id' => $division_id]], true);
		$conditions = array_merge($conditions, $this->conditions);
		
		if(!$conditions['OR'])
			$this->paginate['empty'] = true;
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped, $us_report_id);
		else
			return $this->index();
	}
	
	public function branch($branch_id = null, $stripped = false)  
	{
		if (!$branch_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		
		$branch = $this->UsResult->FismaSystem->OwnerContact->Sac->Branch->find('first', array(
			'conditions' => array('Branch.id' => $branch_id),
			'contain' => array('Division', 'Division.Org'),
		));
		if (!$branch) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		$this->set('object', $branch);
		
		$conditions = $this->UsResult->scopedResults('branch', array(), array('conditions' => array('Branch.id' => $branch_id)), true);
		$conditions = array_merge($conditions, $this->conditions);
		if(!$conditions['OR'])
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
		
		$sac = $this->UsResult->FismaSystem->OwnerContact->Sac->find('first', array(
			'conditions' => array('Sac.id' => $sac_id),
			'contain' => array('Branch', 'Branch.Division', 'Branch.Division.Org'),
		));
		if (!$sac) 
		{
			throw new NotFoundException(__('Invalid %s', __('SAC')));
		}
		$this->set('object', $sac);
		
		$conditions = $this->UsResult->scopedResults('sac', array(), array('conditions' => array('Sac.id' => $sac_id)), true);
		$conditions = array_merge($conditions, $this->conditions);
		if(!$conditions['OR'])
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
		
		$ownerContact = $this->UsResult->FismaSystem->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $owner_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		$ownerContact['AdAccount'] = $ownerContact['OwnerContact'];
		if (!$ownerContact) 
		{
			throw new NotFoundException(__('Invalid %s', __('Contact')));
		}
		$this->set('object', $ownerContact);
		
		$conditions = $this->UsResult->scopedResults('owner', array(), array('conditions' => array('OwnerContact.id' => $owner_id)), true);
		$conditions = array_merge($conditions, $this->conditions);
		if(!$conditions['OR'])
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
		
		$crm = $this->UsResult->FismaSystem->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $crm_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		$crm['AdAccount'] = $crm['OwnerContact'];
		if (!$crm) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		$this->set('object', $crm);
		
		$conditions = array('OR' => array());
		if($fismaSystem_ids = $this->UsResult->FismaSystem->idsForCrm($crm_id))
		{
			$conditions = $this->UsResult->scopedResults('crm', array(), array(
				'conditions' => array('FismaSystem.id' => $fismaSystem_ids)
			), true);
			$conditions = array_merge($conditions, $this->conditions);
		}
		
		if(!$conditions['OR'])
			$this->paginate['empty'] = true;
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function fisma_system($id = null, $reports_status_id = false, $stripped = false, $us_report_id = false) 
	{
		if (!$fisma_system = $this->UsResult->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		$this->set('fisma_system', $fisma_system);
		
		$page_subtitle = __('All Results for %s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name']);
		if(isset($this->passedArgs['latest']) and $this->passedArgs['latest'])
		{
			$page_subtitle = __('All Results from the latest Report for %s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name']);
		}
		$page_description = '';
		
		$conditions = array();
		
		if($reports_status_id)
		{
			$reportsStatus = $this->UsResult->ReportsStatus->read(null, $reports_status_id);
			$page_subtitle = __('Results for %s: %s - with %s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name'], __('Status'), $reportsStatus['ReportsStatus']['name']);
			$conditions['UsResult.reports_status_id'] = $reports_status_id;
		}
			
		if(!$scopedConditions = $this->UsResult->conditionsforFismaSystem($id))
		{
			$this->paginate['empty'] = true;
		}
		
		$conditions = array_merge($conditions, $scopedConditions);
			
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function fisma_inventory($id = null) 
	{
		if (!$fisma_inventory = $this->UsResult->SubnetMember->FismaInventory->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		$this->set('fisma_inventory', $fisma_inventory);
		
		$conditions = $this->UsResult->conditionsforInventory($fisma_inventory);
		if(!isset($conditions['OR']))
			$this->paginate['empty'] = true;
		
		$fisma_inventory_name = $fisma_inventory['FismaInventory']['name'];
		if(!$fisma_inventory_name)
			$fisma_inventory_name = $fisma_inventory['FismaInventory']['asset_tag'];
		if(!$fisma_inventory_name)
			$fisma_inventory_name = $fisma_inventory['FismaInventory']['ip_address'];
		
		$page_subtitle = __('%s: %s', __('FISMA Inventory'), $fisma_inventory_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function fov_result($id = null) 
	{
		if (!$fov_result = $this->UsResult->FismaSystem->FovResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Result')));
		}
		$this->set('fov_result', $fov_result);
		
		$conditions = $this->UsResult->conditionsforResult('FovResult', $fov_result);
		$result_name = $this->UsResult->nameForResult('FovResult', $fov_result);
		
		$page_subtitle = __('%s: %s', __('FOV Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function us_result($id = null) 
	{
		if (!$us_result = $this->UsResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		$this->set('us_result', $us_result);
		
		$conditions = $this->UsResult->conditionsforResult('UsResult', $us_result);
		$result_name = $this->UsResult->nameForResult('UsResult', $us_result);
		
		$page_subtitle = __('%s: %s', __('US Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function eol_result($id = null) 
	{
		if (!$eol_result = $this->UsResult->SubnetMember->EolResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Result')));
		}
		$this->set('eol_result', $eol_result);
		
		$conditions = $this->UsResult->conditionsforResult('EolResult', $eol_result);
		$result_name = $this->UsResult->nameForResult('EolResult', $eol_result);
		
		$page_subtitle = __('%s: %s', __('EOL Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function pen_test_result($id = null) 
	{
		if (!$pen_test_result = $this->UsResult->SubnetMember->PenTestResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Pen Test Result')));
		}
		$this->set('pen_test_result', $pen_test_result);
		
		$conditions = $this->UsResult->conditionsforResult('PenTestResult', $pen_test_result);
		$result_name = $this->UsResult->nameForResult('PenTestResult', $pen_test_result);
		
		$page_subtitle = __('%s: %s', __('Pen Test Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function high_risk_result($id = null) 
	{
		if (!$high_risk_result = $this->UsResult->SubnetMember->HighRiskResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		$this->set('high_risk_result', $high_risk_result);
		
		$conditions = $this->UsResult->conditionsforResult('HighRiskResult', $high_risk_result);
		$result_name = $this->UsResult->nameForResult('HighRiskResult', $high_risk_result);
		
		$page_subtitle = __('%s: %s', __('High Risk Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function tag($tag_id = null) 
	{
		if(!$tag_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		
		$tag = $this->UsResult->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$conditions = array();
		
		$conditions[] = $this->UsResult->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'UsResult');
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function view($id = false)
	{
		$this->UsResult->id = $id;
		$this->UsResult->recursive = 0;
		$this->UsResult->contain(array(
			'UsResultAddedUser', 'UsResultModifiedUser',
			'ReportsOrganization', 'ReportsStatus', 'UsResultStatusUser',
			'EolSoftware', 'EolSoftware.ReportsAssignableParty', 'EolSoftware.ReportsRemediation', 'EolSoftware.ReportsRemediationUser', 'EolSoftware.ReportsVerification', 'EolSoftware.ReportsVerificationUser', 
		));
		if (!$us_result = $this->UsResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		
		$us_result = $this->UsResult->attachFismaSystem($us_result);
			
		$this->set('us_result', $us_result);
	}
	
	public function edit($id = null)
	{
		$this->UsResult->id = $id;
		$this->UsResult->recursive = 1;
		$this->UsResult->contain(array('Tag', 'ReportsOrganization'));
		if (!$us_result = $this->UsResult->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['UsResult']['modified_user_id'] = AuthComponent::user('id');
			if ($this->UsResult->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('US Result')));
				return $this->redirect(array('action' => 'view', $this->UsResult->id));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('US Result')));
			}
		}
		else
		{
			$this->request->data = $us_result;
		}
		
		$reportsOrganizations = $this->UsResult->ReportsOrganization->typeFormListBlank();
		$reportsStatuses = $this->UsResult->ReportsStatus->typeFormListBlank();
		$eolSoftwares = $this->UsResult->EolSoftware->typeFormListBlank();
		$fismaSystems = $this->UsResult->FismaSystem->typeFormList();
		$this->set(compact(array('reportsOrganizations', 'reportsStatuses', 'eolSoftwares', 'fismaSystems')));
	}
	
	public function autoclose() 
	{
		if($results = $this->UsResult->autoClose())
		{
			$this->Flash->success(__('%s %s were auto closed.', $results, __('US Results')));
			return $this->redirect(array('action' => 'index'));
		}
		
		$possibleError = false;
		if($this->UsResult->modelError)
			$possibleError = __('Error: %s', $this->UsResult->modelError);
		$this->Flash->error(__('NO %s were auto closed. %s', __('US Results'), $possibleError));
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_index() 
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
	
	public function admin_view($id = false)
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'view', $id, 'admin' => false));
	}
	
	public function admin_delete($id = null) 
	{
		$this->UsResult->id = $id;
		if (!$this->UsResult->exists()) {
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		if ($this->UsResult->delete()) {
			$this->Flash->success(__('%s deleted', __('US Result')));
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}
		$this->Flash->error(__('%s was not deleted', __('US Result')));
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
}