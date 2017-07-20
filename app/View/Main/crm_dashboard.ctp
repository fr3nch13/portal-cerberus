<?php


$dashboard_blocks = array(
	'fisma_systems_crm' => array('controller' => 'fisma_systems', 'action' => 'db_block_overview', $ad_account_id, 'crm' => true, 'plugin' => false),
	'eol_results_crm' => array('controller' => 'eol_results', 'action' => 'db_block_overview', $ad_account_id, 'crm' => true, 'plugin' => false),
	'pen_test_results_crm' => array('controller' => 'pen_test_results', 'action' => 'db_block_overview', $ad_account_id, 'crm' => true, 'plugin' => false),
	'high_risk_results_crm' => array('controller' => 'high_risk_results', 'action' => 'db_block_overview', $ad_account_id, 'crm' => true, 'plugin' => false),
//	'rules_crm' => array('controller' => 'rules', 'action' => 'db_block_crm'),
);

$tabs = array();

/*
$tabs[] = array(
	'key' => 'fismaSystems',
	'title' => __('Fisma Systems'), 
	'url' => array('controller' => 'fisma_systems', 'action' => 'index', $ad_account_id, 'crm' => true, 'plugin' => false),
);
$tabs[] = array(
	'key' => 'penTestResults',
	'title' => __('Pen Test Results'), 
	'url' => array('controller' => 'pen_test_results', 'action' => 'index', $ad_account_id, 'crm' => true, 'plugin' => false),
);
$tabs[] = array(
	'key' => 'eolResults',
	'title' => __('EOL Results'), 
	'url' => array('controller' => 'eol_results', 'action' => 'index', $ad_account_id, 'crm' => true, 'plugin' => false),
);
$tabs[] = array(
	'key' => 'highRiskResults',
	'title' => __('High Risk Results'), 
	'url' => array('controller' => 'high_risk_results', 'action' => 'index', $ad_account_id, 'crm' => true, 'plugin' => false),
);
*/

echo $this->element('Utilities.page_dashboard', array(
	'page_title' => __('Dashboard: %s', __('Overview')),
//	'page_options_html' => $this->element('dashboard_options'),
	'dashboard_blocks' => $dashboard_blocks,
	'tabs' => $tabs,
));