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
$th['HighRiskResult.id'] = array('content' => __('High Risk ID'));
$th['HighRiskResult.ip_address'] = array('content' => __('Ip Address'));
$th['HighRiskResult.host_name'] = array('content' => __('Hostname'));
$th['HighRiskResult.mac_address'] = array('content' => __('Mac Address'));
$th['HighRiskResult.asset_tag'] = array('content' => __('Asset Tag'));
$th['HighRiskResult.path'] = array('content' => __('Crosover Path'));

$barStats = array();
$totals = array();
$td = array();
foreach($results as $resultId => $result)
{
	$td[$resultId] = array();
	
	$td[$resultId]['HighRiskResult.id'] = array(
		$this->Html->link($result['HighRiskResult']['id'], array('controller' => 'pen_test_results', 'action' => 'view', $result['HighRiskResult']['id'])),
		array('class' => 'highlight')
	);
	$td[$resultId]['HighRiskResult.ip_address'] = array(
		$result['HighRiskResult']['ip_address'],
		array('class' => 'highlight')
	);
	$td[$resultId]['HighRiskResult.host_name'] = array(
		$result['HighRiskResult']['host_name'],
		array('class' => 'highlight')
	);
	$td[$resultId]['HighRiskResult.mac_address'] = array(
		$result['HighRiskResult']['mac_address'],
		array('class' => 'highlight')
	);
	$td[$resultId]['HighRiskResult.asset_tag'] = array(
		$result['HighRiskResult']['asset_tag'],
		array('class' => 'highlight')
	);
	$td[$resultId]['HighRiskResult.path'] = array(
		'&nbsp;',
		array('class' => 'highlight')
	);
	
	$j=0;
	foreach($result['crossovers'] as $i => $crossover)
	{
		$j++;
		
		$td[$resultId.$i] = array();
		$td[$resultId.$i]['HighRiskResult.id'] = '&nbsp;';
		$td[$resultId.$i]['HighRiskResult.ip_address'] = '&nbsp;';
		$td[$resultId.$i]['HighRiskResult.host_name'] = '&nbsp;';
		$td[$resultId.$i]['HighRiskResult.mac_address'] = '&nbsp;';
		$td[$resultId.$i]['HighRiskResult.asset_tag'] = '&nbsp;';
		$td[$resultId.$i]['HighRiskResult.path'] = '&nbsp;';
		
		if($result['HighRiskResult']['ip_address'] and isset($crossover['inventory']['ip_addresses']))
			$td[$resultId.$i]['HighRiskResult.ip_address'] = __('Matched: %s', $this->Wrap->filterLink($result['HighRiskResult']['ip_address'], array('controller' => 'fisma_inventories', 'value' => $result['HighRiskResult']['ip_address'])));
			
		if($result['HighRiskResult']['host_name'] and isset($crossover['inventory']['host_names']))
			$td[$resultId.$i]['HighRiskResult.host_name'] = $this->Wrap->filterLink($result['HighRiskResult']['host_name'], array('controller' => 'fisma_inventories', 'value' => $result['HighRiskResult']['host_name']));
			
		if($result['HighRiskResult']['mac_address'] and isset($crossover['inventory']['mac_addresses']))
			$td[$resultId.$i]['HighRiskResult.mac_address'] = $this->Wrap->filterLink($result['HighRiskResult']['mac_address'], array('controller' => 'fisma_inventories', 'value' => $result['HighRiskResult']['mac_address']));
			
		if($result['HighRiskResult']['asset_tag'] and isset($crossover['inventory']['asset_tags']))
			$td[$resultId.$i]['HighRiskResult.asset_tag'] = $this->Wrap->filterLink($result['HighRiskResult']['asset_tag'], array('controller' => 'fisma_inventories', 'value' => $result['HighRiskResult']['asset_tag']));
		
		$td[$resultId.$i]['HighRiskResult.path'] = $this->Contacts->makePath($crossover['object']);
	}
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - Crossovers', __('High Risk Results')),
	'page_subtitle' => __('%s grouped by %s', __('Crossovers'), $scopeName),
	'page_options_title' => __('Change Scope'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
));