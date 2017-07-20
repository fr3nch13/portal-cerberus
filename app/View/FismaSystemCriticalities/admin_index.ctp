<?php 

$page_options = array(
	$this->Html->link(__('Add a %s', __('%s - %s', __('FISMA System'), __('Criticality Option')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemCriticality.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemCriticality.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_criticalities as $i => $fisma_system_criticality)
{
	$td[$i] = array(
		$fisma_system_criticality['FismaSystemCriticality']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_criticality['FismaSystemCriticality']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_criticality['FismaSystemCriticality']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Criticality Options')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'search_placeholder' => __('Criticality Options'),
));