<?php 
// File: app/View/ReportsOrganizations/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Organization') ), array('action' => 'add')),
);

// content
$th = array(
	'ReportsOrganization.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsOrganization.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reportsOrganizations as $i => $reportsOrganization)
{
	$td[$i] = array(
		$reportsOrganization['ReportsOrganization']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $reportsOrganization['ReportsOrganization']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $reportsOrganization['ReportsOrganization']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Organizations'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));