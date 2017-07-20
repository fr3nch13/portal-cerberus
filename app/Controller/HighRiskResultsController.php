<?php
App::uses('AppController', 'Controller');

class HighRiskResultsController extends AppController 
{
	/** BBBBB **/
	public $cacheAction = array(
	    'db_block_overview' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_assignable_party_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_remediation_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_status_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_system_type_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_verification_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		
	    'db_tab_index' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
//		'db_tab_status_change' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_gssparent' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		
		'db_tab_totals' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_tab_assignable_party' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		'db_tab_remediation' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		'db_tab_status' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		'db_tab_verification' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1)) ),
		
		'db_tab_breakout' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
	);
	
	public $subscriptions = [
		'isso_open_counts',
	];
	
	public function menu_assignable_parties() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->HighRiskResult->ReportsAssignableParty->typeFormListOrder = array('name' => 'ASC');
		$reportsAssignableParties = $this->HighRiskResult->ReportsAssignableParty->typeFormList();
		
		foreach($reportsAssignableParties as $reportsAssignableParty_id => $reportsAssignableParty_name)
		{
			$title = $reportsAssignableParty_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'high_risk_results', 'action' => 'index', 'field' => 'reports_assignable_party_id', 'value' => $reportsAssignableParty_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
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
		$items = array();
		$this->HighRiskResult->ReportsRemediation->typeFormListOrder = array('name' => 'ASC');
		$reportsRemediations = $this->HighRiskResult->ReportsRemediation->typeFormList();
		
		foreach($reportsRemediations as $reportsRemediation_id => $reportsRemediation_name)
		{
			$title = $reportsRemediation_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'high_risk_results', 'action' => 'index', 'field' => 'reports_remediation_id', 'value' => $reportsRemediation_id, 'admin' => false, 'saa' => false, 'plugin' => false)
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
		$this->HighRiskResult->ReportsStatus->typeFormListOrder = array('name' => 'ASC');
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->typeFormList();
		
		foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
		{
			$title = $reportsStatus_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'high_risk_results', 'action' => 'index', 'field' => 'reports_status_id', 'value' => $reportsStatus_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function menu_system_types() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->HighRiskResult->ReportsSystemType->typeFormListOrder = array('name' => 'ASC');
		$reportsSystemTypes = $this->HighRiskResult->ReportsSystemType->typeFormList();
		
		foreach($reportsSystemTypes as $reportsSystemType_id => $reportsSystemType_name)
		{
			$title = $reportsSystemType_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'high_risk_results', 'action' => 'index', 'field' => 'reports_system_type_id', 'value' => $reportsSystemType_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
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
		$items = array();
		$this->HighRiskResult->ReportsVerification->typeFormListOrder = array('name' => 'ASC');
		$reportsVerifications = $this->HighRiskResult->ReportsVerification->typeFormList();
		
		foreach($reportsVerifications as $reportsVerification_id => $reportsVerification_name)
		{
			$title = $reportsVerification_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'high_risk_results', 'action' => 'index', 'field' => 'reports_verification_id', 'value' => $reportsVerification_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function crm_actionable($fisma_system_id = false, $crm_id = false)
	{
		$crm = $this->HighRiskResult->FismaSystem->getCrm($crm_id);
		$crm_id = $crm['AdAccount']['id'];
		$this->set('crm', $crm);
		$this->set('crm_id', $crm_id);
		
		$conditions = array();
		
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$conditions['HighRiskResult.reports_status_id'] = $reportsStatus_ids;
		
		if($fisma_system_id)
		{
			if (!$fisma_system = $this->HighRiskResult->FismaSystem->read(null, $fisma_system_id))
			{
				throw new NotFoundException(__('Invalid %s', __('FISMA System')));
			}
			$this->set('fisma_system', $fisma_system);
			
			if(!$scopedConditions = $this->HighRiskResult->conditionsforFismaSystem($fisma_system_id))
			{
				$this->paginate['empty'] = true;
			}
			
			$conditions = array_merge($conditions, $scopedConditions);
		}
		
		$this->paginate['conditions'] = $this->HighRiskResult->conditions($conditions, $this->passedArgs); 
		
		$this->HighRiskResult->recursive = 0;
		$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->HighRiskResult->find('count', array('conditions' => $this->paginate['conditions']));
		
		if($this->paginate['limit'])
			$high_risk_results = $this->paginate();
		else
			$high_risk_results = array();
		return $high_risk_results;
	}
	
	public function owner_actionable($fisma_system_id = false, $owner_id = false)
	{
		$owner = $this->HighRiskResult->FismaSystem->getOwner($owner_id);
		$owner_id = $owner['AdAccount']['id'];
		$this->set('owner', $owner);
		$this->set('owner_id', $owner_id);
		
		$conditions = array();
		
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->findforTable(true);
		$reportsStatus_ids = Hash::extract($reportsStatuses, '{n}.ReportsStatus.id');
		
		$conditions['HighRiskResult.reports_status_id'] = $reportsStatus_ids;
		
		if($fisma_system_id)
		{
			if (!$fisma_system = $this->HighRiskResult->FismaSystem->read(null, $fisma_system_id))
			{
				throw new NotFoundException(__('Invalid %s', __('FISMA System')));
			}
			$this->set('fisma_system', $fisma_system);
			
			if(!$scopedConditions = $this->HighRiskResult->conditionsforFismaSystem($fisma_system_id))
			{
				$this->paginate['empty'] = true;
			}
			
			$conditions = array_merge($conditions, $scopedConditions);
		}
		
		$this->paginate['conditions'] = $this->HighRiskResult->conditions($conditions, $this->passedArgs); 
		
		$this->HighRiskResult->recursive = 0;
		$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->HighRiskResult->find('count', array('conditions' => $this->paginate['conditions']));
		
		if($this->paginate['limit'])
			$high_risk_results = $this->paginate();
		else
			$high_risk_results = array();
		return $high_risk_results;
	}
	
	public function director_db_block_overview($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$high_riskResults = $this->HighRiskResult->listforDirector($ad_account_id, 'all', array('recursive' => 0));
		
		$high_riskResults = $this->HighRiskResult->dbOverviewUpdate($high_riskResults);
		
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->typeFormList();
		$this->set(compact('high_riskResults', 'reportsStatuses'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function director_db_tab_index($ad_account_id = false, $stripped = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		if(!$this->conditions = $this->HighRiskResult->listforDirector($ad_account_id, 'conditions'))
		{
			$this->paginate['empty'] = true;
		}
		
		return $this->db_tab_index($stripped);
	}
	
	public function db_block_overview()
	{
		$high_riskResults = $this->HighRiskResult->find('all', array('contain' => array('ReportsStatus')));
		
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->typeFormList();
		$this->set(compact(array('reportsStatuses')));
		
		foreach($high_riskResults as $i => $high_riskResult)
		{
			$high_riskResults[$i] = $this->HighRiskResult->attachFismaSystem($high_riskResult);
		}
		
		$this->set(compact('high_riskResults'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_desc()
	{
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_assignable_party_trend()
	{
		$snapshotStats = $this->HighRiskResult->snapshotDashboardGetStats('/^high_risk_result\.reports_assignable_party\-\d+$/');
		
		$this->set(compact('snapshotStats'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_remediation_trend()
	{
		$snapshotStats = $this->HighRiskResult->snapshotDashboardGetStats('/^high_risk_result\.reports_remediation\-\d+$/');
		
		$this->set(compact('snapshotStats'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_status_trend()
	{
		$snapshotStats = $this->HighRiskResult->snapshotDashboardGetStats('/^high_risk_result\.reports_status\-\d+$/');
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->find('list', array(
			'fields' => array('ReportsStatus.id', 'ReportsStatus.color_code_hex'),
		));
		
		$this->set(compact('snapshotStats', 'reportsStatuses'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_system_type_trend()
	{
		$snapshotStats = $this->HighRiskResult->snapshotDashboardGetStats('/^high_risk_result\.reports_system_type\-\d+$/');
		
		$this->set(compact('snapshotStats'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_verification_trend()
	{
		$snapshotStats = $this->HighRiskResult->snapshotDashboardGetStats('/^high_risk_result\.reports_verification\-\d+$/');
		
		$this->set(compact('snapshotStats'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_index($stripped = false)
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['HighRiskResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->paginate['conditions'] = $this->HighRiskResult->conditions($conditions, $this->passedArgs); 
		
		$this->HighRiskResult->recursive = 0;
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'HighRiskResult';
			
		if($stripped)
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->HighRiskResult->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities./ajax_nodebug';
		}
		
		$high_risk_results = $this->paginate($this->paginateModel);
		
		foreach($high_risk_results as $i => $high_risk_result)
		{
			$high_risk_results[$i] = $this->HighRiskResult->attachFismaSystem($high_risk_result);
		}
		$this->set('high_risk_results', $high_risk_results);
		$this->set('stripped', $stripped);
		$this->layout = 'Utilities.ajax_nodebug';
		return $this->render();
	}
	
	public function db_tab_change($timeAgo = false, $attrKey = false)
	{
		if(!$timeAgo)
			$timeAgo = '-10 minutes';
		if(!$attrKey)
			$attrKey = 'status';
		$timeAgo = date('Y-m-d H:i:s', strtotime($timeAgo));
		$conditions = ['HighRiskResult.'.$attrKey.'_date > ' => $timeAgo];
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->paginate['order'] = ['HighRiskResult.'.$attrKey.'_date' => 'ASC'];
		$this->set('stripped', true);
		return $this->db_tab_index(true);
	}
	
	public function db_tab_gssparent()
	{
		$fismaSystems = $this->HighRiskResult->FismaSystem->find('AllParents', array(
			'order' => array('FismaSystem.name' => 'ASC'),
		));
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			// get the children
			$this->HighRiskResult->FismaSystem->id = $fismaSystem['FismaSystem']['id'];
			$fismaSystemChildren = $this->HighRiskResult->FismaSystem->find('MyChildren');
			
			$fismaSystemIds = array($fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']);
			
			// get the children related vectors
			foreach($fismaSystemChildren as $j => $fismaSystemChild)
			{
				$fismaSystemIds[$fismaSystemChild['FismaSystem']['id']] = $fismaSystemChild['FismaSystem']['id'];
			}
			
			$conditionsHighRiskResult = $this->HighRiskResult->conditionsforFismaSystem($fismaSystemIds);
			
			if(!isset($conditionsHighRiskResult['OR']))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			if(!$highRiskResults = $this->HighRiskResult->find('all', array(
				'conditions' => $conditionsHighRiskResult,
			)))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			$fismaSystems[$i]['HighRiskResults'] = $highRiskResults;
		}
		
		$this->set(compact(array(
			'fismaSystems',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_totals($scope = 'org', $as_block = false)
	{
		$conditions = array();
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['HighRiskResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		
		$results = $this->scopedResults($scope, $conditions);
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->find('all');
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsStatuses',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_assignable_party($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsAssignableParties = $this->HighRiskResult->ReportsAssignableParty->typeFormList();
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsAssignableParties',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_remediation($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsRemediations = $this->HighRiskResult->ReportsRemediation->typeFormList();
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsRemediations',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_status($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->findforTable();
		
		$this->set(compact(array(
			'as_block', 'results',
			'reportsStatuses',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_system_type($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsSystemTypes = $this->HighRiskResult->ReportsSystemType->typeFormList();
		
		$this->set(compact(array(
			'as_block','results',
			'reportsSystemTypes',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_verification($scope = 'org', $as_block = false)
	{
		$results = $this->scopedResults($scope);
		
		$reportsVerifications = $this->HighRiskResult->ReportsVerification->typeFormList();
		
		$this->set(compact(array(
			'as_block','results',
			'reportsVerifications',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_trends()
	{
	}
	
	public function db_tab_trends_status($asTable = false)
	{
		$start = date('Y-m-d');
		
		$end = false;
		if($asTable)
			$end = date('Y-m-d', strtotime('-3 months', strtotime($start)));
		
		$snapshotStats = $this->HighRiskResult->snapshotDashboardGetStats('/^high_risk_result\.reports_status\-\d+$/', $start, $end);
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->find('list', array(
			'fields' => array('ReportsStatus.id', 'ReportsStatus.color_code_hex'),
			'conditions' => array(
				'ReportsStatus.show' => true,
			),
		));
		
		foreach($snapshotStats['legend'] as $i => $name)
		{
			$parts = explode('-', $i);
			if(isset($parts[1]))
			{
				if(!in_array($parts[1], array_keys($reportsStatuses)))
				{
					unset($snapshotStats['legend'][$i]);
				}
			}
		}
		foreach($snapshotStats['data'] as $date => $dateData)
		{
			foreach($dateData as $dataKey => $dataVal)
			{
				$parts = explode('-', $dataKey);
				if(isset($parts[1]))
				{
					if(!in_array($parts[1], array_keys($reportsStatuses)))
					{
						unset($snapshotStats['data'][$date][$dataKey]);
					}
				}
			}
		}
		
		$this->set(compact('snapshotStats', 'reportsStatuses', 'asTable'));
	}
	
	public function db_tab_trends_status_week($dow = false, $asTable = false)
	{
		if($dow === false)
			$dow = date('w');
		
		$start = date('Y-m-d');
		$startTime = strtotime($start);
		$end = date('Y-m-d', strtotime('-3 months', $startTime));
		
		$snapshotStats = $this->HighRiskResult->snapshotDashboardGetStats('/^high_risk_result\.reports_status\-\d+$/', $start, $end);
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->find('list', array(
			'fields' => array('ReportsStatus.id', 'ReportsStatus.color_code_hex'),
			'conditions' => array(
				'ReportsStatus.show' => true,
			),
		));
		
		foreach($snapshotStats['legend'] as $i => $name)
		{
			$parts = explode('-', $i);
			if(isset($parts[1]))
			{
				if(!in_array($parts[1], array_keys($reportsStatuses)))
				{
					unset($snapshotStats['legend'][$i]);
				}
			}
		}
		foreach($snapshotStats['data'] as $date => $dateData)
		{
			$currentDow = date('w', strtotime($date));
			if($currentDow != $dow)
			{
				unset($snapshotStats['data'][$date]);
				continue;
			}
			foreach($dateData as $dataKey => $dataVal)
			{
				$parts = explode('-', $dataKey);
				if(isset($parts[1]))
				{
					if(!in_array($parts[1], array_keys($reportsStatuses)))
					{
						unset($snapshotStats['data'][$date][$dataKey]);
					}
				}
			}
		}
		
		$this->set(compact('snapshotStats', 'reportsStatuses', 'asTable', 'dow'));
	}
	
	public function db_tab_breakout($scope = 'division', $as_block = false)
	{
		$conditions = array();
		
		$reportsStatusOpenId = $this->HighRiskResult->ReportsStatus->getOpenId();
		
		$reportsStatusName = __('All');
		$reportsStatusId = 0;
		if(isset($this->passedArgs['reports_status_id']))
		{
			if($this->passedArgs['reports_status_id'])
			{
				$conditions['HighRiskResult.reports_status_id']  = $this->passedArgs['reports_status_id'];
				$reportsStatusName = __('Status: %s', $this->HighRiskResult->ReportsStatus->field('name', array('ReportsStatus.id' => $this->passedArgs['reports_status_id'])));
				$reportsStatusId = $this->passedArgs['reports_status_id'];
			}
		}
		else
		{
			$conditions['HighRiskResult.reports_status_id'] = $reportsStatusOpenId;
			$reportsStatusName = __('Status: %s', __('Open'));
			$reportsStatusId = $reportsStatusOpenId;
		}
		
		$results = $this->scopedResults($scope, $conditions);
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->typeFormList();
		$this->set(compact(array(
			'as_block', 'results', 'scope', 
			'reportsStatusOpenId', 'reportsStatusId', 'reportsStatusName', 'reportsStatuses',
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
			foreach($result['HighRiskResults'] as $myResult_id => $myResult)
			{
				if(isset($myResult['HighRiskResult']['fisma_system_id']) and $myResult['HighRiskResult']['fisma_system_id'])
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
		
		$results = $this->HighRiskResult->find('all', array(
			'conditions' => array(
				'HighRiskResult.id' => array_keys($seenResults),
			),
		));
		
		foreach($results as $i => $result)
		{
			$result_id = $result['HighRiskResult']['id'];
			$results[$i]['crossovers'] = $seenResults[$result_id];
		}
		
		$this->set(compact(array(
			'as_block', 'results',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function search_results()
	{
		return $this->index();
	}
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'])
			$conditions['HighRiskResult.reports_status_id'] = $this->passedArgs['reports_status_id'];
		$conditions = array_merge($conditions, $this->conditions);
		
		if(isset($conditions['OR']) and !$conditions['OR'] and !in_array($this->action, array('index', 'admin_index')))
		{
			$this->paginate['empty'] = true;
		}
		
		$page_subtitle = (isset($this->viewVars['page_subtitle'])?$this->viewVars['page_subtitle']:__('All'));
		$page_description = (isset($this->viewVars['page_description'])?$this->viewVars['page_description']:'');
		
		$reportsAssignableParties = $this->HighRiskResult->ReportsAssignableParty->typeFormList();
		$reportsRemediations = $this->HighRiskResult->ReportsRemediation->typeFormList();
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->typeFormList();
		$reportsSystemTypes = $this->HighRiskResult->ReportsSystemType->typeFormList();
		$reportsVerifications = $this->HighRiskResult->ReportsVerification->typeFormList();
		$eolSoftwares = $this->HighRiskResult->EolSoftware->typeFormList();
		$multiselectOptions = $this->HighRiskResult->multiselectOptions(false, true);
		$fismaSystems = $this->HighRiskResult->FismaSystem->typeFormList();
		$this->set(compact(array(
			'reportsAssignableParties', 'reportsRemediations', 
			'reportsStatuses', 'reportsSystemTypes',
			'reportsVerifications', 'eolSoftwares', 'multiselectOptions', 
			'fismaSystems'
		)));
		
		if(isset($this->passedArgs['field']) and isset($this->passedArgs['value'])) 
		{
			$field = $this->passedArgs['field'];
			if(strpos($field, '.') === false)
				$field = 'HighRiskResult.'. $field;
			$conditions[$field] = $this->passedArgs['value'];
			
			if($this->passedArgs['field'] == 'reports_assignable_party_id' and isset($reportsAssignableParties[$this->passedArgs['value']]))
			{
				$reportsAssignableParty = $this->HighRiskResult->ReportsAssignableParty->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Assignable Party'), $reportsAssignableParty['ReportsAssignableParty']['name']);
				$page_description = $reportsAssignableParty['ReportsAssignableParty']['details'];
			}
			if($this->passedArgs['field'] == 'reports_remediation_id' and isset($reportsRemediations[$this->passedArgs['value']]))
			{
				$reportsRemediation = $this->HighRiskResult->ReportsRemediation->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Remediation'), $reportsRemediation['ReportsRemediation']['name']);
				$page_description = $reportsRemediation['ReportsRemediation']['details'];
			}
			if($this->passedArgs['field'] == 'reports_status_id' and isset($reportsStatuses[$this->passedArgs['value']]))
			{
				$reportsStatus = $this->HighRiskResult->ReportsStatus->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Status'), $reportsStatus['ReportsStatus']['name']);
				$page_description = $reportsStatus['ReportsStatus']['details'];
			}
			if($this->passedArgs['field'] == 'reports_system_type_id' and isset($reportsSystemTypes[$this->passedArgs['value']]))
			{
				$reportsSystemType = $this->HighRiskResult->ReportsSystemType->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('System Type'), $reportsSystemType['ReportsSystemType']['name']);
				$page_description = $reportsSystemType['ReportsSystemType']['details'];
			}
			if($this->passedArgs['field'] == 'reports_verification_id' and isset($reportsVerifications[$this->passedArgs['value']]))
			{
				$reportsVerification = $this->HighRiskResult->ReportsVerification->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Verification'), $reportsVerification['ReportsVerification']['name']);
				$page_description = $reportsVerification['ReportsVerification']['details'];
			}
		}
		
		$this->paginate['contain'] = array(
			'EolSoftware', 'FismaSystem',
			'ReportsAssignableParty', 'ReportsRemediation', 'ReportsStatus', 'ReportsVerification',
		);
		
		$this->paginate['conditions'] = $this->HighRiskResult->conditions($conditions, $this->passedArgs);
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->HighRiskResult->getCachedCounts('count', array('conditions' => $this->paginate['conditions']));
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities./ajax_nodebug';
		}
		
		$this->paginate['order'] = array('HighRiskResult.id' => 'DESC');
		
		
		//$this->Filter->Filter();
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'HighRiskResult';
		
		$high_risk_results = $this->paginate($this->paginateModel);
		
		foreach($high_risk_results as $i => $high_risk_result)
		{
			$high_risk_results[$i] = $this->HighRiskResult->attachFismaSystem($high_risk_result, true);
		}
		
		$this->set('high_risk_results', $high_risk_results);
		
		$this->set(compact(array('page_subtitle', 'page_description')));
	}
	
	public function orphans() 
	{
		$conditions = $this->HighRiskResult->orphanConditions();
		
		$page_subtitle = __('Not found in any current %s', __('FISMA System'), __('Inventories'));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function multiple_fisma_systems()
	{
		$conditions = $this->HighRiskResult->conditionsforMultipleFismaSystems();
		
		$page_subtitle = __('Found in multiple %s', __('FISMA Systems'));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function overridden()
	{
		$conditions = array(
			'HighRiskResult.fisma_system_id !=' => 0,
		);
		
		$page_subtitle = __('Results that have been Overridden');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function isso_open()
	{
		$openId = $this->HighRiskResult->ReportsStatus->getOpenId();
		
		$conditions = [
			'HighRiskResult.reports_status_id' => $openId,
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
		$openId = $this->HighRiskResult->ReportsStatus->getOpenId();
		
		$this->HighRiskResult->includeCounts = false;
		$results = $this->HighRiskResult->find('all', [
			'conditions' => [
				'HighRiskResult.reports_status_id' => $openId,
			],
		]);
		
		foreach($results as $i => $result)
		{
			$results[$i] = $this->HighRiskResult->attachFismaSystem($result);
		}
		
		$this->set(compact(['results']));
	}
	
	public function high_risk_report($id = null) 
	{
		if (!$high_risk_report = $this->HighRiskResult->HighRiskReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		$this->set('high_risk_report', $high_risk_report);
		
		$ids = $this->HighRiskResult->HighRiskReportHighRiskResult->find('list', array(
			'conditions' => array(
				'HighRiskReportHighRiskResult.high_risk_report_id' => $id,
			),
			'fields' => array('HighRiskReportHighRiskResult.high_risk_result_id', 'HighRiskReportHighRiskResult.high_risk_result_id'),
		));
		
		$conditions = array('HighRiskResult.id' => $ids);
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function eol_software($id = null) 
	{
		if (!$eol_software = $this->HighRiskResult->EolSoftware->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL/US Software')));
		}
		$this->set('eol_software', $eol_software);
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$conditions = array(
			'HighRiskResult.eol_software_id' => $id,
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
		
		$org = $this->HighRiskResult->FismaSystem->OwnerContact->Sac->Branch->Division->Org->find('first', array(
			'conditions' => array('Org.id' => $org_id),
		));
		if (!$org) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		$this->set('object', $org);
		
		$conditions = $this->HighRiskResult->scopedResults('org', array(), array('conditions' => array('Org.id' => $org_id)), true);
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
	
	public function division($division_id = null, $stripped = false)  
	{
		if (!$division_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		
		$division = $this->HighRiskResult->FismaSystem->OwnerContact->Sac->Branch->Division->find('first', array(
			'conditions' => array('Division.id' => $division_id),
			'contain' => array('Org'),
		));
		if (!$division) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		$this->set('object', $division);
		
		$conditions = $this->HighRiskResult->scopedResults('division', array(), array('conditions' => array('Division.id' => $division_id)), true);
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
	
	public function branch($branch_id = null, $stripped = false)  
	{
		if (!$branch_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		
		$branch = $this->HighRiskResult->FismaSystem->OwnerContact->Sac->Branch->find('first', array(
			'conditions' => array('Branch.id' => $branch_id),
			'contain' => array('Division', 'Division.Org'),
		));
		if (!$branch) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		$this->set('object', $branch);
		
		$conditions = $this->HighRiskResult->scopedResults('branch', array(), array('conditions' => array('Branch.id' => $branch_id)), true);
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
		
		$sac = $this->HighRiskResult->FismaSystem->OwnerContact->Sac->find('first', array(
			'conditions' => array('Sac.id' => $sac_id),
			'contain' => array('Branch', 'Branch.Division', 'Branch.Division.Org'),
		));
		if (!$sac) 
		{
			throw new NotFoundException(__('Invalid %s', __('SAC')));
		}
		$this->set('object', $sac);
		
		$conditions = $this->HighRiskResult->scopedResults('sac', array(), array('conditions' => array('Sac.id' => $sac_id)), true);
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
		
		$ownerContact = $this->HighRiskResult->FismaSystem->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $owner_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		$ownerContact['AdAccount'] = $ownerContact['OwnerContact'];
		if (!$ownerContact) 
		{
			throw new NotFoundException(__('Invalid %s', __('Contact')));
		}
		$this->set('object', $ownerContact);
		
		$conditions = $this->HighRiskResult->scopedResults('owner', array(), array('conditions' => array('OwnerContact.id' => $owner_id)), true);
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
		
		$crm = $this->HighRiskResult->FismaSystem->OwnerContact->find('first', array(
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
		if($fismaSystem_ids = $this->HighRiskResult->FismaSystem->idsForCrm($crm_id))
		{
			$conditions = $this->HighRiskResult->scopedResults('crm', array(), array(
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
	
	public function fisma_system($id = null, $reports_status_id = false, $stripped = false) 
	{
		if (!$fisma_system = $this->HighRiskResult->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		$this->set('fisma_system', $fisma_system);
		
		$page_subtitle = __('All Results for %s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name']);
		$page_description = '';
		
		$conditions = array();
		
		if($reports_status_id)
		{
			$reportsStatus = $this->HighRiskResult->ReportsStatus->read(null, $reports_status_id);
			$page_subtitle = __('Results for %s: %s - with %s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name'], __('Status'), $reportsStatus['ReportsStatus']['name']);
			$conditions['HighRiskResult.reports_status_id'] = $reports_status_id;
		}
			
		if(!$scopedConditions = $this->HighRiskResult->conditionsforFismaSystem($id))
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
		if (!$fisma_inventory = $this->HighRiskResult->SubnetMember->FismaInventory->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		$this->set('fisma_inventory', $fisma_inventory);
		
		$conditions = $this->HighRiskResult->conditionsforInventory($fisma_inventory);
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
		if (!$fov_result = $this->HighRiskResult->FismaSystem->FovResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Result')));
		}
		$this->set('fov_result', $fov_result);
		
		$conditions = $this->HighRiskResult->conditionsforResult('FovResult', $fov_result);
		$result_name = $this->HighRiskResult->nameForResult('FovResult', $fov_result);
		
		$page_subtitle = __('%s: %s', __('FOV Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function us_result($id = null) 
	{
		if (!$us_result = $this->HighRiskResult->SubnetMember->UsResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		$this->set('us_result', $us_result);
		
		$conditions = $this->HighRiskResult->conditionsforResult('UsResult', $us_result);
		$result_name = $this->HighRiskResult->nameForResult('UsResult', $us_result);
		
		$page_subtitle = __('%s: %s', __('US Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function eol_result($id = null) 
	{
		if (!$eol_result = $this->HighRiskResult->SubnetMember->EolResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Result')));
		}
		$this->set('eol_result', $eol_result);
		
		$conditions = $this->HighRiskResult->conditionsforResult('EolResult', $eol_result);
		$result_name = $this->HighRiskResult->nameForResult('EolResult', $eol_result);
		
		$page_subtitle = __('%s: %s', __('EOL Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function pen_test_result($id = null) 
	{
		if (!$pen_test_result = $this->HighRiskResult->SubnetMember->PenTestResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Pen Test Result')));
		}
		$this->set('pen_test_result', $pen_test_result);
		
		$conditions = $this->HighRiskResult->conditionsforResult('PenTestResult', $pen_test_result);
		$result_name = $this->HighRiskResult->nameForResult('PenTestResult', $pen_test_result);
		
		$page_subtitle = __('%s: %s', __('Pen Test Result'), $result_name);
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function high_risk_result($id = null) 
	{
		if (!$high_risk_result = $this->HighRiskResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		$this->set('high_risk_result', $high_risk_result);
		
		$conditions = $this->HighRiskResult->conditionsforResult('HighRiskResult', $high_risk_result);
		$result_name = $this->HighRiskResult->nameForResult('HighRiskResult', $high_risk_result);
		
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
		
		$tag = $this->HighRiskResult->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$conditions = array();
		
		$conditions[] = $this->HighRiskResult->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'HighRiskResult');
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function view($id = false)
	{
		$this->HighRiskResult->id = $id;
		$this->HighRiskResult->recursive = 0;
		if (!$high_risk_result = $this->HighRiskResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		
		$high_risk_result = $this->HighRiskResult->attachFismaSystem($high_risk_result);
			
		$this->set('high_risk_result', $high_risk_result);
	}
	
	public function edit($id = null)
	{
		$this->HighRiskResult->id = $id;
		$this->HighRiskResult->recursive = 1;
		$this->HighRiskResult->contain(array('Tag'));
		if (!$high_risk_result = $this->HighRiskResult->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['HighRiskResult']['modified_user_id'] = AuthComponent::user('id');
			if ($this->HighRiskResult->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('High Risk Result')));
				return $this->redirect(array('action' => 'view', $this->HighRiskResult->id));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('High Risk Result')));
			}
		}
		else
		{
			$this->request->data = $high_risk_result;
		}
		
		$reportsAssignableParties = $this->HighRiskResult->ReportsAssignableParty->typeFormListBlank();
		$reportsRemediations = $this->HighRiskResult->ReportsRemediation->typeFormListBlank();
		$reportsStatuses = $this->HighRiskResult->ReportsStatus->typeFormListBlank();
		$reportsSystemTypes = $this->HighRiskResult->ReportsSystemType->typeFormListBlank();
		$reportsVerifications = $this->HighRiskResult->ReportsVerification->typeFormListBlank();
		$eolSoftwares = $this->HighRiskResult->EolSoftware->typeFormList();
		$fismaSystems = $this->HighRiskResult->FismaSystem->typeFormList();
		$multiselectOptions = $this->HighRiskResult->multiselectOptions(false, true);
		$this->set(compact(array(
			'reportsAssignableParties', 'reportsRemediations', 
			'reportsStatuses', 'reportsSystemTypes',
			'reportsVerifications', 'eolSoftwares', 'fismaSystems', 'multiselectOptions'
		)));
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
		$this->HighRiskResult->id = $id;
		if (!$this->HighRiskResult->exists()) {
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		if ($this->HighRiskResult->delete()) {
			$this->Flash->success(__('%s deleted', __('High Risk Result')));
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}
		$this->Flash->error(__('%s was not deleted', __('High Risk Result')));
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
}