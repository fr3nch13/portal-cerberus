<?php

$page_options = array();


$this->set(array(
	'page_subtitle' => __('%s Trends', __('High Risk Results')),
	'page_options' => $page_options,
	'page_sections' => array(
		'high_risk_db_tab_trends_status' => array('action' => 'db_tab_trends_status'),
		'high_risk_db_tab_trends_status_table' => array('action' => 'db_tab_trends_status', 1),
		'high_risk_db_tab_trends_status_week' => array('action' => 'db_tab_trends_status_week'),
		'high_risk_db_tab_trends_status_week_table' => array('action' => 'db_tab_trends_status_week', date('w'), 1),
	),
));

echo $this->element('Utilities.page_sections');
