<?php 
// File: app/View/FismaSystemPoamStatusLogs/fisma_system_poam_status_log.ctp

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s %s', __('POAM'), __('Status Log')), array('action' => 'add', $fisma_system_poam['FismaSystemPoam']['id'], 'saa' => true));
}

// content
$th = array(
	'FismaSystemPoamStatusLog.status' => array('content' => __('Status'), 'options' => array('sort' => 'FismaSystemPoamStatusLog.status')),
	'User.name' => array('content' => __('User'), 'options' => array('sort' => 'User.name')),
	'FismaSystemPoamStatusLog.created' => array('content' => __('Created'), 'options' => array('sort' => 'FismaSystemPoamStatusLog.created')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_poam_status_logs as $i => $fisma_system_poam_status_log)
{
	$actions = array(
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_poam_status_log['FismaSystemPoamStatusLog']['id'], 'saa' => true));
//		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_poam_status_log['FismaSystemPoamStatusLog']['id'], 'saa' => true),array('confirm' => 'Are you sure?'));
	}
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$fisma_system_poam_status_log['FismaSystemPoamStatusLog']['status'],
		$this->Html->link($fisma_system_poam_status_log['User']['name'], array('controller' => 'users', 'action' => 'view', $fisma_system_poam_status_log['User']['id'])),
		$this->Wrap->niceTime($fisma_system_poam_status_log['FismaSystemPoamStatusLog']['created']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POAM Logs'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));