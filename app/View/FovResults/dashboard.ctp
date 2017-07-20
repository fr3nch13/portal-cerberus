<?php

$dashboard_blocks = [
//	'eol_results_desc' => ['action' => 'db_block_desc'),
	'eol_results_overview' => ['action' => 'db_block_overview'],
	'fov_db_tab_totals' => ['action' => 'db_tab_totals', 'system', 2],
	'fov_db_tab_status_org' => ['action' => 'db_tab_status', 'org', 1],
	'fov_db_tab_gssparent' => ['action' => 'db_tab_gssparent'],
	'fov_db_block_status_trend' => ['action' => 'db_block_status_trend'],
	'fov_db_tab_assignable_party_org' => ['action' => 'db_tab_assignable_party', 'org', 1],
	'fov_db_tab_remediation_org' => ['action' => 'db_tab_remediation', 'org', 1],
	'fov_db_tab_severity_org' => ['action' => 'db_tab_severity', 'org', 1],
	'fov_db_tab_verification_org' => ['action' => 'db_tab_verification', 'org', 1],
	'fov_db_block_assignable_party_trend' => ['action' => 'db_block_assignable_party_trend'],
	'fov_db_block_remediation_trend' => ['action' => 'db_block_remediation_trend'],
	'fov_db_block_severity_trend' => ['action' => 'db_block_severity_trend'],
	'fov_db_block_status_trend' => ['action' => 'db_block_status_trend'],
	'fov_db_block_verification_trend' => ['action' => 'db_block_verification_trend'],
];

$tabs = [];

$tabs['results'] = [
	'id' => 'results',
	'name' => __('All Results'), 
	'ajax_url' => ['action' => 'db_tab_index'],
];
/*
$tabs['breakout'] = [
	'id' => 'breakout',
	'name' => __('Breakout List'), 
	'ajax_url' => ['action' => 'db_tab_breakout'],
];
*/
$tabs['assignable_party'] = [
	'id' => 'assignable_party',
	'name' => __('%s Counts', __('Assignable Party')), 
	'ajax_url' => ['action' => 'db_tab_assignable_party'],
];
$tabs['remediation'] = [
	'id' => 'remediation',
	'name' => __('%s Counts', __('Remediation')), 
	'ajax_url' => ['action' => 'db_tab_remediation'],
];
$tabs['severity'] = [
	'id' => 'severity',
	'name' => __('%s Counts', __('Severity')), 
	'ajax_url' => ['action' => 'db_tab_severity'],
];
$tabs['status'] = [
	'id' => 'status',
	'name' => __('%s Counts', __('Status')), 
	'ajax_url' => ['action' => 'db_tab_status'],
];
$tabs['verification'] = [
	'id' => 'verification',
	'name' => __('%s Counts', __('Verification')), 
	'ajax_url' => ['action' => 'db_tab_verification'],
];
$tabs['orphans'] = [
	'id' => 'orphans',
	'name' => __('Orphans'), 
	'ajax_url' => ['action' => 'orphans'],
];
$tabs['crossovers'] = [
	'id' => 'crossovers',
	'name' => __('Crossovers'), 
	'ajax_url' => ['action' => 'db_tab_crossovers'],
];

echo $this->element('Utilities.page_dashboard', [
	'page_title' => __('Dashboard: %s', __('Focused Ops Vulnerabilities')),
	'page_options_html' => $this->element('dashboard_options'),
	'dashboard_blocks' => $dashboard_blocks,
	'tabs' => $tabs,
]);