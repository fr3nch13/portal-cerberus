<?php 

$page_options = array(
	$this->Html->link(__('Add a %s', __('%s - %s', __('FISMA System'), __('Life Safety Option')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemLifeSafety.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemLifeSafety.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_life_safeties as $i => $fisma_system_life_safety)
{
	$td[$i] = array(
		$fisma_system_life_safety['FismaSystemLifeSafety']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_life_safety['FismaSystemLifeSafety']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_life_safety['FismaSystemLifeSafety']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Life Safety Options')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'search_placeholder' => __('Life Safety Options'),
));