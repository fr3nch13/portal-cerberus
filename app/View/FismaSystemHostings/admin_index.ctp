<?php 
// File: app/View/FismaSystemHostings/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('AHE Hosting')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemHosting.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemHosting.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_hostings as $i => $fisma_system_hosting)
{
	$td[$i] = array(
		$fisma_system_hosting['FismaSystemHosting']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_hosting['FismaSystemHosting']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_hosting['FismaSystemHosting']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('AHE Hosting')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));