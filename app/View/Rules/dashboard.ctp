<?php


$dashboard_blocks = array(
	'rules_overview' => array('controller' => 'rules', 'action' => 'db_block_overview'),
);

echo $this->element('Utilities.page_dashboard', array(
	'page_title' => __('Dashboard: %s', __('Rules')),
	'page_options_html' => $this->element('dashboard_options'),
	'dashboard_blocks' => $dashboard_blocks,
));