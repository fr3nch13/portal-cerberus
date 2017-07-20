<?php

$ad_account_id = (isset($ad_account_id)?$ad_account_id:false);

$tabs = [];
$tabs['fisma_system_counts'] = [
	'id' => 'fisma_system_counts',
	'name' => __('FISMA System Counts'), 
	'ajax_url' => ['isso' => true, 'controller' => 'fisma_systems', 'action' => 'db_tab_index', $ad_account_id, 'plugin' => false],
];
$tabs['poam_open_counts'] = [
	'id' => 'poam_open_counts',
	'name' => __('POA&M Open Counts'), 
	'ajax_url' => ['isso' => true, 'controller' => 'poam_results', 'action' => 'open_counts', 'plugin' => false],
];
$tabs['us_open_counts'] = [
	'id' => 'us_open_counts',
	'name' => __('US Open Counts'), 
	'ajax_url' => ['isso' => true, 'controller' => 'us_results', 'action' => 'open_counts', $ad_account_id, 'plugin' => false],
];
$tabs['eol_open_counts'] = [
	'id' => 'eol_open_counts',
	'name' => __('EOL Open Counts'), 
	'ajax_url' => ['isso' => true, 'controller' => 'eol_results', 'action' => 'open_counts', $ad_account_id, 'plugin' => false],
];
$tabs['pen_test_open_counts'] = [
	'id' => 'pen_test_open_counts',
	'name' => __('Pen Test Open Counts'), 
	'ajax_url' => ['isso' => true, 'controller' => 'pen_test_results', 'action' => 'open_counts', 'plugin' => false],
];
$tabs['high_risk_open_counts'] = [
	'id' => 'high_risk_open_counts',
	'name' => __('High Risk Open Counts'), 
	'ajax_url' => ['isso' => true, 'controller' => 'high_risk_results', 'action' => 'open_counts', $ad_account_id, 'plugin' => false],
];

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Dashboard: %s', __('Overview')),
	'tabs' => $tabs,
));