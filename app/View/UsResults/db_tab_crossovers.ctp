<?php

// tab-hijack
$page_options = array();
$page_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), array('action' => 'db_tab_crossovers', 'org'), array('class' => 'tab-hijack'));
$page_options['division'] = $this->Html->link(__('By %s', __('Division')), array('action' => 'db_tab_crossovers', 'division'), array('class' => 'tab-hijack'));
$page_options['branch'] = $this->Html->link(__('By %s', __('Branch')), array('action' => 'db_tab_crossovers', 'branch'), array('class' => 'tab-hijack'));
$page_options['sac'] = $this->Html->link(__('By %s', __('SAC')), array('action' => 'db_tab_crossovers', 'sac'), array('class' => 'tab-hijack'));
$page_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), array('action' => 'db_tab_crossovers', 'owner'), array('class' => 'tab-hijack'));
$page_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), array('action' => 'db_tab_crossovers', 'system'), array('class' => 'tab-hijack'));


$th = array();
$th['UsResult.id'] = array('content' => __('US ID'));
$th['UsResult.ip_address'] = array('content' => __('Ip Address'));
$th['UsResult.host_name'] = array('content' => __('Hostname'));
$th['UsResult.mac_address'] = array('content' => __('Mac Address'));
$th['UsResult.asset_tag'] = array('content' => __('Asset Tag'));
$th['UsResult.path'] = array('content' => __('Crosover Path'));

$barStats = array();
$totals = array();
$td = array();
foreach($results as $resultId => $result)
{
	$td[$resultId] = array();
	
	$td[$resultId]['UsResult.id'] = array(
		$this->Html->link($result['UsResult']['id'], array('controller' => 'us_results', 'action' => 'view', $result['UsResult']['id'])),
		array('class' => 'highlight')
	);
	$td[$resultId]['UsResult.ip_address'] = array(
		$result['UsResult']['ip_address'],
		array('class' => 'highlight')
	);
	$td[$resultId]['UsResult.host_name'] = array(
		$result['UsResult']['host_name'],
		array('class' => 'highlight')
	);
	$td[$resultId]['UsResult.mac_address'] = array(
		$result['UsResult']['mac_address'],
		array('class' => 'highlight')
	);
	$td[$resultId]['UsResult.asset_tag'] = array(
		$result['UsResult']['asset_tag'],
		array('class' => 'highlight')
	);
	$td[$resultId]['UsResult.path'] = array(
		'&nbsp;',
		array('class' => 'highlight')
	);
	
	$j=0;
	foreach($result['crossovers'] as $i => $crossover)
	{
		$j++;
		
		$td[$resultId.$i] = array();
		$td[$resultId.$i]['UsResult.id'] = '&nbsp;';
		$td[$resultId.$i]['UsResult.ip_address'] = '&nbsp;';
		$td[$resultId.$i]['UsResult.host_name'] = '&nbsp;';
		$td[$resultId.$i]['UsResult.mac_address'] = '&nbsp;';
		$td[$resultId.$i]['UsResult.asset_tag'] = '&nbsp;';
		$td[$resultId.$i]['UsResult.path'] = '&nbsp;';
		
		if($result['UsResult']['ip_address'] and isset($crossover['inventory']['ip_addresses']))
			$td[$resultId.$i]['UsResult.ip_address'] = __('Matched: %s', $this->Wrap->filterLink($result['UsResult']['ip_address'], array('controller' => 'fisma_inventories', 'value' => $result['UsResult']['ip_address'])));
			
		if($result['UsResult']['host_name'] and isset($crossover['inventory']['host_names']))
			$td[$resultId.$i]['UsResult.host_name'] = $this->Wrap->filterLink($result['UsResult']['host_name'], array('controller' => 'fisma_inventories', 'value' => $result['UsResult']['host_name']));
			
		if($result['UsResult']['mac_address'] and isset($crossover['inventory']['mac_addresses']))
			$td[$resultId.$i]['UsResult.mac_address'] = $this->Wrap->filterLink($result['UsResult']['mac_address'], array('controller' => 'fisma_inventories', 'value' => $result['UsResult']['mac_address']));
			
		if($result['UsResult']['asset_tag'] and isset($crossover['inventory']['asset_tags']))
			$td[$resultId.$i]['UsResult.asset_tag'] = $this->Wrap->filterLink($result['UsResult']['asset_tag'], array('controller' => 'fisma_inventories', 'value' => $result['UsResult']['asset_tag']));
		
		$td[$resultId.$i]['UsResult.path'] = $this->Contacts->makePath($crossover['object']);
	}
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - Crossovers', __('US Results')),
	'page_subtitle' => __('%s grouped by %s', __('Crossovers'), $scopeName),
	'page_options_title' => __('Change Scope'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
));