<?php 

if(!isset($page_title))
	$page_title = __('All %s Items', __('FISMA Inventory'));

$page_options = (isset($page_options)?$page_options:array());

$use_multiselect = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$use_multiselect = true;
	if(!isset($page_options['add']))
		$page_options['add'] = $this->Html->link(__('Add %s Item', __('FISMA Inventory')), array('action' => 'add', 'saa' => true));
	if(!isset($page_options['add_many']))
		$page_options['add_many'] = $this->Html->link(__('Add Many %s Items', __('FISMA Inventory')), array('action' => 'batch_add', 'saa' => true));
}

/*
if(!isset($page_options['nsat_export_csv']))
	$page_options['nsat_export_csv'] = $this->Html->link(__('Export to NSAT Format - CSV'), array('nsat', 'ext' => 'csv'));
*/

// content
$th = array();
$th['FismaInventory.id'] = array('content' => __('ID'), 'options' => array('sort' => 'FismaInventory.id'));
$th['FismaSystem.parent'] = array('content' => __('GSS Parent'));
$th['FismaInventory.fisma_system_id'] = array('content' => __('FISMA System'), 'options' => array('sort' => 'FismaSystem.name', 'editable' => array('type' => 'select', 'options' => $fismaSystems, 'searchable' => true)));
$th['FismaSystem.fullname'] = array('content' => __('FISMA System Full Name'), 'options' => array('sort' => 'FismaSystem.fullname'));
$th['FismaSystem.owner'] = array('content' => __('System Owner'), 'options' => array('sort' => 'FismaSystem.owner_contact_id'));
$th['FismaSystem.fisma_system_hosting_id'] = array('content' => __('AHE Hosting'), 'options' => array('sort' => 'FismaSystem.fisma_system_hosting_id', 'class' => 'divider'));
$th['FismaInventory.ip_address'] = array('content' => __('IP Address'), 'options' => array('sort' => 'FismaInventory.ip_address', 'editable' => array('type' => 'text') ));
$th['FismaInventory.rule_count'] = array('content' => __('F/W Rules'));
$th['FismaInventory.result_counts'] = array('content' => __('# US/EOL/PT/HR'));
	
$th['FismaInventory.name'] = array('content' => __('Friendly Name'), 'options' => array('sort' => 'FismaInventory.name', 'editable' => array('type' => 'text') ));
$th['FismaInventory.mac_address'] = array('content' => __('MAC Address'), 'options' => array('sort' => 'FismaInventory.mac_address', 'editable' => array('type' => 'text') ));
$th['FismaInventory.nat_ip_address'] = array('content' => __('NAT IP Address'), 'options' => array('sort' => 'FismaInventory.nat_ip_address', 'editable' => array('type' => 'text') ));
$th['FismaInventory.dns_name'] = array('content' => __('DNS Name'), 'options' => array('sort' => 'FismaInventory.dns_name', 'editable' => array('type' => 'text') ));
$th['FismaInventory.asset_tag'] = array('content' => __('Asset Tag'), 'options' => array('sort' => 'FismaInventory.asset_tag', 'editable' => array('type' => 'text') ));
$th['FismaInventory.location'] = array('content' => __('Location'), 'options' => array('sort' => 'FismaInventory.location', 'editable' => array('type' => 'text') ));
$th['FismaInventory.fisma_type_id'] = array('content' => __('Type'), 'options' => array('sort' => 'FismaType.name', 'editable' => array('type' => 'select', 'options' => $fismaTypes, 'searchable' => true) ));
$th['FismaInventory.fisma_status_id'] = array('content' => __('Status'), 'options' => array('sort' => 'FismaStatus.name', 'editable' => array('type' => 'select', 'options' => $fismaStatuses, 'searchable' => true) ));
$th['FismaInventory.fisma_source_id'] = array('content' => __('Source'), 'options' => array('sort' => 'FismaSource.name', 'editable' => array('type' => 'select', 'options' => $fismaSources, 'searchable' => true) ));
$th['FismaInventory.purpose'] = array('content' => __('Purpose'), 'options' => array('sort' => 'FismaInventory.purpose', 'editable' => array('type' => 'text') ));
$th['FismaInventory.tags'] = array('content' => __('Tags'));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));
$th['multiselect'] = $use_multiselect;

$td = array();
foreach ($fisma_inventories as $i => $fisma_inventory)
{
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $fisma_inventory['FismaInventory']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_inventory['FismaInventory']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_inventory['FismaInventory']['id'], 'saa' => true),array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$edit_id = array(
		'FismaInventory' => $fisma_inventory['FismaInventory']['id'],
	);
	
	$fismaSystemParent = false;
	if(isset($fisma_inventory['FismaSystem']['FismaSystemParent']['id']))
	{
		$fismaSystemParent = $this->Html->link($fisma_inventory['FismaSystem']['FismaSystemParent']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_inventory['FismaSystem']['FismaSystemParent']['id']));
	}
	$fismaSystemOwner = false;
	if(isset($fisma_inventory['FismaSystem']['OwnerContact']['id']))
	{
		$fismaSystemOwner = $this->Html->link($fisma_inventory['FismaSystem']['OwnerContact']['name'], array('controller' => 'ad_accounts', 'action' => 'view', $fisma_inventory['FismaSystem']['OwnerContact']['id']));
	}
	$aheHosting = false;
	if(isset($fisma_inventory['FismaSystem']['FismaSystemHosting']['id']))
	{
		$aheHosting = $fisma_inventory['FismaSystem']['FismaSystemHosting']['name'];
	}
	
	$rule_count = '0 ';
	
	$counts = $this->ReportResults->ajaxCountsLinks($fisma_inventory['FismaInventory'], 'fisma_inventory', ['prefix' => false]);
	
	$td[$i] = array();
	$td[$i]['FismaInventory.id'] = $this->Html->link($fisma_inventory['FismaInventory']['id'], array('action' => 'view', $fisma_inventory['FismaInventory']['id']));
	$td[$i]['FismaSystem.parent'] = $fismaSystemParent;
	$td[$i]['FismaInventory.fisma_system_id'] = array(
			$this->Html->link($fisma_inventory['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_inventory['FismaSystem']['id'])),
			array('value' => $fisma_inventory['FismaSystem']['id']),
		);
	$td[$i]['FismaSystem.fullname'] = array(
			$this->Html->link($fisma_inventory['FismaSystem']['fullname'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_inventory['FismaSystem']['id'])),
			array('value' => $fisma_inventory['FismaSystem']['id']),
		);
	$td[$i]['FismaSystem.owner'] = $fismaSystemOwner;
	$td[$i]['FismaSystem.fisma_system_hosting_id'] = array($aheHosting, array('class' => 'divider'));
	$td[$i]['FismaInventory.ip_address'] = $fisma_inventory['FismaInventory']['ip_address'];
	$td[$i]['FismaInventory.rule_count'] = $rule_count;
	$td[$i]['FismaInventory.result_counts'] = $counts;

	$td[$i]['FismaInventory.name'] = $this->Html->link($fisma_inventory['FismaInventory']['name'], array('action' => 'view', $fisma_inventory['FismaInventory']['id']));
	$td[$i]['FismaInventory.mac_address'] = $fisma_inventory['FismaInventory']['mac_address'];
	$td[$i]['FismaInventory.nat_ip_address'] = $fisma_inventory['FismaInventory']['nat_ip_address'];
	$td[$i]['FismaInventory.dns_name'] = $fisma_inventory['FismaInventory']['dns_name'];
	$td[$i]['FismaInventory.asset_tag'] = $fisma_inventory['FismaInventory']['asset_tag'];
	$td[$i]['FismaInventory.location'] = $fisma_inventory['FismaInventory']['location'];
	$td[$i]['FismaInventory.fisma_type_id'] = array(
		$this->Html->link($fisma_inventory['FismaType']['name'], array('action' => 'type', $fisma_inventory['FismaType']['id'])),
		array('value' => $fisma_inventory['FismaType']['id']),
	);
	$td[$i]['FismaInventory.fisma_status_id'] = array(
		$this->Html->link($fisma_inventory['FismaStatus']['name'], array('action' => 'status', $fisma_inventory['FismaStatus']['id'])),
		array('value' => $fisma_inventory['FismaStatus']['id']),
	);
	$td[$i]['FismaInventory.fisma_source_id'] = array(
		$this->Html->link($fisma_inventory['FismaSource']['name'], array('action' => 'source', $fisma_inventory['FismaSource']['id'])),
		array('value' => $fisma_inventory['FismaSource']['id']),
	);
	$td[$i]['FismaInventory.purpose'] = $fisma_inventory['FismaInventory']['purpose'];
	$td[$i]['FismaInventory.tags'] = (isset($fisma_inventory['Tag'])?$this->Tag->linkTags($fisma_inventory['Tag']):false);
	$td[$i]['actions'] = array(
		$actions, 
		array('class' => 'actions'),
	);
	$td[$i]['multiselect'] = $fisma_inventory['FismaInventory']['id'];
	$td[$i]['edit_id'] = $edit_id;
}

echo $this->element('Utilities.page_index', array(
	'page_title' => $page_title,
	'page_subtitle' => (isset($page_subtitle)?$page_subtitle:false),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'table_caption' => __('US: %s, EOL: %s, PT: %s, HR: %s', __('Unsupported Software'), __('End of Life'), __('Penetration Test'), __('High Risk Vulnerabilities')),
	
	// grid/inline edit options
	'use_gridedit' => $use_multiselect,
//	'use_gridadd' => $use_multiselect,
//	'use_griddelete' => $use_multiselect,
	
	// multiselect options
	'use_multiselect' => $use_multiselect,
	'multiselect_options' => array(
		'fisma_system' => __('Set all selected %s to one %s', __('FISMA Inventory Items'), __('FISMA System')),
		'multi_fisma_system' => __('Set each selected %s to a %s individually', __('FISMA Inventory Items'), __('FISMA System')),
		'fisma_type' => __('Set all selected %s to one %s', __('FISMA Inventory Items'), __('Type')),
		'multi_fisma_type' => __('Set each selected %s to a %s individually', __('FISMA Inventory Items'), __('Type')),
		'fisma_status' => __('Set all selected %s to one %s', __('FISMA Inventory Items'), __('Status')),
		'multi_fisma_status' => __('Set each selected %s to a %s individually', __('FISMA Inventory Items'), __('Status')),
		'fisma_source' => __('Set all selected %s to one %s', __('FISMA Inventory Items'), __('Source')),
		'multi_fisma_source' => __('Set each selected %s to a %s individually', __('FISMA Inventory Items'), __('Source')),
		'tag' => __('Add %s all selected %s', __('Tags'), __('FISMA Inventory Items')),
		'multi_tag' => __('Update the %s of each %s invidivually', __('Tags'), __('FISMA Inventory Items')),
	),
	'multiselect_referer' => array(
		'admin' => $this->params['admin'],
		'controller' => $this->params['controller'],
		'action' => $this->params['action'],
		'saa' => false,
	),
));