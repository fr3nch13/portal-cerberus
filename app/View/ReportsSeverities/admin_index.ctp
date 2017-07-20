<?php 
// File: app/View/ReportsSeverities/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Reports Severity') ), array('action' => 'add')),
);

// content
$th = array(
	'ReportsSeverity.name' => array('content' => __('Name'), 'options' => array('sort' => 'ReportsSeverity.name')),
	'ReportsSeverity.color_code_hex' => array('content' => __('Color'), 'options' => array('sort' => 'ReportsSeverity.color_code_hex')),
	'ReportsSeverity.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($reports_severities as $i => $reports_severity)
{
	$td[$i] = array(
		$reports_severity['ReportsSeverity']['name'],
		$this->Common->coloredCell($reports_severity['ReportsSeverity'], array('displayField' => 'color_code_hex', 'colorShow' => true)),
		$reports_severity['ReportsSeverity']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $reports_severity['ReportsSeverity']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $reports_severity['ReportsSeverity']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Reports Severities'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));