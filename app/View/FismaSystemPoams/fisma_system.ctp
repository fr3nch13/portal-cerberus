<?php 
// File: app/View/FismaSystemPoams/fisma_system.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('POAM')), array('action' => 'add', $fisma_system['FismaSystem']['id'], 'saa' => true));
}

// content
$th = array(
	'FismaSystemPoam.weakness_id' => array('content' => __('Weaknes ID'), 'options' => array('sort' => 'FismaSystemPoam.weakness_id')),
	'FismaSystemPoam.controls' => array('content' => __('Controls'), 'options' => array('sort' => 'FismaSystemPoam.mac_address')),
	'FismaSystemPoam.weakness' => array('content' => __('Weaknes'), 'options' => array('sort' => 'FismaSystemPoam.weakness')),
	'FismaSystemPoam.solution' => array('content' => __('Solution'), 'options' => array('sort' => 'FismaSystemPoam.solution')),
	'FismaSystemPoam.scheduled_completion' => array('content' => __('Scheduled Completion'), 'options' => array('sort' => 'FismaSystemPoam.scheduled_completion')),
	'FismaSystemPoamCompletionStatus.name' => array('content' => __('Completion Status'), 'options' => array('sort' => 'FismaSystemPoamCompletionStatus.name')),
	'FismaSystemPoamStatusLog.status' => array('content' => __('Latest Status Log')),
	'FismaSystemPoam.closed' => array('content' => __('Closed?'), 'options' => array('sort' => 'FismaSystemPoam.closed')),
	'FismaSystemPoam.created' => array('content' => __('Created'), 'options' => array('sort' => 'FismaSystemPoam.created')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_poams as $i => $fisma_system_poam)
{
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $fisma_system_poam['FismaSystemPoam']['id'])),
	);
	
	$closed = $this->Wrap->yesNo($fisma_system_poam['FismaSystemPoam']['closed']);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_poam['FismaSystemPoam']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Add %s', __('Status Log')), array('controller' => 'fisma_system_poam_status_logs', 'action' => 'add', $fisma_system_poam['FismaSystemPoam']['id'], 'saa' => true));
		$closed = array(
			$this->Form->postLink($closed,array('action' => 'toggle', 'closed', $fisma_system_poam['FismaSystemPoam']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		);
	}
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($fisma_system_poam['FismaSystemPoam']['weakness_id'], array('action' => 'view', $fisma_system_poam['FismaSystemPoam']['id'])),
		$fisma_system_poam['FismaSystemPoam']['controls'],
		$this->Wrap->descView($fisma_system_poam['FismaSystemPoam']['weakness'], false),
		$this->Wrap->descView($fisma_system_poam['FismaSystemPoam']['solution'], false),
		$this->Wrap->niceTime($fisma_system_poam['FismaSystemPoam']['scheduled_completion']),
		$fisma_system_poam['FismaSystemPoamCompletionStatus']['name'],
		(isset($fisma_system_poam['FismaSystemPoamStatusLog'][0]['status'])?$fisma_system_poam['FismaSystemPoamStatusLog'][0]['status']:false),
		$closed,
		$this->Wrap->niceTime($fisma_system_poam['FismaSystemPoam']['created']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s for: %s', __('POAMS'), $fisma_system['FismaSystem']['name']),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));