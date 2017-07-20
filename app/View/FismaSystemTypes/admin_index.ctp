<?php 
// File: app/View/FismaSystemTypes/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Type')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemType.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemType.name')),
//	'FismaSystemType.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemType.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_types as $i => $fisma_system_type)
{
	$td[$i] = array(
		$fisma_system_type['FismaSystemType']['name'],
//		$fisma_system_type['FismaSystemType']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_type['FismaSystemType']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_type['FismaSystemType']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Types')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));