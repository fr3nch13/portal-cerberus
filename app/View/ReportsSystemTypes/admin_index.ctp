<?php 
// File: app/View/ReportsSystemTypes/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Reports System Type') ), array('action' => 'add')),
);

// content
$th = array(
	'ReportsSystemType.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsSystemType.name')),
	'ReportsSystemType.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reports_system_types as $i => $reports_system_type)
{
	$td[$i] = array(
		$reports_system_type['ReportsSystemType']['name'],
		$reports_system_type['ReportsSystemType']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $reports_system_type['ReportsSystemType']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $reports_system_type['ReportsSystemType']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Reports System Types'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));