<?php

$dashboard_blocks = array(
	'fisma_systems_overview' => array('action' => 'db_block_overview'),
	'fisma_systems_db_block_fips_ratings' => array('action' => 'db_block_fips_ratings'),
	'fisma_systems_db_tab_piicount_org' => array('action' => 'db_tab_piicount', 'org', 1),
	'fisma_systems_db_tab_piicount_parent' => array('action' => 'db_tab_piicount_parent', 1),
	'poam_db_tab_status_org' => array('controller' => 'poam_results', 'action' => 'db_tab_status', 'org', 1),
	'fisma_systems_db_tab_us_results' => array('action' => 'db_tab_us_results', 'org', 1),
	'fisma_systems_db_tab_eol_results' => array('action' => 'db_tab_eol_results', 'org', 1),
	'fisma_systems_db_tab_high_risk_results' => array('action' => 'db_tab_high_risk_results', 'org', 1),
	'fisma_systems_db_tab_pen_test_results' => array('action' => 'db_tab_pen_test_results', 'org', 1),
);

foreach($reportsSeverities as $reportsSeverity_id => $reportsSeverity_name)
{
	$dashboard_blocks['fisma_systems_db_tab_pen_test_results_severity_'. $reportsSeverity_id] = array('action' => 'db_tab_pen_test_results', 'org', 1, $reportsSeverity_id);
}

$tabs = array();

$tabs['pivot'] = array(
	'id' => 'pivot',
	'name' => __('%s Heirarchy List', __('FISMA Systems')), 
	'ajax_url' => array('action' => 'db_tab_pivot'),
);
$tabs['index'] = array(
	'id' => 'index',
	'name' => __('All %s', __('Fisma Systems')), 
	'ajax_url' => array('action' => 'db_tab_index'),
);
$tabs['oam'] = array(
	'id' => 'oam',
	'name' => __('OAM %s Dashboard', __('FISMA Systems')), 
	'ajax_url' => array('action' => 'db_tab_oam', 'intab' => true),
);
$tabs['summary'] = array(
	'id' => 'summary',
	'name' => __('%s Summary Dashboard', __('FISMA Systems')), 
	'ajax_url' => array('action' => 'db_tab_summary'),
);
$tabs['orgchart'] = array(
	'id' => 'orgchart',
	'name' => __('%s Org Chart', __('FISMA Systems')), 
	'ajax_url' => array('action' => 'db_tab_orgchart'),
);
$tabs['poam_results'] = array(
	'id' => 'poam_results',
	'name' => __('%s Counts', __('POA&M')), 
	'ajax_url' => array('controller' => 'poam_results', 'action' => 'db_tab_status'),
);
$tabs['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Counts'), 
	'ajax_url' => array('action' => 'db_tab_us_results'),
);
$tabs['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Counts'), 
	'ajax_url' => array('action' => 'db_tab_eol_results'),
);
$tabs['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Counts'), 
	'ajax_url' => array('action' => 'db_tab_pen_test_results'),
);
$tabs['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Counts'), 
	'ajax_url' => array('action' => 'db_tab_high_risk_results'),
);
$tabs['piicount'] = array(
	'id' => 'piicount',
	'name' => __('PII Counts'), 
	'ajax_url' => array('action' => 'db_tab_piicount'),
);
$tabs['piicount_parent'] = array(
	'id' => 'piicount_parent',
	'name' => __('%s by %s', __('PII Counts'), __('GSS Parent')), 
	'ajax_url' => array('action' => 'db_tab_piicount_parent'),
);

echo $this->element('Utilities.page_dashboard', array(
	'page_title' => __('Dashboard: %s', __('FISMA Systems')),
	'page_options_html' => $this->element('dashboard_options'),
	'dashboard_blocks' => $dashboard_blocks,
	'tabs' => $tabs,
));