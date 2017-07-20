<?php

// tab-hijack
$page_options = array();
$block_options = array();
$page_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), array('action' => 'db_tab_status', 'org'), array('class' => 'tab-hijack'));
$block_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), array('action' => 'db_tab_status', 'org', 1), array('class' => 'block-hijack'));
$page_options['division'] = $this->Html->link(__('By %s', __('Division')), array('action' => 'db_tab_status', 'division'), array('class' => 'tab-hijack'));
$block_options['division'] = $this->Html->link(__('By %s', __('Division')), array('action' => 'db_tab_status', 'division', 1), array('class' => 'block-hijack'));
$page_options['branch'] = $this->Html->link(__('By %s', __('Branch')), array('action' => 'db_tab_status', 'branch'), array('class' => 'tab-hijack'));
$block_options['branch'] = $this->Html->link(__('By %s', __('Branch')), array('action' => 'db_tab_status', 'branch', 1), array('class' => 'block-hijack'));
$page_options['sac'] = $this->Html->link(__('By %s', __('SAC')), array('action' => 'db_tab_status', 'sac'), array('class' => 'tab-hijack'));
$block_options['sac'] = $this->Html->link(__('By %s', __('SAC')), array('action' => 'db_tab_status', 'sac', 1), array('class' => 'block-hijack'));
$page_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), array('action' => 'db_tab_status', 'owner'), array('class' => 'tab-hijack'));
$block_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), array('action' => 'db_tab_status', 'owner', 1), array('class' => 'block-hijack'));
$page_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), array('action' => 'db_tab_status', 'system'), array('class' => 'tab-hijack'));
$block_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), array('action' => 'db_tab_status', 'system', 1), array('class' => 'block-hijack'));

$th = array();
$th['path'] = array('content' => __('Path'));
$th['name'] = array('content' => $scopeName);
$th['total'] = array('content' => __('Total'));

foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['ReportsStatus.'.$reportsStatus_id] = array('content' => $reportsStatus['ReportsStatus']['name'], 'data-color' => $reportsStatus['ReportsStatus']['color_code_hex']);
}

$totals = array();
$td = array();
foreach($results as $resultId => $result)
{
	$td[$resultId] = array();
	
	$td[$resultId]['path'] = false;
	if(isset($result['object']))
		$td[$resultId]['path'] = $this->Contacts->makePath($result['object']);
	
	$td[$resultId]['name'] = $this->Html->link($result['name'], $result['url']);
	$td[$resultId]['total'] = 0;
	
	foreach($reportsStatuses as $reportsStatus)
	{
		$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
		$td[$resultId]['ReportsStatus.'.$reportsStatus_id] = 0;
		foreach($result['UsResults'] as $usResult)
		{
			if($usResult['UsResult']['reports_status_id'] == $reportsStatus_id)
			{
				$td[$resultId]['ReportsStatus.'.$reportsStatus_id]++;
				$td[$resultId]['total']++;
			}
		}
		
		if(!isset($totals['ReportsStatus.'.$reportsStatus_id])) 
			$totals['ReportsStatus.'.$reportsStatus_id] = 0;
		$totals['ReportsStatus.'.$reportsStatus_id] = ($totals['ReportsStatus.'.$reportsStatus_id] + $td[$resultId]['ReportsStatus.'.$reportsStatus_id]);
	
		if($td[$resultId]['ReportsStatus.'.$reportsStatus_id])
			$td[$resultId]['ReportsStatus.'.$reportsStatus_id] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
				'displayValue' => $td[$resultId]['ReportsStatus.'.$reportsStatus_id],
				'colorShow' => true,
				'class' => 'highlight',
			));
	}
	
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
	$regex = '/(\w+\.\d+|total)/';
	
	$stats = array();
	foreach($totals_row as $k => $totals_data)
	{
		$matches = array();
		if(preg_match_all($regex, $k, $matches))
		{
			$name = '';
			if(isset($th[$k]))
				$name = strip_tags($th[$k]['content']);
			if($k == 'total')
			{
				$name = __('Total');
			}
			
			$color = substr(md5($name), 0, 6);
			if(isset($th[$k]['data-color']))
				$color = str_replace('#', '', $th[$k]['data-color']);
			
			$stats[$k] = array(
				'name' => $name,
				'value' => (is_array($totals_data)?$totals_data[0]:$totals_data),
				'color' => $color,
			);
			
			if($k == 'total' or !$stats[$k]['value'])
			{
				$stats[$k]['pie_exclude'] = true;
				$stats[$k]['color'] = 'FFFFFF';
				continue;
			}
		}
	}

	$stats = Hash::sort($stats, '{s}.value', 'desc');
	$pie_data = array(array(__('US Totals'), __('Count') ));
	$pie_options = array('slices' => array());
	foreach($stats as $i => $stat)
	{
		if($i == 'total')
		{
			$stats[$i]['pie_exclude'] = true;
			$stats[$i]['color'] = 'FFFFFF';
			continue;
		}
		if(!$stat['value'])
		{
			unset($stats[$i]);
			continue;
		}
		$pie_data[] = array(__('%s - %s', $stat['value'], $stat['name']), $stat['value'], $i);
		$pie_options['slices'][] = array('color' => '#'. $stat['color']);
	}
	
	$content = $this->element('Utilities.object_dashboard_chart_pie', array(
		'title' => '',
		'data' => $pie_data,
		'options' => $pie_options,
	));
	
	$content .= $this->element('Utilities.object_dashboard_stats', array(
		'title' => '',
		'details' => $stats,
	));

	echo $this->element('Utilities.object_dashboard_block', array(
		'title' => __('%s - %s grouped by %s', __('US'), __('Statuses'), $scopeName),
		'description' => __('Excluding items that have a 0 count. Based on %s related by %s', __('US Results'), $scopeName),
		'content' => $content,
		'page_options' => $block_options,
	));
}
else
{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('%s - Counts', __('US Results')),
		'page_subtitle' => __('%s grouped by %s', __('Statuses'), $scopeName),
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
	));
}