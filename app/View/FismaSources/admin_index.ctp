<?php 
// File: app/View/FismaSources/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('FISMA Source')), array('action' => 'add')),
);

// content
$th = array(
	'FismaSource.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSource.name')),
	'FismaSource.default' => array('content' => __('Default'), 'options' => array('sort' => 'FismaSource.default')),
	'FismaSource.sendemail' => array('content' => __('Send Email?'), 'options' => array('sort' => 'FismaSource.sendemail')),
	'FismaSource.mon' => array('content' => __('Mon'), 'options' => array('sort' => 'FismaSource.mon')),
	'FismaSource.tue' => array('content' => __('Tues'), 'options' => array('sort' => 'FismaSource.tue')),
	'FismaSource.wed' => array('content' => __('Wed'), 'options' => array('sort' => 'FismaSource.wed')),
	'FismaSource.thu' => array('content' => __('Thurs'), 'options' => array('sort' => 'FismaSource.thu')),
	'FismaSource.fri' => array('content' => __('Fri'), 'options' => array('sort' => 'FismaSource.fri')),
	'FismaSource.sat' => array('content' => __('Sat'), 'options' => array('sort' => 'FismaSource.sat')),
	'FismaSource.sun' => array('content' => __('Sun'), 'options' => array('sort' => 'FismaSource.sun')),
	'FismaSource.notify_time' => array('content' => __('Send Email At'), 'options' => array('sort' => 'FismaSource.notify_time')),
	'FismaSource.notify_email' => array('content' => __('Notification Email'), 'options' => array('sort' => 'FismaSource.notify_email')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_sources as $i => $fisma_source)
{
	$default_button = '';
	
	if(!$fisma_source['FismaSource']['default'])
	{
		$default_button = $this->Html->link(__('Make Default'), array('action' => 'default', $fisma_source['FismaSource']['id']));
	}
	
	$td[$i] = array(
		$fisma_source['FismaSource']['name'],
		$this->Wrap->yesNo($fisma_source['FismaSource']['default']),
		$this->Wrap->yesNo($fisma_source['FismaSource']['sendemail']),
		$this->Wrap->check($fisma_source['FismaSource']['mon']),
		$this->Wrap->check($fisma_source['FismaSource']['tue']),
		$this->Wrap->check($fisma_source['FismaSource']['wed']),
		$this->Wrap->check($fisma_source['FismaSource']['thu']),
		$this->Wrap->check($fisma_source['FismaSource']['fri']),
		$this->Wrap->check($fisma_source['FismaSource']['sat']),
		$this->Wrap->check($fisma_source['FismaSource']['sun']),
		$this->Local->reviewTimes($fisma_source['FismaSource']['notify_time']),
		$fisma_source['FismaSource']['notify_email'],
		array(
			$default_button.
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_source['FismaSource']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_source['FismaSource']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Sources'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>