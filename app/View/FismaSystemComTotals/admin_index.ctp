<?php 
// File: app/View/FismaSystemComTotals/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Communication Total')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemComTotal.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemComTotal.name')),
	'FismaSystemComTotal.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemComTotal.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_com_totals as $i => $fisma_system_com_total)
{
	$td[$i] = array(
		$fisma_system_com_total['FismaSystemComTotal']['name'],
		$fisma_system_com_total['FismaSystemComTotal']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_com_total['FismaSystemComTotal']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_com_total['FismaSystemComTotal']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Communication Totals')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));