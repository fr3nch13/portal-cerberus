<?php 
// File: app/View/Emails/html/fisma_type_emails.ctp

$this->Html->setFull(true);
//$this->Html->asText(true);

$page_options = array(
	$this->Html->link(_('View these %s', _('FISMA Inventory Items'), array('controller' => 'fisma_inventories', 'action' => 'type', $fisma_type['FismaType']['id'])),
);

// content
$th = array(
	'FismaSystem.name' => array('content' => __('FISMA System'), 'options' => array('sort' => 'FismaSystem.name')),
	'FismaInventory.name' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'FismaInventory.name')),
	'FismaInventory.mac_address' => array('content' => __('MAC Address'), 'options' => array('sort' => 'FismaInventory.mac_address')),
	'FismaInventory.ip_address' => array('content' => __('IP Address'), 'options' => array('sort' => 'FismaInventory.ip_address')),
	'FismaInventory.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'FismaInventory.asset_tag')),
	'FismaType.name' => array('content' => __('Type'), 'options' => array('sort' => 'FismaType.name')),
	'FismaStatus.name' => array('content' => __('Status'), 'options' => array('sort' => 'FismaStatus.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);


$td = array();
foreach ($fisma_inventories as $i => $fisma_inventory)
{
	$actions = array(
		$this->Html->link(__('View'), array('controller' => 'fisma_inventories', 'action' => 'view', $fisma_inventory['FismaInventory']['id'])),
	);
	
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($fisma_inventory['FismaSystem']['name'], array('controller' => 'fisma_isystems', 'action' => 'view', $fisma_inventory['FismaSystem']['id'])),
		$this->Html->link($fisma_inventory['FismaInventory']['name'], array('controller' => 'fisma_inventories', 'action' => 'view', $fisma_inventory['FismaInventory']['id'])),
		$fisma_inventory['FismaInventory']['mac_address'],
		$fisma_inventory['FismaInventory']['ip_address'],
		$fisma_inventory['FismaInventory']['asset_tag'],
		$fisma_inventory['FismaType']['name'],
		$fisma_inventory['FismaStatus']['name'],
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.email_html_index', array(
	'instructions' => $fisma_type['FismaType']['instructions'],
	'page_title' => __('%s Assigned to %s: %s', __('Inventory'), __('FISMA Type'), $fisma_type['FismaType']['name']),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));