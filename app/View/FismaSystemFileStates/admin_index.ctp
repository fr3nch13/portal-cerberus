<?php 
// File: app/View/FismaSystemFileStates/index.ctp

$page_options = array(
	$this->Html->link(__('Add %s', __('FISMA System File State')), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemFileState.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemFileState.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_file_states as $i => $fisma_system_file_state)
{
	$td[$i] = array(
		$fisma_system_file_state['FismaSystemFileState']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_file_state['FismaSystemFileState']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_file_state['FismaSystemFileState']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA System File States'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));