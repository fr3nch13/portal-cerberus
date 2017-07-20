<?php 
// File: app/View/ReportsEvents/view.ctp
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $reportsEvent['ReportsEvent']['id'], 'admin' => true));
	$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $reportsEvent['ReportsEvent']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
}

$details = array(
	array('name' => __('Event Date'), 'value' => $this->Wrap->niceTime($reportsEvent['ReportsEvent']['event_date'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($reportsEvent['ReportsEvent']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($reportsEvent['ReportsEvent']['modified'])),
);

$stats = array();
$tabs = array();

$tabs['pen_test_reports'] = $stats['pen_test_reports'] = array(
	'id' => 'pen_test_reports',
	'name' => __('Pen Test Reports'), 
	'ajax_url' => array('controller' => 'pen_test_reports', 'action' => 'reports_event', $reportsEvent['ReportsEvent']['id']),
);
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'reports_event', $reportsEvent['ReportsEvent']['id']),
);
$tabs['details'] = array(
	'key' => 'details',
	'title' => __('Details'),
	'content' => $this->Wrap->descView($reportsEvent['ReportsEvent']['details']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : (%s) %s', __('Reports Event'), $reportsEvent['ReportsEvent']['shortname'], $reportsEvent['ReportsEvent']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));