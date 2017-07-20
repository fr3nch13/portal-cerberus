<?php 

$page_options = array(
	$this->Html->link(__('Add a %s', __('%s - %s', __('FISMA System'), __('Affected Party Option')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemAffectedParty.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemAffectedParty.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_affected_parties as $i => $fisma_system_affected_party)
{
	$td[$i] = array(
		$fisma_system_affected_party['FismaSystemAffectedParty']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_affected_party['FismaSystemAffectedParty']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_affected_party['FismaSystemAffectedParty']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Affected Party Options')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'search_placeholder' => __('Affected Party Options'),
));