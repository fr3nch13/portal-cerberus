<?php 
// File: app/View/FismaSystemImpacts/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Impact')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemImpact.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemImpact.name')),
	'FismaSystemImpact.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemImpact.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_impacts as $i => $fisma_system_impact)
{
	$td[$i] = array(
		$fisma_system_impact['FismaSystemImpact']['name'],
		$fisma_system_impact['FismaSystemImpact']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_impact['FismaSystemImpact']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_impact['FismaSystemImpact']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Impacts')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));