<?php

// tab-hijack
$page_options = array();
$page_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), array('action' => 'db_tab_totals', 'org', $as_block), array('class' => 'tab-hijack block-hijack'));
$page_options['division'] = $this->Html->link(__('By %s', __('Division')), array('action' => 'db_tab_totals', 'division', $as_block), array('class' => 'tab-hijack block-hijack'));
$page_options['branch'] = $this->Html->link(__('By %s', __('Branch')), array('action' => 'db_tab_totals', 'branch', $as_block), array('class' => 'tab-hijack block-hijack'));
$page_options['sac'] = $this->Html->link(__('By %s', __('SAC')), array('action' => 'db_tab_totals', 'sac', $as_block), array('class' => 'tab-hijack block-hijack'));
$page_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), array('action' => 'db_tab_totals', 'owner', $as_block), array('class' => 'tab-hijack block-hijack'));
$page_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), array('action' => 'db_tab_totals', 'system', $as_block), array('class' => 'tab-hijack block-hijack'));

$subtitle = __('All Results');
$page_options2 = array();
$page_options2['ReportsStatus.0'] = $this->Html->link($subtitle, $this->Html->urlModify(array('reports_status_id' => 0)), array('class' => 'tab-hijack block-hijack'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$page_options2['ReportsStatus.'.$reportsStatus_id] = $this->Html->link(__('By Status: %s', $reportsStatus['ReportsStatus']['name']), $this->Html->urlModify(array('reports_status_id' => $reportsStatus_id)), array('class' => 'tab-hijack block-hijack'));
	
	if(isset($this->passedArgs['reports_status_id']) and $this->passedArgs['reports_status_id'] == $reportsStatus_id)
		$subtitle = __('With Status: %s', $reportsStatus['ReportsStatus']['name']);
}

$barStatsLabels = array(
	'name' => $scopeName,
	'total' => __('High Risk Results'),
);

$th = array();
$th['path'] = array('content' => __('Path'));
$th['name'] = array('content' => $scopeName);
$th['total'] = array('content' => __('Total'));

$barStats = array();
$totals = array();
$td = array();
foreach($results as $resultId => $result)
{
	$td[$resultId] = array();
	
	$td[$resultId]['path'] = false;
	if(isset($result['object']))
		$td[$resultId]['path'] = $this->Contacts->makePath($result['object']);
	
	$td[$resultId]['name'] = $this->Html->link($result['name'], $result['url']);
	$td[$resultId]['total'] = count($result['HighRiskResults']);
	
	$barStats[$resultId] = array(
		'name' => $result['name'],
		'total' => $td[$resultId]['total'],
	);
	
	if(!isset($totals['total'])) $totals['total'] = 0;
	$totals['total'] = ($totals['total'] + $td[$resultId]['total']);
}

$totals_row = array();
if(isset($resultId) and isset($td[$resultId]))
{
	$line_count = 0;
	$totals_row['path'] = __('Totals:');
	$totals_row['name'] = count($td);
	foreach($td[$resultId] as $k => $v)
	{
		//$totals_row[$k] = false;
		if(isset($totals[$k]))
			$totals_row[$k] = $totals[$k];
		
		if(!isset($totals_row[$k]))
			$totals_row[$k] = 0;
		
		if($totals_row[$k])
			$totals_row[$k] = array(
				$totals_row[$k],
				array('class' => 'highlight bold'),
			);
	}
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
		
		$bar_data[$j] = array($stat['name'], $stat['total']);
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
	
	$content = $this->element('Utilities.object_dashboard_chart_bar', array(
		'title' => '',
		'data' => array('legend' => $barStatsLabels, 'data' => $bar_data),
	));

	echo $this->element('Utilities.object_dashboard_block', array(
		'title' => __('%s - %s grouped by %s', __('High Risk'), __('Totals'), $scopeName),
		'subtitle' => $subtitle,
		'description' => __('Excluding items that have a 0 count. Based on %s related by %s', __('High Risk Results'), $scopeName),
		'content' => $content,
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
		'page_options_title2' => __('Change Status'),
		'page_options2' => $page_options2,
	));
}
else
{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('%s - Counts', __('High Risk Results')),
		'page_subtitle' => __('%s, grouped by %s', $subtitle, $scopeName),
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
		'page_options_title2' => __('Change Status'),
		'page_options2' => $page_options2,
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
	));
}