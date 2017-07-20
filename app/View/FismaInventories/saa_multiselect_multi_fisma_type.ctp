<?php 
// File: app/View/FismaInventories/saa_multiselect_multi_fisma_type.ctp

// content	
$th = array(
	'FismaInventory.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaInventory.name')),
	'FismaInventory.mac_address' => array('content' => __('MAC Address'), 'options' => array('sort' => 'FismaInventory.mac_address')),
	'FismaInventory.ip_address' => array('content' => __('IP Address'), 'options' => array('sort' => 'FismaInventory.ip_address')),
	'FismaType.name' => array('content' => __('Current %s', __('FISMA Type')), 'options' => array('sort' => 'FismaType.name')),
	'fisma_type_id' => array('content' => __('Select %s', __('FISMA Type')), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_inventories as $i => $fisma_inventory)
{
	$actions = $this->Form->input('FismaInventory.'.$i.'.id', array('type' => 'hidden', 'value' => $fisma_inventory['FismaInventory']['id']));
	$actions .= $this->Form->input('FismaInventory.'.$i.'.fisma_type_id', array(
	        					'div' => false,
	        					'label' => false,
								'empty' => __('[ None ]'),
	        					'options' => $fismaTypes,
	        					'selected' => $fisma_inventory['FismaInventory']['fisma_type_id'],
	        				));
	
	$td[$i] = array(
		$fisma_inventory['FismaInventory']['name'],
		$fisma_inventory['FismaInventory']['mac_address'],
		$fisma_inventory['FismaInventory']['ip_address'],
		$fisma_inventory['FismaType']['name'],
		array(
			$actions,
			array('class' => 'actions'),
		),
	);
}

$before_table = false;
$after_table = false;

if($td)
{
	$before_table = $this->Form->create('FismaInventory');
	$after_table = $this->Form->end(__('Save'));
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Select a %s for each %s', __('FISMA Type'), __('FISMA Inventory Item')),
	'use_search' => false,
	'th' => $th,
	'td' => $td,
	'before_table' => $before_table,
	'after_table' => $after_table,
));