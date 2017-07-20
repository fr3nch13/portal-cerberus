<?php 
// File: app/View/ReportsAssignableParties/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Reports Assignable Party') ), array('action' => 'add')),
);

// content
$th = array(
	'ReportsAssignableParty.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsAssignableParty.name')),
	'ReportsAssignableParty.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reports_assignable_parties as $i => $reports_assignable_party)
{
	$td[$i] = array(
		$reports_assignable_party['ReportsAssignableParty']['name'],
		$reports_assignable_party['ReportsAssignableParty']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $reports_assignable_party['ReportsAssignableParty']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $reports_assignable_party['ReportsAssignableParty']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Reports Assignable Parties'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));