<?php 
// File: app/View/FismaSystemNists/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('NIST')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemNist.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemNist.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_nists as $i => $fisma_system_nist)
{
	$td[$i] = array(
		$fisma_system_nist['FismaSystemNist']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_nist['FismaSystemNist']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_nist['FismaSystemNist']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('NISTs')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));