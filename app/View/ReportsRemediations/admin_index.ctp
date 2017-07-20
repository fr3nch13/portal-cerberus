<?php 
// File: app/View/ReportsRemediations/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Reports Remediation') ), array('action' => 'add')),
);

// content
$th = array(
	'ReportsRemediation.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsRemediation.name')),
	'ReportsRemediation.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reports_remediations as $i => $reports_remediation)
{
	$td[$i] = array(
		$reports_remediation['ReportsRemediation']['name'],
		$reports_remediation['ReportsRemediation']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $reports_remediation['ReportsRemediation']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $reports_remediation['ReportsRemediation']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Reports Remediations'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));