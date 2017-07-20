<?php 
// File: app/View/FismaSystemGssStatuses/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('GSS Status')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemGssStatus.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemGssStatus.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_gss_statuses as $i => $fisma_system_gss_status)
{
	$td[$i] = array(
		$fisma_system_gss_status['FismaSystemGssStatus']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_gss_status['FismaSystemGssStatus']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_gss_status['FismaSystemGssStatus']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('GSS Statuses')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));