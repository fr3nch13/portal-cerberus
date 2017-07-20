<?php 
// File: app/View/Subnets/admin_index.ctp


$page_options = array();

if($this->Common->roleCheck(array('admin')) and $this->Common->isAdmin())
{
	$page_options[] = $this->Html->link(__('Add %s', __('Subnet') ), array('action' => 'add', 'admin' => true));
	$page_options[] = $this->Html->link(__('Import %s', __('Subnets') ), array('action' => 'batcher_step1', 'admin' => true));
}

// content
$th = array(
	//'Subnet.name' => array('content' => __('Name'), 'options' => array('sort' => 'Subnet.name')),
	'Subnet.cidr' => array('content' => __('CIDR'), 'options' => array('sort' => 'Subnet.cidr')),
	'Subnet.netmask' => array('content' => __('Netmask'), 'options' => array('sort' => 'Subnet.netmask')),
	'Subnet.ip_start' => array('content' => __('First IP Address'), 'options' => array('sort' => 'Subnet.ip_start')),
	'Subnet.ip_end' => array('content' => __('Last IP Address'), 'options' => array('sort' => 'Subnet.ip_end')),
	'Subnet.fisma_inventory_count' => array('content' => __('FISMA Inventory Count'), 'options' => array('sort' => 'Subnet.fisma_inventory_count')),
	'Subnet.us_result_count' => array('content' => __('US Count'), 'options' => array('sort' => 'Subnet.us_result_count')),
	'Subnet.eol_result_count' => array('content' => __('EOL Count'), 'options' => array('sort' => 'Subnet.eol_result_count')),
	'Subnet.pen_test_result_count' => array('content' => __('PT Count'), 'options' => array('sort' => 'Subnet.pen_test_result_count')),
	'Subnet.high_risk_result_count' => array('content' => __('HR Count'), 'options' => array('sort' => 'Subnet.high_risk_result_count')),
	'Subnet.ic' => array('content' => __('IC'), 'options' => array('sort' => 'Subnet.ic')),
	'Subnet.location' => array('content' => __('Location'), 'options' => array('sort' => 'Subnet.location')),
	'Subnet.comments' => array('content' => __('Comments'), 'options' => array('sort' => 'Subnet.comments')),
	'Subnet.dhcp' => array('content' => __('DHCP?'), 'options' => array('sort' => 'Subnet.dhcp')),
	'Subnet.dhcp_scope' => array('content' => __('DHCP Scope'), 'options' => array('sort' => 'Subnet.dhcp_scope')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($subnet_members as $i => $subnet_member)
{
	$actions = '';
	$cidr = $subnet_member['Subnet']['cidr'];
	
	if($this->Common->roleCheck(array('admin')))
	{
		$cidr = $this->Html->link($cidr, array('controller' => 'subnets', 'action' => 'view', $subnet_member['Subnet']['id'], 'admin' => true));
		
		$actions = $this->Html->link(__('View'), array('controller' => 'subnets', 'action' => 'view', $subnet_member['Subnet']['id'], 'admin' => true)).
			$this->Html->link(__('Edit'), array('controller' => 'subnets', 'action' => 'edit', $subnet_member['Subnet']['id'], 'admin' => true)).
			$this->Html->link(__('Rescan'), array('controller' => 'subnets', 'action' => 'rescan', $subnet_member['Subnet']['id'], 'admin' => true)).
			$this->Html->link(__('Delete'), array('controller' => 'subnets', 'action' => 'delete', $subnet_member['Subnet']['id'], 'admin' => true), array('confirm' => 'Are you sure?')); 
			
	}
	
	$td[$i] = array(
		//$subnet_member['Subnet']['name'],
		$cidr,
		$subnet_member['Subnet']['netmask'],
		$subnet_member['Subnet']['ip_start'],
		$subnet_member['Subnet']['ip_end'],
		$subnet_member['Subnet']['fisma_inventory_count'],
		$subnet_member['Subnet']['us_result_count'],
		$subnet_member['Subnet']['eol_result_count'],
		$subnet_member['Subnet']['pen_test_result_count'],
		$subnet_member['Subnet']['high_risk_result_count'],
		$subnet_member['Subnet']['ic'],
		$subnet_member['Subnet']['location'],
		$subnet_member['Subnet']['comments'],
		$this->Wrap->yesNo($subnet_member['Subnet']['dhcp']),
		$subnet_member['Subnet']['dhcp_scope'],
		array(
			$actions,
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Subnets'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));