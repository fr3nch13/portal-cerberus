<?php 
// File: app/View/FismaSystemUniquenesses/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Uniqueness')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemUniqueness.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemUniqueness.name')),
	'FismaSystemUniqueness.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemUniqueness.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_uniquenesses as $i => $fisma_system_uniqueness)
{
	$td[$i] = array(
		$fisma_system_uniqueness['FismaSystemUniqueness']['name'],
		$fisma_system_uniqueness['FismaSystemUniqueness']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_uniqueness['FismaSystemUniqueness']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_uniqueness['FismaSystemUniqueness']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Uniquenesses')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));