<?php 
// File: app/View/FismaStatuses/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('FISMA Status')), array('action' => 'add')),
);

// content
$th = array(
	'FismaStatus.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaStatus.name')),
	'FismaStatus.default' => array('content' => __('Default'), 'options' => array('sort' => 'FismaStatus.default')),
	'FismaStatus.sendemail' => array('content' => __('Send Email?'), 'options' => array('sort' => 'FismaStatus.sendemail')),
	'FismaStatus.mon' => array('content' => __('Mon'), 'options' => array('sort' => 'FismaStatus.mon')),
	'FismaStatus.tue' => array('content' => __('Tues'), 'options' => array('sort' => 'FismaStatus.tue')),
	'FismaStatus.wed' => array('content' => __('Wed'), 'options' => array('sort' => 'FismaStatus.wed')),
	'FismaStatus.thu' => array('content' => __('Thurs'), 'options' => array('sort' => 'FismaStatus.thu')),
	'FismaStatus.fri' => array('content' => __('Fri'), 'options' => array('sort' => 'FismaStatus.fri')),
	'FismaStatus.sat' => array('content' => __('Sat'), 'options' => array('sort' => 'FismaStatus.sat')),
	'FismaStatus.sun' => array('content' => __('Sun'), 'options' => array('sort' => 'FismaStatus.sun')),
	'FismaStatus.notify_time' => array('content' => __('Send Email At'), 'options' => array('sort' => 'FismaStatus.notify_time')),
	'FismaStatus.notify_email' => array('content' => __('Notification Email'), 'options' => array('sort' => 'FismaStatus.notify_email')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_statuses as $i => $fisma_status)
{
	$default_button = '';
	
	if(!$fisma_status['FismaStatus']['default'])
	{
		$default_button = $this->Html->link(__('Make Default'), array('action' => 'default', $fisma_status['FismaStatus']['id']));
	}
	
	$td[$i] = array(
		$fisma_status['FismaStatus']['name'],
		$this->Wrap->yesNo($fisma_status['FismaStatus']['default']),
		$this->Wrap->yesNo($fisma_status['FismaStatus']['sendemail']),
		$this->Wrap->check($fisma_status['FismaStatus']['mon']),
		$this->Wrap->check($fisma_status['FismaStatus']['tue']),
		$this->Wrap->check($fisma_status['FismaStatus']['wed']),
		$this->Wrap->check($fisma_status['FismaStatus']['thu']),
		$this->Wrap->check($fisma_status['FismaStatus']['fri']),
		$this->Wrap->check($fisma_status['FismaStatus']['sat']),
		$this->Wrap->check($fisma_status['FismaStatus']['sun']),
		$this->Local->reviewTimes($fisma_status['FismaStatus']['notify_time']),
		$fisma_status['FismaStatus']['notify_email'],
		array(
			$default_button.
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_status['FismaStatus']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_status['FismaStatus']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Statuses'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>