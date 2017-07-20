<?php 
// File: app/View/ReportsEvents/admin_index.ctp
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('Event')), array('action' => 'add', 'admin' => true));
}

// content
$th = array(
	'ReportsEvent.shortname' => array('content' => __('Short Name'), 'options' => array('sort' => 'ReportsEvent.shortname', 'editable' => array('type' => 'text'))),
	'ReportsEvent.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsEvent.name', 'editable' => array('type' => 'text'))),
	'ReportsEvent.event_date' => array('content' => __('Event Date'), 'options' => array('sort' => 'ReportsEvent.event_date', 'editable' => array('type' => 'date'))),
	'ReportsEvent.details' => array('content' => __('Details'), 'options' => array('sort' => 'ReportsEvent.details', 'editable' => array('type' => 'textarea'))),
	'ReportsEvent.report_count' => array('content' => __('# %s', __('Pen Test Reports'))),
	'ReportsEvent.result_count' => array('content' => __('# %s', __('Pen Test Results'))),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reportsEvents as $i => $reportsEvent)
{
	$edit_id = array(
		'ReportsEvent' => $reportsEvent['ReportsEvent']['id'],
	);
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $reportsEvent['ReportsEvent']['id'], 'admin' => false)),
	);
	if($this->Wrap->roleCheck(array('admin')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $reportsEvent['ReportsEvent']['id'], 'admin' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $reportsEvent['ReportsEvent']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$td[$i] = array(
		$this->Html->link($reportsEvent['ReportsEvent']['shortname'], array('action' => 'view', $reportsEvent['ReportsEvent']['id'], 'admin' => false)),
		$this->Html->link($reportsEvent['ReportsEvent']['name'], array('action' => 'view', $reportsEvent['ReportsEvent']['id'], 'admin' => false)),
		array(
			$this->Wrap->niceDay($reportsEvent['ReportsEvent']['event_date']),
			array('value' => $reportsEvent['ReportsEvent']['event_date']),
		),
		$this->Html->tableDesc($reportsEvent['ReportsEvent']['details']),
		array('.', array(
			'ajax_count_url' => array('controller' => 'pen_test_reports', 'action' => 'reports_event', $reportsEvent['ReportsEvent']['id']),
			'url' => array('action' => 'view', $reportsEvent['ReportsEvent']['id'], 'tab' => 'pen_test_reports'),
		)),
		array('.', array(
			'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'reports_event', $reportsEvent['ReportsEvent']['id']),
			'url' => array('action' => 'view', $reportsEvent['ReportsEvent']['id'], 'tab' => 'pen_test_results'),
		)),
		array(
			$actions,
			array('class' => 'actions'),
		),
		'edit_id' => $edit_id,
	);
}

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin')))
	$use_gridedit = true;

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Reports Events'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
));