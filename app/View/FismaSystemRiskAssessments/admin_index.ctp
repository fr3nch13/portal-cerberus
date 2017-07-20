<?php 
// File: app/View/FismaSystemRiskAssessments/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemRiskAssessment.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemRiskAssessment.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_risk_assessments as $i => $fisma_system_risk_assessment)
{
	$td[$i] = array(
		$fisma_system_risk_assessment['FismaSystemRiskAssessment']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_risk_assessment['FismaSystemRiskAssessment']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_risk_assessment['FismaSystemRiskAssessment']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('FO Risk Assessments')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));