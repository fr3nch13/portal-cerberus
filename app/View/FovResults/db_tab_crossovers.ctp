<?php

// tab-hijack
$page_options = [];
$page_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), ['action' => 'db_tab_crossovers', 'org'], ['class' => 'tab-hijack']);
$page_options['division'] = $this->Html->link(__('By %s', __('Division')), ['action' => 'db_tab_crossovers', 'division'], ['class' => 'tab-hijack']);
$page_options['branch'] = $this->Html->link(__('By %s', __('Branch')), ['action' => 'db_tab_crossovers', 'branch'], ['class' => 'tab-hijack']);
$page_options['sac'] = $this->Html->link(__('By %s', __('SAC')), ['action' => 'db_tab_crossovers', 'sac'], ['class' => 'tab-hijack']);
$page_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), ['action' => 'db_tab_crossovers', 'owner'], ['class' => 'tab-hijack']);
$page_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), ['action' => 'db_tab_crossovers', 'system'], ['class' => 'tab-hijack']);


$th = [];
$th['EolResult.id'] = ['content' => __('FOV ID')];
$th['EolResult.ip_address'] = ['content' => __('Ip Address')];
$th['EolResult.host_name'] = ['content' => __('Hostname')];
$th['EolResult.mac_address'] = ['content' => __('Mac Address')];
$th['EolResult.asset_tag'] = ['content' => __('Asset Tag')];
$th['EolResult.path'] = ['content' => __('Crosover Path')];

$barStats = [];
$totals = [];
$td = [];
foreach($results as $resultId => $result)
{
	$td[$resultId] = [];
	
	$td[$resultId]['EolResult.id'] = [
		$this->Html->link($result['FovResult']['id'], ['controller' => 'eol_results', 'action' => 'view', $result['FovResult']['id']]),
		['class' => 'highlight']
	];
	$td[$resultId]['EolResult.ip_address'] = [
		$result['FovResult']['ip_address'],
		['class' => 'highlight']
	];
	$td[$resultId]['EolResult.host_name'] = [
		$result['FovResult']['host_name'],
		['class' => 'highlight']
	];
	$td[$resultId]['EolResult.mac_address'] = [
		$result['FovResult']['mac_address'],
		['class' => 'highlight']
	];
	$td[$resultId]['EolResult.asset_tag'] = [
		$result['FovResult']['asset_tag'],
		['class' => 'highlight']
	];
	$td[$resultId]['EolResult.path'] = [
		'&nbsp;',
		['class' => 'highlight']
	];
	
	$j=0;
	foreach($result['crossovers'] as $i => $crossover)
	{
		$j++;
		$td[$resultId.$i] = [];
		$td[$resultId.$i]['EolResult.id'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.ip_address'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.host_name'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.mac_address'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.asset_tag'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.path'] = '&nbsp;';
		
		if($result['FovResult']['ip_address'] and isset($crossover['inventory']['ip_addresses']))
			$td[$resultId.$i]['EolResult.ip_address'] = __('Matched: %s', $this->Wrap->filterLink($result['FovResult']['ip_address'], ['controller' => 'fisma_inventories', 'value' => $result['FovResult']['ip_address']]));
			
		if($result['FovResult']['host_name'] and isset($crossover['inventory']['host_names']))
			$td[$resultId.$i]['EolResult.host_name'] = $this->Wrap->filterLink($result['FovResult']['host_name'], ['controller' => 'fisma_inventories', 'value' => $result['FovResult']['host_name']]);
			
		if($result['FovResult']['mac_address'] and isset($crossover['inventory']['mac_addresses']))
			$td[$resultId.$i]['EolResult.mac_address'] = $this->Wrap->filterLink($result['FovResult']['mac_address'], ['controller' => 'fisma_inventories', 'value' => $result['FovResult']['mac_address']]);
			
		if($result['FovResult']['asset_tag'] and isset($crossover['inventory']['asset_tags']))
			$td[$resultId.$i]['EolResult.asset_tag'] = $this->Wrap->filterLink($result['FovResult']['asset_tag'], ['controller' => 'fisma_inventories', 'value' => $result['FovResult']['asset_tag']]);
		
		$td[$resultId.$i]['EolResult.path'] = $this->Contacts->makePath($crossover['object']);
	}
}

echo $this->element('Utilities.page_index', [
	'page_title' => __('%s - Crossovers', __('FOV Results')),
	'page_subtitle' => __('%s grouped by %s', __('Crossovers'), $scopeName),
	'page_options_title' => __('Change Scope'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
]);