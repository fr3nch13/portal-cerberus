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
$th['EolResult.id'] = array('content' => __('EOL ID'));
$th['EolResult.ip_address'] = array('content' => __('Ip Address'));
$th['EolResult.host_name'] = array('content' => __('Hostname'));
$th['EolResult.mac_address'] = array('content' => __('Mac Address'));
$th['EolResult.asset_tag'] = array('content' => __('Asset Tag'));
$th['EolResult.path'] = array('content' => __('Crosover Path'));

$barStats = array();
$totals = array();
$td = array();
foreach($results as $resultId => $result)
{
	$td[$resultId] = array();
	
	$td[$resultId]['EolResult.id'] = array(
		$this->Html->link($result['EolResult']['id'], array('controller' => 'eol_results', 'action' => 'view', $result['EolResult']['id'])),
		array('class' => 'highlight')
	);
	$td[$resultId]['EolResult.ip_address'] = array(
		$result['EolResult']['ip_address'],
		array('class' => 'highlight')
	);
	$td[$resultId]['EolResult.host_name'] = array(
		$result['EolResult']['host_name'],
		array('class' => 'highlight')
	);
	$td[$resultId]['EolResult.mac_address'] = array(
		$result['EolResult']['mac_address'],
		array('class' => 'highlight')
	);
	$td[$resultId]['EolResult.asset_tag'] = array(
		$result['EolResult']['asset_tag'],
		array('class' => 'highlight')
	);
	$td[$resultId]['EolResult.path'] = array(
		'&nbsp;',
		array('class' => 'highlight')
	);
	
	$j=0;
	foreach($result['crossovers'] as $i => $crossover)
	{
		$j++;
		
		$td[$resultId.$i] = array();
		$td[$resultId.$i]['EolResult.id'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.ip_address'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.host_name'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.mac_address'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.asset_tag'] = '&nbsp;';
		$td[$resultId.$i]['EolResult.path'] = '&nbsp;';
		
		if($result['EolResult']['ip_address'] and isset($crossover['inventory']['ip_addresses']))
			$td[$resultId.$i]['EolResult.ip_address'] = __('Matched: %s', $this->Wrap->filterLink($result['EolResult']['ip_address'], array('controller' => 'fisma_inventories', 'value' => $result['EolResult']['ip_address'])));
			
		if($result['EolResult']['host_name'] and isset($crossover['inventory']['host_names']))
			$td[$resultId.$i]['EolResult.host_name'] = $this->Wrap->filterLink($result['EolResult']['host_name'], array('controller' => 'fisma_inventories', 'value' => $result['EolResult']['host_name']));
			
		if($result['EolResult']['mac_address'] and isset($crossover['inventory']['mac_addresses']))
			$td[$resultId.$i]['EolResult.mac_address'] = $this->Wrap->filterLink($result['EolResult']['mac_address'], array('controller' => 'fisma_inventories', 'value' => $result['EolResult']['mac_address']));
			
		if($result['EolResult']['asset_tag'] and isset($crossover['inventory']['asset_tags']))
			$td[$resultId.$i]['EolResult.asset_tag'] = $this->Wrap->filterLink($result['EolResult']['asset_tag'], array('controller' => 'fisma_inventories', 'value' => $result['EolResult']['asset_tag']));
		
		$td[$resultId.$i]['EolResult.path'] = $this->Contacts->makePath($crossover['object']);
	}
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - Crossovers', __('EOL Results')),
	'page_subtitle' => __('%s grouped by %s', __('Crossovers'), $scopeName),
	'page_options_title' => __('Change Scope'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
));