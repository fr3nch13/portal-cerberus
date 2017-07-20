<?php 
// File: app/View/FismaSystemPoamCompletionStatuses/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('POAM Completion Status')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemPoamCompletionStatus.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemPoamCompletionStatus.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_poam_completion_statuses as $i => $fisma_system_poam_completion_status)
{
	$td[$i] = array(
		$fisma_system_poam_completion_status['FismaSystemPoamCompletionStatus']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_poam_completion_status['FismaSystemPoamCompletionStatus']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_poam_completion_status['FismaSystemPoamCompletionStatus']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('POAM Completion Statuses')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));