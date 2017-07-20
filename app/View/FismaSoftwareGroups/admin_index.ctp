<?php 
// File: app/View/FismaSoftwareGroups/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('FISMA Software Group')), array('action' => 'add')),
);

// content
$th = array(
	'FismaSoftwareGroup.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSoftwareGroup.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_software_groups as $i => $fisma_software_group)
{	
	$td[$i] = array(
		$fisma_software_group['FismaSoftwareGroup']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_software_group['FismaSoftwareGroup']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_software_group['FismaSoftwareGroup']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Software Groups'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));