<?php
App::uses('AppController', 'Controller');

class PoamResultsController extends AppController 
{
	public $cacheAction = array(
	    'db_block_overview' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_block_status_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		
	    'db_tab_index' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		'db_tab_gssparent' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true),
		
		'db_tab_totals' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_tab_criticality' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_block_criticality_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_tab_risk' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_block_risk_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_tab_severity' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_block_severity_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_tab_status' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		'db_block_status_trend' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('org', 1), array('division', 1), array('system', 2)) ),
		
		'db_tab_breakout' => array('callbacks' => true, 'duration' => '1 day', 'recache' => true, 'urls' => array(array('division', 1), array('division', 0)) ),
	);
	
	public $subscriptions = [
		'isso_open_counts',
	];
	
	public function menu_criticalities() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->PoamResult->PoamCriticality->typeFormListOrder = array('name' => 'ASC');
		$poamCriticalities = $this->PoamResult->PoamCriticality->typeFormList();
		
		foreach($poamCriticalities as $poamCriticality_id => $poamCriticality_name)
		{
			$title = $poamCriticality_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'poam_results', 'action' => 'index', 'poam_criticality_id' => $poamCriticality_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function menu_risks() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->PoamResult->PoamRisk->typeFormListOrder = array('name' => 'ASC');
		$poamRisks = $this->PoamResult->PoamRisk->typeFormList();
		
		foreach($poamRisks as $poamRisk_id => $poamRisk_name)
		{
			$title = $poamRisk_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'poam_results', 'action' => 'index', 'poam_risk_id' => $poamRisk_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
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
		$items = array();
		$this->PoamResult->PoamSeverity->typeFormListOrder = array('name' => 'ASC');
		$poamSeverities = $this->PoamResult->PoamSeverity->typeFormList();
		
		foreach($poamSeverities as $poamSeverity_id => $poamSeverity_name)
		{
			$title = $poamSeverity_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'poam_results', 'action' => 'index', 'poam_severity_id' => $poamSeverity_id, 'admin' => false, 'saa' => false, 'plugin' => false)
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
		$this->PoamResult->PoamStatus->typeFormListOrder = array('name' => 'ASC');
		$poamStatuses = $this->PoamResult->PoamStatus->typeFormList();
		
		foreach($poamStatuses as $poamStatus_id => $poamStatus_name)
		{
			$title = $poamStatus_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'poam_results', 'action' => 'index', 'poam_status_id' => $poamStatus_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function crm_actionable($fisma_system_id = false, $crm_id = false)
	{
		$crm = $this->PoamResult->FismaSystem->getCrm($crm_id);
		$crm_id = $crm['AdAccount']['id'];
		$this->set('crm', $crm);
		$this->set('crm_id', $crm_id);
		
		$conditions = array();
		
		$poamStatuses = $this->PoamResult->PoamStatus->findforTable(true);
		$poamStatus_ids = Hash::extract($poamStatuses, '{n}.PoamStatus.id');
		
		$conditions['PoamResult.poam_status_id'] = $poamStatus_ids;
		
		if($fisma_system_id)
			$conditions['PoamResult.fisma_system_id'] = $poamStatus_ids;
		
		$this->paginate['conditions'] = $this->PoamResult->conditions($conditions, $this->passedArgs); 
		
		$this->PoamResult->recursive = 0;
		$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->PoamResult->find('count', array('conditions' => $this->paginate['conditions']));
		
		if($this->paginate['limit'])
			$poamResults = $this->paginate();
		else
			$poamResults = array();
		return $poamResults;
	}
	
	public function director_db_block_overview($ad_account_id = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		$poamResults = $this->PoamResult->listforDirector($ad_account_id, 'all', array('recursive' => 0));
		
		$poamResults = $this->PoamResult->dbOverviewUpdate($poamResults);
		
		$poamStatuses = $this->PoamResult->PoamStatus->typeFormList();
		$this->set(compact('poamResults', 'poamStatuses'));
		
	}
	
	public function director_db_tab_index($ad_account_id = false, $stripped = false)
	{
		if(!$ad_account_id)
			$ad_account_id = AuthComponent::user('ad_account_id');
		$this->set('ad_account_id', $ad_account_id);
		
		if(!$this->conditions = $this->PoamResult->listforDirector($ad_account_id, 'conditions'))
		{
			$this->paginate['empty'] = true;
		}
		
		return $this->db_tab_index($stripped);
	}
	
	public function db_block_overview()
	{	
		$poamResults = $this->PoamResult->find('all', ['contain' => ['PoamStatus', 'FismaSystem']]);
		
		$poamStatuses = $this->PoamResult->PoamStatus->typeFormList();
		$this->set(compact('poamResults', 'poamStatuses'));
		
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_index($stripped = false)
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		if(isset($this->passedArgs['poam_status_id']) and $this->passedArgs['poam_status_id'])
			$conditions['PoamResult.poam_status_id'] = $this->passedArgs['poam_status_id'];
		$conditions = array_merge($conditions, $this->conditions);
		
		if(isset($conditions['OR']) and !$conditions['OR'] and !in_array($this->action, ['db_tab_index']))
		{
			$this->paginate['empty'] = true;
		}
		
		$this->paginate['contain'] = $this->PoamResult->containOverride;
		$this->paginate['conditions'] = $this->PoamResult->conditions($conditions, $this->passedArgs); 
		
		if($stripped)
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->PoamResult->find('count', ['conditions' => $this->paginate['conditions']]);
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
		}
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'PoamResult';
		
		$poamResults = $this->paginate($this->paginateModel);
		
		$this->set('poamResults', $poamResults);
		$this->set('stripped', $stripped);
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_gssparent()
	{
		$fismaSystems = $this->PoamResult->FismaSystem->find('AllParents', [
			'order' => ['FismaSystem.name' => 'ASC'],
		]);
		
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			// get the children
			$this->PoamResult->FismaSystem->id = $fismaSystem['FismaSystem']['id'];
			$fismaSystemChildren = $this->PoamResult->FismaSystem->find('MyChildren');
			
			$fismaSystemIds = array($fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']);
			
			// get the children related vectors
			foreach($fismaSystemChildren as $j => $fismaSystemChild)
			{
				$fismaSystemIds[$fismaSystemChild['FismaSystem']['id']] = $fismaSystemChild['FismaSystem']['id'];
			}
			
			if(!$poamResults = $this->PoamResult->find('all', [
				'conditions' => ['PoamResult.fisma_system_id' => $fismaSystemIds],
			]))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			$fismaSystems[$i]['PoamResults'] = $poamResults;
		}
		
		$this->set(compact([
			'fismaSystems',
		]));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_breakout($scope = 'division', $as_block = false)
	{

		$scopes = $this->PoamResult->scopes();
		$scopeName = $this->PoamResult->scopeName($scope);
		
		$conditions = array();
		
		$poamStatusName = __('All');
		$poamStatusId = 0;
		if(isset($this->passedArgs['poam_status_id']))
		{
			if($this->passedArgs['poam_status_id'])
			{
				$conditions['PoamResult.poam_status_id']  = $this->passedArgs['poam_status_id'];
				$poamStatusName = __('Status: %s', $this->PoamResult->PoamStatus->field('name', array('PoamStatus.id' => $this->passedArgs['poam_status_id'])));
				$poamStatusId = $this->passedArgs['poam_status_id'];
			}
		}
		
		$results = $this->PoamResult->scopedResults($scope, $conditions);
		$poamStatuses = $this->PoamResult->PoamStatus->typeFormList();
		$this->set(compact(array(
			'as_block', 'results', 'scope', 'scopes', 'scopeName',  
			'poamStatusId', 'poamStatusName', 'poamStatuses',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_totals($scope = 'org', $as_block = false)
	{
		$scopes = $this->PoamResult->scopes();
		$scopeName = $this->PoamResult->scopeName($scope);
		
		$conditions = array();
		if(isset($this->passedArgs['poam_status_id']) and $this->passedArgs['poam_status_id'])
			$conditions['PoamResult.poam_status_id'] = $this->passedArgs['poam_status_id'];
		
		$results = $this->PoamResult->scopedResults($scope, $conditions);
		$poamStatuses = $this->PoamResult->PoamStatus->find('all');
		
		$this->set(compact(array(
			'as_block', 'results', 'scope', 'scopes', 'scopeName', 
			'poamStatuses',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_criticality($scope = 'org', $as_block = false)
	{
		$attrName = __('Criticality');
		$scopes = $this->PoamResult->scopes();
		$scopeName = $this->PoamResult->scopeName($scope);
		
		$results = $this->PoamResult->scopedResults($scope);
		
		$poamAttributes = $this->PoamResult->PoamCriticality->findforTable();
		$poamAttrKey = 'PoamCriticality';
		$poamAttrField = 'poam_criticality_id';
		
		$this->set(compact(array(
			'scope', 'scopes', 'scopeName', 'as_block', 'results',
			'poamAttributes', 'poamAttrKey', 'poamAttrField', 'attrName',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_criticality_trend()
	{
		$attrName = __('Criticality');
		$snapshotStats = $this->PoamResult->snapshotDashboardGetStats('/^poam_result\.poam_criticality\-\d+$/');
		$poamAttributes = $this->PoamResult->PoamCriticality->find('list', array(
			'fields' => array('PoamCriticality.id', 'PoamCriticality.color_code_hex'),
		));
		
		$this->set(compact('snapshotStats', 'poamAttributes', 'attrName'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_risk($scope = 'org', $as_block = false)
	{
		$attrName = __('Risk');
		$scopes = $this->PoamResult->scopes();
		$scopeName = $this->PoamResult->scopeName($scope);
		
		$results = $this->PoamResult->scopedResults($scope);
		
		$poamAttributes = $this->PoamResult->PoamRisk->findforTable();
		$poamAttrKey = 'PoamRisk';
		$poamAttrField = 'poam_risk_id';
		
		$this->set(compact(array(
			'scope', 'scopes', 'scopeName', 'as_block', 'results',
			'poamAttributes', 'poamAttrKey', 'poamAttrField', 'attrName',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_risk_trend()
	{
		$attrName = __('Risk');
		$snapshotStats = $this->PoamResult->snapshotDashboardGetStats('/^poam_result\.poam_risk\-\d+$/');
		$poamAttributes = $this->PoamResult->PoamRisk->find('list', array(
			'fields' => array('PoamRisk.id', 'PoamRisk.color_code_hex'),
		));
		
		$this->set(compact('snapshotStats', 'poamAttributes', 'attrName'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_severity($scope = 'org', $as_block = false)
	{
		$attrName = __('Severity');
		$scopes = $this->PoamResult->scopes();
		$scopeName = $this->PoamResult->scopeName($scope);
		
		$results = $this->PoamResult->scopedResults($scope);
		
		$poamAttributes = $this->PoamResult->PoamSeverity->findforTable();
		$poamAttrKey = 'PoamSeverity';
		$poamAttrField = 'poam_severity_id';
		
		$this->set(compact(array(
			'scope', 'scopes', 'scopeName', 'as_block', 'results',
			'poamAttributes', 'poamAttrKey', 'poamAttrField', 'attrName',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_severity_trend()
	{
		$attrName = __('Severity');
		$snapshotStats = $this->PoamResult->snapshotDashboardGetStats('/^poam_result\.poam_severity\-\d+$/');
		$poamAttributes = $this->PoamResult->PoamSeverity->find('list', array(
			'fields' => array('PoamSeverity.id', 'PoamSeverity.color_code_hex'),
		));
		
		$this->set(compact('snapshotStats', 'poamAttributes', 'attrName'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_tab_status($scope = 'org', $as_block = false)
	{
		$attrName = __('Status');
		$scopes = $this->PoamResult->scopes();
		$scopeName = $this->PoamResult->scopeName($scope);
		
		$results = $this->PoamResult->scopedResults($scope);
		
		$poamAttributes = $this->PoamResult->PoamStatus->findforTable();
		$poamAttrKey = 'PoamStatus';
		$poamAttrField = 'poam_status_id';
		
		$this->set(compact(array(
			'scope', 'scopes', 'scopeName', 'as_block', 'results',
			'poamAttributes', 'poamAttrKey', 'poamAttrField', 'attrName',
		)));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function db_block_status_trend()
	{
		$attrName = __('Status');
		$snapshotStats = $this->PoamResult->snapshotDashboardGetStats('/^poam_result\.poam_status\-\d+$/');
		$poamAttributes = $this->PoamResult->PoamStatus->find('list', array(
			'fields' => array('PoamStatus.id', 'PoamStatus.color_code_hex'),
		));
		
		$this->set(compact('snapshotStats', 'poamAttributes', 'attrName'));
		$this->layout = 'Utilities.ajax_nodebug';
	}
	
	public function search_results()
	{
		return $this->index();
	}
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$poamCriticalities = $this->PoamResult->PoamCriticality->typeFormList();
		$poamRisks = $this->PoamResult->PoamRisk->typeFormList();
		$poamSeverities = $this->PoamResult->PoamSeverity->typeFormList();
		$poamStatuses = $this->PoamResult->PoamStatus->typeFormList();
		$this->set(compact([
			'poamCriticalities', 'poamRisks', 'poamSeverities', 'poamStatuses',
		]));
		
		$page_subtitle = __('All');
		$page_subtitle2 = false;
		$conditions = [];
		if(isset($this->passedArgs['poam_criticality_id']) and $this->passedArgs['poam_criticality_id'])
		{
			$page_subtitle2 = __('With %s: %s', __('Criticality'), (isset($poamCriticalities[$this->passedArgs['poam_criticality_id']])?$poamCriticalities[$this->passedArgs['poam_criticality_id']]:''));
			$conditions['PoamResult.poam_criticality_id'] = $this->passedArgs['poam_criticality_id'];
		}
		if(isset($this->passedArgs['poam_risk_id']) and $this->passedArgs['poam_risk_id'])
		{
			$page_subtitle2 = __('With %s: %s', __('Risk'), (isset($poamRisks[$this->passedArgs['poam_risk_id']])?$poamRisks[$this->passedArgs['poam_risk_id']]:''));
			$conditions['PoamResult.poam_risk_id'] = $this->passedArgs['poam_risk_id'];
		}
		if(isset($this->passedArgs['poam_severity_id']) and $this->passedArgs['poam_severity_id'])
		{
			$page_subtitle2 = __('With %s: %s', __('Severity'), (isset($poamSeverities[$this->passedArgs['poam_severity_id']])?$poamSeverities[$this->passedArgs['poam_severity_id']]:''));
			$conditions['PoamResult.poam_severity_id'] = $this->passedArgs['poam_severity_id'];
		}
		if(isset($this->passedArgs['poam_status_id']) and $this->passedArgs['poam_status_id'])
		{
			$page_subtitle2 = __('With %s: %s', __('Status'), (isset($poamStatuses[$this->passedArgs['poam_status_id']])?$poamStatuses[$this->passedArgs['poam_status_id']]:''));
			$conditions['PoamResult.poam_status_id'] = $this->passedArgs['poam_status_id'];
		}
		$conditions = array_merge($conditions, $this->conditions);
		
		$page_subtitle = (isset($this->viewVars['page_subtitle'])?$this->viewVars['page_subtitle']:$page_subtitle);
		$page_description = (isset($this->viewVars['page_description'])?$this->viewVars['page_description']:'');
		
		if(isset($this->passedArgs['field']) and isset($this->passedArgs['value'])) 
		{
			$field = $this->passedArgs['field'];
			if(strpos($field, '.') === false)
				$field = 'PoamResult.'. $field;
			$conditions[$field] = $this->passedArgs['value'];
			
			if($this->passedArgs['field'] == 'poam_status_id' and isset($poamStatuses[$this->passedArgs['value']]))
			{
				$poamStatus = $this->PoamResult->PoamStatus->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Status'), $poamStatus['PoamStatus']['name']);
				$page_description = $poamStatus['PoamStatus']['details'];
			}
		}
		
		$this->paginate['conditions'] = $this->PoamResult->conditions($conditions, $this->passedArgs);
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->PoamResult->find('count', ['conditions' => $this->paginate['conditions']]);
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'PoamResult';
		
		$this->paginate['contain'] = $this->PoamResult->containOverride;
		
		$poamResults = $this->paginate($this->paginateModel);
		
		foreach($poamResults as $i => $poamResult)
		{
			$poamResults[$i]['FismaSystem']['techPocs'] = $this->PoamResult->FismaSystem->AdAccountFismaSystem->getTechs($poamResults[$i]['FismaSystem']['id']);
		}
		
		$this->set('poamResults', $poamResults);
		
		$this->set(compact(['page_subtitle', 'page_subtitle2', 'page_description']));
	}
	
	public function orphans() 
	{
		$conditions = $this->PoamResult->orphanConditions();
		
		$page_subtitle = __('Not in a %s', __('FISMA System'));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function auto_closed($closed = false) 
	{
		$conditions = array(
			'PoamResult.auto_closed' => ($closed?true:false)
		);
		
		$page_subtitle = __('Auto Closed: %s', ($closed?__('Yes'):__('No')));
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function isso_open() 
	{
		$conditions = [];
		$conditions['PoamResult.auto_closed'] = 0;
		$conditions['PoamCriticality.show'] = true;
		$conditions['PoamRisk.show'] = true;
		$conditions['PoamSeverity.show'] = true;
		$conditions['PoamStatus.show'] = true;
		$this->PoamResult->includeCounts = false;
		
		$page_subtitle = __('Considered Open');
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function isso_open_counts($ad_account_id = false)
	{
		$conditions = [];
		$conditions['PoamResult.auto_closed'] = 0;
		$conditions['PoamCriticality.show'] = true;
		$conditions['PoamRisk.show'] = true;
		$conditions['PoamSeverity.show'] = true;
		$conditions['PoamStatus.show'] = true;
		$this->PoamResult->includeCounts = false;
		$results = $this->PoamResult->find('all', [
			'contain' => [
				'PoamCriticality', 'PoamRisk', 'PoamSeverity', 'PoamStatus',
				'FismaSystem.OwnerContact.Sac.Branch.Division.Org'
			],
			'conditions' => $conditions,
		]);
		
		$this->set(compact(['results']));
	}
	
	public function poam_report($id = null) 
	{
		if (!$poamReport = $this->PoamResult->PoamReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Report')));
		}
		$this->set('poamReport', $poamReport);
		
		$this->PoamResult->PoamReportPoamResult->recursive = -1;
		$poamResultIds = $this->PoamResult->PoamReportPoamResult->find('list', array(
			'conditions' => array(
				'PoamReportPoamResult.poam_report_id' => $id,
			),
			'fields' => array('PoamReportPoamResult.poam_result_id', 'PoamReportPoamResult.poam_result_id'),
		));
		$conditions = array(
			'PoamResult.id' => $poamResultIds,
		);
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function org($org_id = null, $stripped = false)  
	{
		if (!$org_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		
		$org = $this->PoamResult->FismaSystem->OwnerContact->Sac->Branch->Division->Org->find('first', array(
			'conditions' => array('Org.id' => $org_id),
		));
		if (!$org) 
		{
			throw new NotFoundException(__('Invalid %s', __('ORG/IC')));
		}
		$this->set('object', $org);
		
		$fismaSystem_ids = $this->PoamResult->FismaSystem->idsForOrg($org_id);
		
		$conditions = array('PoamResult.fisma_system_id' => $fismaSystem_ids);
		$conditions = array_merge($conditions, $this->conditions);
		
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
		
		$division = $this->PoamResult->FismaSystem->OwnerContact->Sac->Branch->Division->find('first', array(
			'conditions' => array('Division.id' => $division_id),
			'contain' => array('Org'),
		));
		if (!$division) 
		{
			throw new NotFoundException(__('Invalid %s', __('Division')));
		}
		$this->set('object', $division);
		
		$fismaSystem_ids = $this->PoamResult->FismaSystem->idsForDivision($division_id);
		
		$conditions = array('PoamResult.fisma_system_id' => $fismaSystem_ids);
		$conditions = array_merge($conditions, $this->conditions);
		
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
		
		$branch = $this->PoamResult->FismaSystem->OwnerContact->Sac->Branch->find('first', array(
			'conditions' => array('Branch.id' => $branch_id),
			'contain' => array('Division', 'Division.Org'),
		));
		if (!$branch) 
		{
			throw new NotFoundException(__('Invalid %s', __('Branch')));
		}
		$this->set('object', $branch);
		
		$fismaSystem_ids = $this->PoamResult->FismaSystem->idsForBranch($branch_id);
		
		$conditions = array('PoamResult.fisma_system_id' => $fismaSystem_ids);
		$conditions = array_merge($conditions, $this->conditions);
		
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
		
		$sac = $this->PoamResult->FismaSystem->OwnerContact->Sac->find('first', array(
			'conditions' => array('Sac.id' => $sac_id),
			'contain' => array('Branch', 'Branch.Division', 'Branch.Division.Org'),
		));
		if (!$sac) 
		{
			throw new NotFoundException(__('Invalid %s', __('SAC')));
		}
		$this->set('object', $sac);
		
		$fismaSystem_ids = $this->PoamResult->FismaSystem->idsForSac($sac_id);
		
		$conditions = array('PoamResult.fisma_system_id' => $fismaSystem_ids);
		$conditions = array_merge($conditions, $this->conditions);
		
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
		
		$ownerContact = $this->PoamResult->FismaSystem->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $owner_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		$ownerContact['AdAccount'] = $ownerContact['OwnerContact'];
		if (!$ownerContact) 
		{
			throw new NotFoundException(__('Invalid %s', __('Contact')));
		}
		$this->set('object', $ownerContact);
		
		$fismaSystem_ids = $this->PoamResult->FismaSystem->idsForOwner($owner_id);
		
		$conditions = array('PoamResult.fisma_system_id' => $fismaSystem_ids);
		$conditions = array_merge($conditions, $this->conditions);
		
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
		
		$crm = $this->PoamResult->FismaSystem->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $crm_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		$crm['AdAccount'] = $crm['OwnerContact'];
		if (!$crm) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		$this->set('object', $crm);
		
		$fismaSystem_ids = $this->PoamResult->FismaSystem->idsForCrm($crm_id);
		
		$conditions = array('PoamResult.fisma_system_id' => $fismaSystem_ids);
		$conditions = array_merge($conditions, $this->conditions);
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function fisma_system($id = null, $poam_status_id = false, $stripped = false) 
	{
		if (!$fisma_system = $this->PoamResult->FismaSystem->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		$this->set('fisma_system', $fisma_system);
		
		$page_subtitle = __('Results for %s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name']);
		$page_description = '';
		
		$conditions = array('PoamResult.fisma_system_id' => $id);
		
		if($poam_status_id)
		{
			$poamStatus = $this->PoamResult->PoamStatus->read(null, $poam_status_id);
			$page_subtitle = __('Results for %s: %s - with %s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name'], __('Status'), $poamStatus['PoamStatus']['name']);
			$conditions['PoamResult.poam_status_id'] = $poam_status_id;
		}
			
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->set('stripped', $stripped);
		
		if($stripped)
			return $this->db_tab_index($stripped);
		else
			return $this->index();
	}
	
	public function tag($tag_id = null) 
	{
		if(!$tag_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		
		$tag = $this->PoamResult->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$conditions = array();
		
		$conditions[] = $this->PoamResult->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'PoamResult');
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function view($id = false)
	{
		$this->PoamResult->id = $id;
		$this->PoamResult->recursive = 0;
		$this->PoamResult->contain($this->PoamResult->containOverride);
		if (!$poamResult = $this->PoamResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Result')));
		}
			
		$this->set('poamResult', $poamResult);
	}
	
	public function edit($id = null)
	{
		$this->PoamResult->id = $id;
		$this->PoamResult->recursive = 1;
		$this->PoamResult->contain(array('Tag'));
		if (!$poamResult = $this->PoamResult->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Result')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['PoamResult']['modified_user_id'] = AuthComponent::user('id');
			if ($this->PoamResult->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Result')));
				return $this->redirect(array('action' => 'view', $this->PoamResult->id));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Result')));
			}
		}
		else
		{
			$this->request->data = $poamResult;
		}
		
		$poamStatuses = $this->PoamResult->PoamStatus->typeFormListBlank();
		$fismaSystems = $this->PoamResult->FismaSystem->typeFormList();
		$this->set(compact(array('poamStatuses', 'fismaSystems')));
	}
	
	public function autoclose() 
	{
		if($results = $this->PoamResult->autoClose())
		{
			$this->Flash->success(__('%s %s were auto closed.', $results, __('POA&M Results')));
			return $this->redirect(array('action' => 'index'));
		}
		
		$possibleError = false;
		if($this->PoamResult->modelError)
			$possibleError = __('Error: %s', $this->PoamResult->modelError);
		$this->Flash->error(__('NO %s were auto closed. %s', __('POA&M Results'), $possibleError));
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
		$this->PoamResult->id = $id;
		if (!$this->PoamResult->exists()) {
			throw new NotFoundException(__('Invalid %s', __('POA&M Result')));
		}
		if ($this->PoamResult->delete()) {
			$this->Flash->success(__('%s deleted', __('POA&M Result')));
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}
		$this->Flash->error(__('%s was not deleted', __('POA&M Result')));
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
}