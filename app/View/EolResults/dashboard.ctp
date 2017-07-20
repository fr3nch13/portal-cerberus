<?php

$dashboard_blocks = array(
//	'eol_results_desc' => array('action' => 'db_block_desc'),
	'eol_results_overview' => array('action' => 'db_block_overview'),
	'eol_db_tab_totals' => array('action' => 'db_tab_totals', 'system', 2),
	'eol_db_tab_status_org' => array('action' => 'db_tab_status', 'org', 1),
	'eol_db_tab_gssparent' => array('action' => 'db_tab_gssparent'),
	'eol_db_block_status_trend' => array('action' => 'db_block_status_trend'),
	'eol_db_tab_assignable_party_org' => array('action' => 'db_tab_assignable_party', 'org', 1),
	'eol_db_tab_remediation_org' => array('action' => 'db_tab_remediation', 'org', 1),
	'eol_db_tab_verification_org' => array('action' => 'db_tab_verification', 'org', 1),
	'eol_db_block_assignable_party_trend' => array('action' => 'db_block_assignable_party_trend'),
	'eol_db_block_remediation_trend' => array('action' => 'db_block_remediation_trend'),
	'eol_db_block_verification_trend' => array('action' => 'db_block_verification_trend'),
	
//	'eol_db_tab_assignable_party_division' => array('action' => 'db_tab_assignable_party', 'division', 1),
//	'eol_db_tab_remediation_division' => array('action' => 'db_tab_remediation', 'division', 1),
//	'eol_db_tab_status_division' => array('action' => 'db_tab_status', 'division', 1),
//	'eol_db_tab_verification_division' => array('action' => 'db_tab_verification', 'division', 1),
	
);

$tabs = array();

$tabs['results'] = array(
	'id' => 'results',
	'name' => __('All Results'), 
	'ajax_url' => array('action' => 'db_tab_index'),
);
$tabs['breakout'] = array(
	'id' => 'breakout',
	'name' => __('Breakout List'), 
	'ajax_url' => array('action' => 'db_tab_breakout'),
);
$tabs['assignable_party'] = array(
	'id' => 'assignable_party',
	'name' => __('%s Counts', __('Assignable Party')), 
	'ajax_url' => array('action' => 'db_tab_assignable_party'),
);
$tabs['remediation'] = array(
	'id' => 'remediation',
	'name' => __('%s Counts', __('Remediation')), 
	'ajax_url' => array('action' => 'db_tab_remediation'),
);
$tabs['status'] = array(
	'id' => 'status',
	'name' => __('%s Counts', __('Status')), 
	'ajax_url' => array('action' => 'db_tab_status'),
);
$tabs['verification'] = array(
	'id' => 'verification',
	'name' => __('%s Counts', __('Verification')), 
	'ajax_url' => array('action' => 'db_tab_verification'),
);
$tabs['orphans'] = array(
	'id' => 'orphans',
	'name' => __('Orphans'), 
	'ajax_url' => array('action' => 'orphans'),
);
$tabs['trending'] = array(
	'id' => 'trending',
	'name' => __('Reports Trending'), 
	'ajax_url' => array('controller' => 'eol_reports', 'action' => 'db_tab_trend'),
);
$tabs['crossovers'] = array(
	'id' => 'crossovers',
	'name' => __('Crossovers'), 
	'ajax_url' => array('action' => 'db_tab_crossovers'),
);

echo $this->element('Utilities.page_dashboard', array(
	'page_title' => __('Dashboard: %s', __('End of Life')),
	'page_options_html' => $this->element('dashboard_options'),
	'dashboard_blocks' => $dashboard_blocks,
	'tabs' => $tabs,
));