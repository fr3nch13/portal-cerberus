<?php
$page_options = array();
foreach($scopes as $scope => $scopename)
{
	$page_options[$scope] = $this->Html->link(__('By %s', $scopename), array('action' => 'db_tab_status', $scope), array('class' => 'tab-hijack'));
}

$subtitle = __('All Results');
$page_options2 = array();
$page_options2['PoamStatus.0'] = $this->Html->link($subtitle, $this->Html->urlModify(array('poam_status_id' => 0)), array('class' => 'tab-hijack block-hijack'));
foreach($poamStatuses as $poamStatus)
{
	$poamStatus_id = $poamStatus['PoamStatus']['id'];
	$page_options2['PoamStatus.'.$poamStatus_id] = $this->Html->link(__('By Status: %s', $poamStatus['PoamStatus']['name']), $this->Html->urlModify(array('poam_status_id' => $poamStatus_id)), array('class' => 'tab-hijack block-hijack'));
	
	if(isset($this->passedArgs['poam_status_id']) and $this->passedArgs['poam_status_id'] == $poamStatus_id)
		$subtitle = __('With Status: %s', $poamStatus['PoamStatus']['name']);
}

$barStatsLabels = array(
	'name' => $scopeName,
	'total' => __('POA&M Results'),
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
	$td[$resultId]['total'] = count($result['PoamResults']);
	
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
	$bar_data = array();
	foreach($barStats as $i => $stat)
	{
		$k = 0;
		
		$bar_data[$j] = array($stat['name'], $stat['total']);
		foreach($stat as $k => $v)
		{
			if(preg_match('/^PoamStatus\./', $k))
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
		'title' => __('%s - %s grouped by %s', __('POA&M'), __('Totals'), $scopeName),
		'subtitle' => $subtitle,
		'description' => __('Excluding items that have a 0 count. Based on %s related by %s', __('POA&M Results'), $scopeName),
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
		'page_title' => __('%s - Counts', __('POA&M Results')),
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