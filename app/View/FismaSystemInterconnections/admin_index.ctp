<?php 
// File: app/View/FismaSystemInterconnections/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Interconnection')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemInterconnection.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemInterconnection.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_interconnections as $i => $fisma_system_interconnection)
{
	$td[$i] = array(
		$fisma_system_interconnection['FismaSystemInterconnection']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_interconnection['FismaSystemInterconnection']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_interconnection['FismaSystemInterconnection']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Interconnections')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));