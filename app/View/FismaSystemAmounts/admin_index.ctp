<?php 
// File: app/View/FismaSystemAmounts/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Amount')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemAmount.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemAmount.name')),
	'FismaSystemAmount.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemAmount.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_amounts as $i => $fisma_system_amount)
{
	$td[$i] = array(
		$fisma_system_amount['FismaSystemAmount']['name'],
		$fisma_system_amount['FismaSystemAmount']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_amount['FismaSystemAmount']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_amount['FismaSystemAmount']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Amounts')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));