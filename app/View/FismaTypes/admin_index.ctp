<?php 
// File: app/View/FismaTypes/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('FISMA Type')), array('action' => 'add')),
);

// content
$th = array(
	'FismaType.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaType.name')),
	'FismaType.export_type' => array('content' => __('Export Type'), 'options' => array('sort' => 'FismaType.export_type')),
	'FismaType.default' => array('content' => __('Default'), 'options' => array('sort' => 'FismaType.default')),
	'FismaType.sendemail' => array('content' => __('Send Email?'), 'options' => array('sort' => 'FismaType.sendemail')),
	'FismaType.mon' => array('content' => __('Mon'), 'options' => array('sort' => 'FismaType.mon')),
	'FismaType.tue' => array('content' => __('Tues'), 'options' => array('sort' => 'FismaType.tue')),
	'FismaType.wed' => array('content' => __('Wed'), 'options' => array('sort' => 'FismaType.wed')),
	'FismaType.thu' => array('content' => __('Thurs'), 'options' => array('sort' => 'FismaType.thu')),
	'FismaType.fri' => array('content' => __('Fri'), 'options' => array('sort' => 'FismaType.fri')),
	'FismaType.sat' => array('content' => __('Sat'), 'options' => array('sort' => 'FismaType.sat')),
	'FismaType.sun' => array('content' => __('Sun'), 'options' => array('sort' => 'FismaType.sun')),
	'FismaType.notify_time' => array('content' => __('Send Email At'), 'options' => array('sort' => 'FismaType.notify_time')),
	'FismaType.notify_email' => array('content' => __('Notification Email'), 'options' => array('sort' => 'FismaType.notify_email')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_types as $i => $fisma_type)
{
	$default_button = '';
	
	if(!$fisma_type['FismaType']['default'])
	{
		$default_button = $this->Html->link(__('Make Default'), array('action' => 'default', $fisma_type['FismaType']['id']));
	}
	
	$td[$i] = array(
		$fisma_type['FismaType']['name'],
		$fisma_type['FismaType']['export_type'],
		$this->Wrap->yesNo($fisma_type['FismaType']['default']),
		$this->Wrap->yesNo($fisma_type['FismaType']['sendemail']),
		$this->Wrap->check($fisma_type['FismaType']['mon']),
		$this->Wrap->check($fisma_type['FismaType']['tue']),
		$this->Wrap->check($fisma_type['FismaType']['wed']),
		$this->Wrap->check($fisma_type['FismaType']['thu']),
		$this->Wrap->check($fisma_type['FismaType']['fri']),
		$this->Wrap->check($fisma_type['FismaType']['sat']),
		$this->Wrap->check($fisma_type['FismaType']['sun']),
		$this->Local->reviewTimes($fisma_type['FismaType']['notify_time']),
		$fisma_type['FismaType']['notify_email'],
		array(
			$default_button.
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_type['FismaType']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_type['FismaType']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Types'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>