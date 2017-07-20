<?php

// tab-hijack
$page_options = [];
$page_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), ['action' => 'db_tab_breakout', 'org', $as_block], ['class' => 'tab-hijack block-hijack']);
$page_options['division'] = $this->Html->link(__('By %s', __('Division')), ['action' => 'db_tab_breakout', 'division', $as_block], ['class' => 'tab-hijack block-hijack']);
$page_options['branch'] = $this->Html->link(__('By %s', __('Branch')), ['action' => 'db_tab_breakout', 'branch', $as_block], ['class' => 'tab-hijack block-hijack']);
$page_options['sac'] = $this->Html->link(__('By %s', __('SAC')), ['action' => 'db_tab_breakout', 'sac', $as_block], ['class' => 'tab-hijack block-hijack']);
$page_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), ['action' => 'db_tab_breakout', 'owner', $as_block], ['class' => 'tab-hijack block-hijack']);
$page_options['fisma_system'] = $this->Html->link(__('By %s', __('FISMA System')), ['action' => 'db_tab_breakout', 'fisma_system', $as_block], ['class' => 'tab-hijack block-hijack']);

$allUrl = ['action' => $this->action];
if(isset($passedArgs[0]))
	$allUrl[0] = $passedArgs[0];
$page_options2 = [
	'all' => $this->Html->link(__('All Results'), $allUrl, ['class' => 'tab-hijack']),
];
foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{
	$page_options2['ReportsStatus.'. $reportsStatus_id] = $this->Html->link(__('With Status: %s', $reportsStatus_name), array_merge($allUrl, ['reports_status_id' => $reportsStatus_id]), ['class' => 'tab-hijack']);
}

$barStatsLabels = [
	'name' => $scopeName,
	'total' => __('FOV Results'),
];

$th = [];
$th['total'] = ['content' => __('Total')];
$th['name'] = ['content' => $scopeName];

$barStats = [];
$totals = [];
$td = [];
foreach($results as $resultId => $result)
{
	$td[$resultId] = [];
	
	$td[$resultId]['total'] = count($result['FovResults']);
	$td[$resultId]['name'] = $this->Html->link($result['name'], $result['url']);
	$path = false;
	if(isset($result['object']))
		$path = __('<br/>(%s)', $this->Contacts->makePath($result['object']));
	
	$td[$resultId]['name'] = __('%s%s', $td[$resultId]['name'], $path);
	
	$barStats[$resultId] = [
		'name' => $result['name'],
		'total' => $td[$resultId]['total'],
	];
	
	$resultIdTable = $resultId.'_table';
	$td[$resultIdTable] = [];
	$td[$resultIdTable]['total'] = false;
	if(in_array($scope, ['system', 'fisma_system']))
	{
		$td[$resultIdTable]['total'] = ['.', [
			'colspan' => 2,
			'ajax_content_url' => ['action' => $scope, $result['id'], $reportsStatusId, 1], 
		]];
	}
	else
	{
		$td[$resultIdTable]['total'] = ['.', [
			'colspan' => 2,
			'ajax_content_url' => ['action' => $scope, $result['id'], 1, 'reports_status_id' => $reportsStatusId], 
		]];
	}
	
	if(!isset($totals['total'])) $totals['total'] = 0;
	$totals['total'] = ($totals['total'] + $td[$resultId]['total']);
}

if(isset($resultId) and isset($td[$resultId]))
{
	$line_count = 0;
	$totals_row['total'] = [__('%s Count: %s', $scopeName, count($results)), ['colspan' => $td[$resultId]]];
	
	if(is_int($resultId))
		array_push($td, $totals_row);
	else
		$td['totals'] = $totals_row;
}

if($as_block)
{
	$j = 0;
	$barStats = Hash::sort($barStats, '{n}.total', 'desc');
	foreach($barStats as $i => $stat)
	{
		$k = 0;
		
		$bar_data[$j] = [$stat['name'], $stat['total']];
		foreach($stat as $k => $v)
		{
			if(preg_match('/^ReportsStatus\./', $k))
			{
				$bar_data[$j][] = $v;
			}
		}
		
		$barStats[$i]['value'] = $stat['total'];
		
		$j++;
	}
	
	$content = $this->element('Utilities.object_dashboard_chart_bar', [
		'title' => '',
		'data' => ['legend' => $barStatsLabels, 'data' => $bar_data],
	]);

	echo $this->element('Utilities.object_dashboard_block', [
		'title' => __('%s - %s grouped by %s', __('Open'), __('Results'), $scopeName),
		'subtitle' => $subtitle,
		'description' => __('Excluding items that have a 0 count.', $scopeName),
		'content' => $content,
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
	]);
}
else
{
	echo $this->element('Utilities.page_index', [
		'page_subtitle' => __('%s - %s grouped by %s', $reportsStatusName, __('Results'), $scopeName),
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
		'page_options_title2' => __('Change Status'),
		'page_options2' => $page_options2,
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
		'use_jsordering' => false,
		'use_float_head' => false,
		'use_collapsible_columns' => false,
		'use_js_exporting' => false,
	]);
}