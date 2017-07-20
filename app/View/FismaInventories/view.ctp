<?php 
$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_inventory['FismaInventory']['id'], 'saa' => true));
	$page_options[] = $this->Form->postLink(__('Delete'),array('action' => 'delete', $fisma_inventory['FismaInventory']['id'], 'saa' => true),array('confirm' => 'Are you sure?'));
}

$details_left = array();
$details_left[] = array('name' => __('Friendly Name'), 'value' => $fisma_inventory['FismaInventory']['name']);
$details_left[] = array('name' => __('MAC Address'), 'value' => $fisma_inventory['FismaInventory']['mac_address']);
$details_left[] = array('name' => __('Asset Tag'), 'value' => $fisma_inventory['FismaInventory']['asset_tag']);
$details_left[] = array('name' => __('DNS Name'), 'value' => $fisma_inventory['FismaInventory']['dns_name']);
$details_left[] = array('name' => __('IP Address'), 'value' => $fisma_inventory['FismaInventory']['ip_address']);
$details_left[] = array('name' => __('NAT IP Address'), 'value' => $fisma_inventory['FismaInventory']['nat_ip_address']);
$details_left[] = array('name' => __('Location'), 'value' => $fisma_inventory['FismaInventory']['location']);
$details_left[] = array('name' => __('Purpose'), 'value' => $fisma_inventory['FismaInventory']['purpose']);
$details_left[] = array('name' => __('FISMA System'), 'value' => $this->Html->link($fisma_inventory['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_inventory['FismaSystem']['id'])));

$details_right = array();
//$details_right[] = array('name' => __('Contact Name'), 'value' => $fisma_inventory['FismaInventory']['contact_name']);
//$details_right[] = array('name' => __('Contact Email'), 'value' => $this->Html->link($fisma_inventory['FismaInventory']['contact_email'], 'mailto:'. $fisma_inventory['FismaInventory']['contact_email']));
$details_right[] = array('name' => __('URL'), 'value' => $fisma_inventory['FismaInventory']['url']);
$details_right[] = array('name' => __('Type'), 'value' => $this->Html->link($fisma_inventory['FismaType']['name'], array('action' => 'type', $fisma_inventory['FismaType']['id'])));
$details_right[] = array('name' => __('Export Type'), 'value' => $this->Html->link($fisma_inventory['FismaType']['export_type'], array('action' => 'type', $fisma_inventory['FismaType']['id'])));
$details_right[] = array('name' => __('Status'), 'value' => $this->Html->link($fisma_inventory['FismaStatus']['name'], array('action' => 'status', $fisma_inventory['FismaStatus']['id'])));
$details_right[] = array('name' => __('Source'), 'value' => $this->Html->link($fisma_inventory['FismaSource']['name'], array('action' => 'source', $fisma_inventory['FismaSource']['id'])));
$details_right[] = array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fisma_inventory['FismaInventory']['created']));
$details_right[] = array('name' => __('Created By'), 'value' => $this->Html->link($fisma_inventory['AddedUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_inventory['AddedUser']['id'])));
$details_right[] = array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fisma_inventory['FismaInventory']['modified']));
$details_right[] = array('name' => __('Last Modified By'), 'value' => $this->Html->link($fisma_inventory['ModifiedUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_inventory['ModifiedUser']['id'])));

$tabs['logs'] = $stats['logs'] = array(
	'id' => 'logs',
	'name' => __('Change Logs'), 
	'ajax_url' => array('controller' => 'fisma_inventory_logs', 'action' => 'fisma_inventory', $fisma_inventory['FismaInventory']['id']),
);
if($this->Wrap->roleCheck(array('admin')))
{
	$tabs['subnets'] = $stats['subnets'] = array(
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => array('controller' => 'subnet_members', 'action' => 'fisma_inventory', $fisma_inventory['FismaInventory']['id'], 'admin' => true),
	);
}
$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'fisma_inventory', $fisma_inventory['FismaInventory']['id']),
);
$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'fisma_inventory', $fisma_inventory['FismaInventory']['id']),
);
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'fisma_inventory', $fisma_inventory['FismaInventory']['id']),
);
$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'fisma_inventory', $fisma_inventory['FismaInventory']['id']),
);
$tabs['notes'] = array(
	'key' => 'notes',
	'title' => __('%s Notes', $fisma_inventory['FismaInventory']['name']),
	'content' => $this->Wrap->descView($fisma_inventory['FismaInventory']['notes']),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'fisma_inventory', $fisma_inventory['FismaInventory']['id']),
);

$fisma_inventory_name = $fisma_inventory['FismaInventory']['name'];
if(!$fisma_inventory_name)
	$fisma_inventory_name = $fisma_inventory['FismaInventory']['asset_tag'];
if(!$fisma_inventory_name)
	$fisma_inventory_name = $fisma_inventory['FismaInventory']['dns_name'];
if(!$fisma_inventory_name)
	$fisma_inventory_name = $fisma_inventory['FismaInventory']['ip_address'];
if(!$fisma_inventory_name)
	$fisma_inventory_name = $fisma_inventory['FismaInventory']['mac_address'];

echo $this->element('Utilities.page_compare', array(
	'page_title' => __('%s: %s', __('FISMA Inventory'), $fisma_inventory_name),
	'page_subtitle2' => $this->Contacts->makePath($fisma_inventory),
	'page_options' => $page_options,
	'details_left_title' => ' ',
	'details_left' => $details_left,
	'details_right_title' => ' ',
	'details_right' => $details_right,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));