<?php 
// File: app/View/ReportsVerifications/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Reports Verification') ), array('action' => 'add')),
);

// content
$th = array(
	'ReportsVerification.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsVerification.name')),
	'ReportsVerification.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reports_verifications as $i => $reports_verification)
{
	$td[$i] = array(
		$reports_verification['ReportsVerification']['name'],
		$reports_verification['ReportsVerification']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $reports_verification['ReportsVerification']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $reports_verification['ReportsVerification']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Reports Verifications'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));