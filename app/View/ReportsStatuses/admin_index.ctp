<?php 
// File: app/View/ReportsStatuses/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Reports Status')), array('action' => 'add')),
);

// content
$th = array(
	'ReportsStatus.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsStatus.name')),
	'ReportsStatus.color_code_hex' => array('content' => __('Color'), 'options' => array('sort' => 'ReportsStatus.color_code_hex')),
	'ReportsStatus.show' => array('content' => __('Show in tables?'), 'options' => array('sort' => 'ReportsStatus.show')),
	'ReportsStatus.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reports_statuses as $i => $reports_status)
{
	$td[$i] = array(
		$reports_status['ReportsStatus']['name'],
		$this->Common->coloredCell($reports_status['ReportsStatus'], array('displayField' => 'color_code_hex', 'colorShow' => true)),
		$this->Html->toggleLink($reports_status['ReportsStatus'], 'show'),
		$reports_status['ReportsStatus']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $reports_status['ReportsStatus']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $reports_status['ReportsStatus']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Reports Statuses'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));