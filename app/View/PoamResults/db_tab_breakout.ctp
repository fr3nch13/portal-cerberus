<?php
$page_options = array();
foreach($scopes as $scopekey => $scopename)
{
	$page_options[$scopekey] = $this->Html->link(__('By %s', $scopename), array('action' => $this->request->action, $scopekey), array('class' => 'tab-hijack'));
	$block_options[$scopekey] = $this->Html->link(__('By %s', $scopename), array('action' => $this->request->action, $scopekey, 1), array('class' => 'block-hijack'));
}

$allUrl = array('action' => $this->action);
if(isset($passedArgs[0]))
	$allUrl[0] = $passedArgs[0];
$page_options2 = array(
	'all' => $this->Html->link(__('All Results'), $allUrl, array('class' => 'tab-hijack')),
);
foreach($poamStatuses as $poamStatus_id => $poamStatus_name)
{
	$page_options2['PoamStatus.'. $poamStatus_id] = $this->Html->link(__('With Status: %s', $poamStatus_name), array_merge($allUrl, array('poam_status_id' => $poamStatus_id)), array('class' => 'tab-hijack'));
}

$barStatsLabels = array(
	'name' => $scopeName,
	'total' => __('POA&M Results'),
);

$th = array();
$th['total'] = array('content' => __('Total'));
$th['name'] = array('content' => $scopeName);

$barStats = array();
$totals = array();
$td = array();

foreach($results as $resultId => $result)
{
	$td[$resultId] = array();
	
	$td[$resultId]['total'] = count($result['PoamResults']);
	$td[$resultId]['name'] = $this->Html->link($result['name'], $result['url']);
	$path = false;
	if(isset($result['object']))
		$path = __('<br/>(%s)', $this->Contacts->makePath($result['object']));
	
	$td[$resultId]['name'] = __('%s%s', $td[$resultId]['name'], $path);
	
	$barStats[$resultId] = array(
		'name' => $result['name'],
		'total' => $td[$resultId]['total'],
	);
	
	$resultIdTable = $resultId.'_table';
	$td[$resultIdTable] = array();
	$td[$resultIdTable]['total'] = false;
	if(in_array($scope, array('system', 'fisma_system')))
	{
		$td[$resultIdTable]['total'] = array('.', array(
			'colspan' => 2,
			'ajax_content_url' => array('action' => 'fisma_system', $result['id'], $poamStatusId, 1), 
		));
	}
	else
	{
		$td[$resultIdTable]['total'] = array('.', array(
			'colspan' => 2,
			'ajax_content_url' => array('action' => $scope, $result['id'], 1, 'poam_status_id' => $poamStatusId), 
		));
	}
	
	if(!isset($totals['total'])) $totals['total'] = 0;
	$totals['total'] = ($totals['total'] + $td[$resultId]['total']);
}

if(isset($resultId) and isset($td[$resultId]))
{
	$line_count = 0;
	$totals_row['total'] = array( __('%s Count: %s', $scopeName, count($results)), array('colspan' => $td[$resultId]));
	
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
		'title' => __('%s - %s grouped by %s', __('Open'), __('Results'), $scopeName),
		'subtitle' => $subtitle,
		'description' => __('Excluding items that have a 0 count.', $scopeName),
		'content' => $content,
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
	));
}
else
{
	echo $this->element('Utilities.page_index', array(
		'page_subtitle' => __('%s - %s grouped by %s', $poamStatusName, __('Results'), $scopeName),
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
	));
}