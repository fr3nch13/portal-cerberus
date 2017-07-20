<?php

$page_options_title2 = (isset($page_options_title2)?$page_options_title2:false);
$page_options2 = (isset($page_options2)?$page_options2:array());

$prefix = false;
if(isset($this->request->params['prefix']) and $this->request->params['prefix'])
	$prefix = $this->request->params['prefix'];
$ad_account_id = (isset($ad_account_id)?$ad_account_id:false);

$dashboard_blocks = array(
	'fisma_systems_overview' => array('prefix' => $prefix, 'controller' => 'fisma_systems', 'action' => 'db_block_overview', $ad_account_id, 'plugin' => false),
	'us_results_overview' => array('prefix' => $prefix, 'controller' => 'us_results', 'action' => 'db_block_overview', $ad_account_id, 'plugin' => false),
	'eol_results_overview' => array('prefix' => $prefix, 'controller' => 'eol_results', 'action' => 'db_block_overview', $ad_account_id, 'plugin' => false),
	'pen_test_results_overview' => array('prefix' => $prefix, 'controller' => 'pen_test_results', 'action' => 'db_block_overview', $ad_account_id, 'plugin' => false),
	'high_risk_results_overview' => array('prefix' => $prefix, 'controller' => 'high_risk_results', 'action' => 'db_block_overview', $ad_account_id, 'plugin' => false),
//	'rules_overview' => array('prefix' => false, 'controller' => 'rules', 'action' => 'db_block_overview'),
);

$tabs = array();

$tabs['fisma_systems'] = array(
	'id' => 'fisma_systems',
	'name' => __('Fisma Systems'), 
	'ajax_url' => array('prefix' => $prefix, 'controller' => 'fisma_systems', 'action' => 'db_tab_index', $ad_account_id, 'plugin' => false),
);
$tabs['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => array('prefix' => $prefix, 'controller' => 'us_results', 'action' => 'db_tab_index', $ad_account_id, 'plugin' => false),
);
$tabs['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => array('prefix' => $prefix, 'controller' => 'eol_results', 'action' => 'db_tab_index', $ad_account_id, 'plugin' => false),
);
$tabs['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('prefix' => $prefix, 'controller' => 'pen_test_results', 'action' => 'db_tab_index', $ad_account_id, 'plugin' => false),
);
$tabs['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => array('prefix' => $prefix, 'controller' => 'high_risk_results', 'action' => 'db_tab_index', $ad_account_id, 'plugin' => false),
);

echo $this->element('Utilities.page_dashboard', array(
	'page_title' => __('Dashboard: %s', __('Overview')),
	'page_options_html' => $this->element('dashboard_options'),
	'page_options_title2' => $page_options_title2,
	'page_options2' => $page_options2,
	'dashboard_blocks' => $dashboard_blocks,
	'tabs' => $tabs,
));