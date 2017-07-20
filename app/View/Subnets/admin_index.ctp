<?php 
// File: app/View/Subnets/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Subnet') ), array('action' => 'add')),
	$this->Html->link(__('Import %s', __('Subnets') ), array('action' => 'batcher_step1')),
	$this->Html->link(__('Rescan All %s', __('Subnets') ), array('action' => 'rescan_all')),
);

// content
$th = array(
	//'Subnet.name' => array('content' => __('Name'), 'options' => array('sort' => 'Subnet.name')),
	'Subnet.cidr' => array('content' => __('CIDR'), 'options' => array('sort' => 'Subnet.cidr')),
	'Subnet.netmask' => array('content' => __('Netmask'), 'options' => array('sort' => 'Subnet.netmask')),
	'Subnet.ip_start' => array('content' => __('First IP Address'), 'options' => array('sort' => 'Subnet.ip_start')),
	'Subnet.ip_end' => array('content' => __('Last IP Address'), 'options' => array('sort' => 'Subnet.ip_end')),
	'Subnet.fisma_inventory_count' => array('content' => __('# FISMA Inventory'), 'options' => array('sort' => 'Subnet.fisma_inventory_count')),
	'Subnet.fisma_inventory_percent' => array('content' => __('Saturation'), 'options' => array('sort' => 'Subnet.fisma_inventory_percent')),
	'Subnet.us_result_count' => array('content' => __('# US'), 'options' => array('sort' => 'Subnet.us_result_count')),
	'Subnet.eol_result_count' => array('content' => __('# EOL'), 'options' => array('sort' => 'Subnet.eol_result_count')),
	'Subnet.pen_test_result_count' => array('content' => __('# PT'), 'options' => array('sort' => 'Subnet.pen_test_result_count')),
	'Subnet.high_risk_result_count' => array('content' => __('# HRV'), 'options' => array('sort' => 'Subnet.high_risk_result_count')),
//	'Subnet.ip_counts' => array('content' => __('# Rules Src/Dst/Combined')),
	'Subnet.ic' => array('content' => __('IC'), 'options' => array('sort' => 'Subnet.ic')),
	'Subnet.location' => array('content' => __('Location'), 'options' => array('sort' => 'Subnet.location')),
	'Subnet.comments' => array('content' => __('Comments'), 'options' => array('sort' => 'Subnet.comments')),
	'Subnet.dhcp' => array('content' => __('DHCP?'), 'options' => array('sort' => 'Subnet.dhcp')),
	'Subnet.dhcp_scope' => array('content' => __('DHCP Scope'), 'options' => array('sort' => 'Subnet.dhcp_scope')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($subnets as $i => $subnet)
{
	$ip_links = array(
		array('url' => array('controller' => 'subnets', 'action' => 'view', $subnet['Subnet']['id'], 'tab' => 'rules_src'), 'ajax_count_url' => array('admin' => false, 'controller' => 'rules', 'action' => 'subnet', $subnet['Subnet']['id'], 'src')),
		array('url' => array('controller' => 'subnets', 'action' => 'view', $subnet['Subnet']['id'], 'tab' => 'rules_dst'), 'ajax_count_url' => array('admin' => false, 'controller' => 'rules', 'action' => 'subnet', $subnet['Subnet']['id'], 'dst')),
		array('url' => array('controller' => 'subnets', 'action' => 'view', $subnet['Subnet']['id'], 'tab' => 'rules'), 'ajax_count_url' => array('admin' => false, 'controller' => 'rules', 'action' => 'subnet', $subnet['Subnet']['id'], 'both')),
	);
	$ip_counts = array('.', array('ajax_count_urls' => $ip_links));
	
	$td[$i] = array(
		//$subnet['Subnet']['name'],
		$this->Html->link($subnet['Subnet']['cidr'], array('controller' => 'subnets', 'action' => 'view', $subnet['Subnet']['id'])),
		$subnet['Subnet']['netmask'],
		$subnet['Subnet']['ip_start'],
		$subnet['Subnet']['ip_end'],
		$subnet['Subnet']['fisma_inventory_count'],
		__('%s%', $subnet['Subnet']['fisma_inventory_percent']),
		$subnet['Subnet']['us_result_count'],
		$subnet['Subnet']['eol_result_count'],
		$subnet['Subnet']['pen_test_result_count'],
		$subnet['Subnet']['high_risk_result_count'],
//		$ip_counts,
		$subnet['Subnet']['ic'],
		$subnet['Subnet']['location'],
		$subnet['Subnet']['comments'],
		$this->Wrap->yesNo($subnet['Subnet']['dhcp']),
		$subnet['Subnet']['dhcp_scope'],
		array(
			$this->Html->link(__('View'), array('controller' => 'subnets', 'action' => 'view', $subnet['Subnet']['id'])).
			$this->Html->link(__('Edit'), array('controller' => 'subnets', 'action' => 'edit', $subnet['Subnet']['id'])).
			$this->Html->link(__('Rescan'), array('controller' => 'subnets', 'action' => 'rescan', $subnet['Subnet']['id'])).
			$this->Html->link(__('Delete'), array('controller' => 'subnets', 'action' => 'delete', $subnet['Subnet']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Subnets'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_jsordering' => true,
));