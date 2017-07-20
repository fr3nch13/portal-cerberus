<?php 
// File: app/View/FismaSoftwareSources/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('FISMA Software Source')), array('action' => 'add')),
);

// content
$th = array(
	'FismaSoftwareSource.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSoftwareSource.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_software_sources as $i => $fisma_software_source)
{	
	$td[$i] = array(
		$fisma_software_source['FismaSoftwareSource']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_software_source['FismaSoftwareSource']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_software_source['FismaSoftwareSource']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Software Sources'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));