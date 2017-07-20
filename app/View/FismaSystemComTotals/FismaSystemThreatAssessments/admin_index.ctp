<?php 
// File: app/View/FismaSystemThreatAssessments/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('FO Threat Assessment')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemThreatAssessment.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemThreatAssessment.name')),
	'FismaSystemThreatAssessment.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemThreatAssessment.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_threat_assessments as $i => $fisma_system_threat_assessment)
{
	$td[$i] = array(
		$fisma_system_threat_assessment['FismaSystemThreatAssessment']['name'],
		$fisma_system_threat_assessment['FismaSystemThreatAssessment']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_threat_assessment['FismaSystemThreatAssessment']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_threat_assessment['FismaSystemThreatAssessment']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('FO Threat Assessments')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));