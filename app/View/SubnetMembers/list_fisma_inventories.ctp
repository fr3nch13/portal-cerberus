<?php 
// File: app/View/SubnetMembers/list_fisma_inventories.ctp

$page_options = array();

// content
$th = array(
	'FismaInventory.fisma_system_id' => array('content' => __('FISMA System'), 'options' => array('sort' => 'FismaInventory.fisma_system_id')),
	'FismaInventory.name' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'FismaInventory.name')),
	'FismaInventory.mac_address' => array('content' => __('MAC Address'), 'options' => array('sort' => 'FismaInventory.mac_address')),
	'FismaInventory.ip_address' => array('content' => __('IP Address'), 'options' => array('sort' => 'FismaInventory.ip_address')),
	'FismaInventory.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'FismaInventory.asset_tag')),
	'FismaInventory.fisma_stype_id' => array('content' => __('Type'), 'options' => array('sort' => 'FismaInventory.fisma_stype_id')),
	'FismaInventory.fisma_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'FismaInventory.fisma_status_id')),
	'FismaInventory.fisma_source_id' => array('content' => __('Source'), 'options' => array('sort' => 'FismaInventory.fisma_source_id')),
	'FismaInventory.purpose' => array('content' => __('Purpose'), 'options' => array('sort' => 'FismaInventory.purpose')),
	'FismaInventory.tags' => array('content' => __('Tags')),
//	'FismaInventory.contact_name' => array('content' => __('Contact'), 'options' => array('sort' => 'FismaInventory.contact_name')),
//	'FismaInventory.created' => array('content' => __('Created'), 'options' => array('sort' => 'FismaInventory.created')),
//	'FismaInventory.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FismaInventory.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($subnet_members as $i => $subnet_member)
{
	$actions = array(
		$this->Html->link(__('View'), array('controller' => 'fisma_inventories', 'action' => 'view', $subnet_member['FismaInventory']['id'], 'admin' => false)),
		$this->Html->link(__('Edit'), array('controller' => 'fisma_inventories', 'action' => 'edit', $subnet_member['FismaInventory']['id'], 'admin' => false, 'saa' => true)),
	);
	$actions = implode(' ', $actions);
	
	$fisma_type = false;
	if(isset($subnet_member['FismaInventory']['FismaType']['name']))
		$fisma_type = $this->Html->link($subnet_member['FismaInventory']['FismaType']['name'], array('controller' => 'fisma_inventories', 'action' => 'type', $subnet_member['FismaInventory']['FismaType']['id'], 'admin' => false));
	
	$fisma_status = false;
	if(isset($subnet_member['FismaInventory']['FismaStatus']['name']))
		$fisma_status = $this->Html->link($subnet_member['FismaInventory']['FismaStatus']['name'], array('controller' => 'fisma_inventories', 'action' => 'status', $subnet_member['FismaInventory']['FismaStatus']['id'], 'admin' => false));
		
	$fisma_source = false;
	if(isset($subnet_member['FismaInventory']['FismaSource']['name']))
		$fisma_source = $this->Html->link($subnet_member['FismaInventory']['FismaSource']['name'], array('controller' => 'fisma_inventories', 'action' => 'source', $subnet_member['FismaInventory']['FismaSource']['id'], 'admin' => false));
	
	$td[$i] = array(
		$this->Html->link($subnet_member['FismaInventory']['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $subnet_member['FismaInventory']['FismaSystem']['id'], 'admin' => false)),
		$this->Html->link($subnet_member['FismaInventory']['name'], array('controller' => 'fisma_inventories', 'action' => 'view', $subnet_member['FismaInventory']['id'], 'admin' => false)),
		$subnet_member['FismaInventory']['mac_address'],
		$subnet_member['FismaInventory']['ip_address'],
		$subnet_member['FismaInventory']['asset_tag'],
		$fisma_type,
		$fisma_status,
		$fisma_source,
		$subnet_member['FismaInventory']['purpose'],
		$this->Tag->linkTags($subnet_member['FismaInventory']['Tag']),
//		$this->Html->link($subnet_member['FismaInventory']['contact_name'], 'mailto:'. $subnet_member['FismaInventory']['contact_name']),
//		$this->Wrap->niceTime($subnet_member['FismaInventory']['created']),
//		$this->Wrap->niceTime($subnet_member['FismaInventory']['modified']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s for: %s', __('FISMA Inventory'), $subnet['Subnet']['cidr']),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));