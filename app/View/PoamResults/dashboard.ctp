<?php

$dashboard_blocks = array(
//	'poamResults_desc' => array('action' => 'db_block_desc'),
	'poamResults_overview' => array('action' => 'db_block_overview'),
	'poam_db_tab_totals' => array('action' => 'db_tab_totals', 'system', 2),
	'poam_db_tab_status_org' => array('action' => 'db_tab_status', 'org', 1),
	'poam_db_tab_gssparent' => array('action' => 'db_tab_gssparent'),
	'poam_db_block_status_trend' => array('action' => 'db_block_status_trend'),
	'poam_db_tab_criticality_org' => array('action' => 'db_tab_criticality', 'org', 1),
	'poam_db_tab_risk_org' => array('action' => 'db_tab_risk', 'org', 1),
	'poam_db_tab_severity_org' => array('action' => 'db_tab_severity', 'org', 1),
	'poam_db_block_criticality_trend' => array('action' => 'db_block_criticality_trend'),
	'poam_db_block_risk_trend' => array('action' => 'db_block_risk_trend'),
	'poam_db_block_severity_trend' => array('action' => 'db_block_severity_trend'),
);

$tabs = array();

$tabs['results'] = array(
	'id' => 'results',
	'name' => __('All Results'), 
	'ajax_url' => array('action' => 'db_tab_index'),
);
$tabs['db_tab_breakout'] = array(
	'id' => 'db_tab_breakout',
	'name' => __('Breakout List'), 
	'ajax_url' => array('action' => 'db_tab_breakout'),
);
$tabs['db_tab_totals'] = array(
	'id' => 'db_tab_totals',
	'name' => __('%s Counts', __('Total')), 
	'ajax_url' => array('action' => 'db_tab_totals'),
);
$tabs['db_tab_criticality'] = array(
	'id' => 'db_tab_criticality',
	'name' => __('%s Counts', __('Criticality')), 
	'ajax_url' => array('action' => 'db_tab_criticality'),
);
$tabs['db_tab_risk'] = array(
	'id' => 'db_tab_risk',
	'name' => __('%s Counts', __('Risk')), 
	'ajax_url' => array('action' => 'db_tab_risk'),
);
$tabs['db_tab_severity'] = array(
	'id' => 'db_tab_severity',
	'name' => __('%s Counts', __('Severity')), 
	'ajax_url' => array('action' => 'db_tab_severity'),
);
$tabs['db_tab_status'] = array(
	'id' => 'db_tab_status',
	'name' => __('%s Counts', __('Status')), 
	'ajax_url' => array('action' => 'db_tab_status'),
);
$tabs['orphans'] = array(
	'id' => 'orphans',
	'name' => __('Orphans'), 
	'ajax_url' => array('action' => 'orphans'),
);
$tabs['reports_trending'] = array(
	'id' => 'reports_trending',
	'name' => __('Reports Trending'), 
	'ajax_url' => array('controller' => 'poam_reports', 'action' => 'db_tab_trend'),
);
echo $this->element('Utilities.page_dashboard', array(
	'page_title' => __('Dashboard: %s', __('POA&M')),
	'page_options_html' => $this->element('dashboard_options'),
	'dashboard_blocks' => $dashboard_blocks,
	'tabs' => $tabs,
));