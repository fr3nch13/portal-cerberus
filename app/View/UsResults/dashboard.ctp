<?php

$page_options = [
	'all' => $this->Html->link(__('All Reports'), [0 => 0]),
];
$page_subtitle = __('Results from all Reports');
foreach($usReports as $report_id => $report_name)
{
	if($us_report_id and $us_report_id == $report_id)
		$page_subtitle = $report_name;
	
	$page_options['ReportsEvent.'. $report_id] = $this->Html->link(__('Event: %s', $report_name), [0 => $report_id]);
}

$page_subtitle2 = false;
if($us_report_id) 
	$page_subtitle2 = __('Trends are unavailable when viewing specific reports.');

$dashboard_blocks = [];

$dashboard_blocks['us_results_overview'] = ['action' => 'db_block_overview', $us_report_id];
$dashboard_blocks['us_db_tab_totals'] = ['action' => 'db_tab_totals', 'system', 2, $us_report_id];
$dashboard_blocks['us_db_tab_software'] = ['action' => 'db_tab_software', 'org', 1, $us_report_id];
$dashboard_blocks['us_db_tab_status_org'] = ['action' => 'db_tab_status', 'org', 1, $us_report_id];
$dashboard_blocks['us_db_tab_gssparent'] = ['action' => 'db_tab_gssparent', $us_report_id];
if(!$us_report_id) $dashboard_blocks['us_db_block_status_trend'] = ['action' => 'db_block_status_trend'];
$dashboard_blocks['us_db_tab_assignable_party_org'] = ['action' => 'db_tab_assignable_party', 'org', 1, $us_report_id];
$dashboard_blocks['us_db_tab_remediation_org'] = ['action' => 'db_tab_remediation', 'org', 1, $us_report_id];
$dashboard_blocks['us_db_tab_verification_org'] = ['action' => 'db_tab_verification', 'org', 1, $us_report_id];
if(!$us_report_id) $dashboard_blocks['us_db_block_assignable_party_trend'] = ['action' => 'db_block_assignable_party_trend'];
if(!$us_report_id) $dashboard_blocks['us_db_block_remediation_trend'] = ['action' => 'db_block_remediation_trend'];
if(!$us_report_id) $dashboard_blocks['us_db_block_verification_trend'] = ['action' => 'db_block_verification_trend'];

$tabs = [];

$tabs['results'] = [
	'id' => 'results',
	'name' => __('All Results'), 
	'ajax_url' => ['action' => 'db_tab_index', 0, $us_report_id],
];
$tabs['db_tab_breakout'] = [
	'id' => 'db_tab_breakout',
	'name' => __('Breakout List'), 
	'ajax_url' => ['action' => 'db_tab_breakout', 'division', 0, $us_report_id],
];
$tabs['db_tab_software'] = [
	'id' => 'db_tab_software',
	'name' => __('%s Counts', __('EOL/US Software')), 
	'ajax_url' => ['action' => 'db_tab_software', 'division', 0, $us_report_id],
];
$tabs['db_tab_software_all'] = [
	'id' => 'db_tab_software_all',
	'name' => __('%s Counts', __('EOL/US Software (all results)')), 
	'ajax_url' => ['action' => 'db_tab_software_all', $us_report_id],
];
$tabs['db_tab_assignable_party'] = [
	'id' => 'db_tab_assignable_party',
	'name' => __('%s Counts', __('Assignable Party')), 
	'ajax_url' => ['action' => 'db_tab_assignable_party', 'division', 0, $us_report_id],
];
$tabs['db_tab_remediation'] = [
	'id' => 'db_tab_remediation',
	'name' => __('%s Counts', __('Remediation')), 
	'ajax_url' => ['action' => 'db_tab_remediation', 'division', 0, $us_report_id],
];
$tabs['db_tab_status'] = [
	'id' => 'db_tab_status',
	'name' => __('%s Counts', __('Status')), 
	'ajax_url' => ['action' => 'db_tab_status', 'division', 0, $us_report_id],
];
$tabs['db_tab_verification'] = [
	'id' => 'db_tab_verification',
	'name' => __('%s Counts', __('Verification')), 
	'ajax_url' => ['action' => 'db_tab_verification', 'division', 0, $us_report_id],
];
$tabs['orphans'] = [
	'id' => 'orphans',
	'name' => __('Orphans'), 
	'ajax_url' => ['action' => 'orphans', $us_report_id],
];
if(!$us_report_id)
{
	$tabs['reports_trending'] = [
		'id' => 'reports_trending',
		'name' => __('Reports Trending'), 
		'ajax_url' => ['controller' => 'us_reports', 'action' => 'db_tab_trend'],
	];
	$tabs['crossovers'] = [
		'id' => 'crossovers',
		'name' => __('Crossovers'), 
		'ajax_url' => ['action' => 'db_tab_crossovers'],
	];
}

echo $this->element('Utilities.page_dashboard', [
	'page_title' => __('Dashboard: %s', __('Unupported Software')),
	'page_subtitle' => __('%s: %s', __('Report'), $page_subtitle),
	'page_subtitle2' => $page_subtitle2,
	'page_options_html' => $this->element('dashboard_options'),
	'page_options_title' => __('View By %s', __('Report')),
	'page_options' => $page_options,
	'dashboard_blocks' => $dashboard_blocks,
	'tabs' => $tabs,
]);