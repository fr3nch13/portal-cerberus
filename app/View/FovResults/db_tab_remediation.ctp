<?php

// tab-hijack
$page_options = [];
$block_options = [];
$page_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), ['action' => 'db_tab_remediation', 'org'], ['class' => 'tab-hijack']);
$block_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), ['action' => 'db_tab_remediation', 'org', 1], ['class' => 'block-hijack']);
$page_options['division'] = $this->Html->link(__('By %s', __('Division')), ['action' => 'db_tab_remediation', 'division'], ['class' => 'tab-hijack']);
$block_options['division'] = $this->Html->link(__('By %s', __('Division')), ['action' => 'db_tab_remediation', 'division', 1], ['class' => 'block-hijack']);
$page_options['branch'] = $this->Html->link(__('By %s', __('Branch')), ['action' => 'db_tab_remediation', 'branch'], ['class' => 'tab-hijack']);
$block_options['branch'] = $this->Html->link(__('By %s', __('Branch')), ['action' => 'db_tab_remediation', 'branch', 1], ['class' => 'block-hijack']);
$page_options['sac'] = $this->Html->link(__('By %s', __('SAC')), ['action' => 'db_tab_remediation', 'sac'], ['class' => 'tab-hijack']);
$block_options['sac'] = $this->Html->link(__('By %s', __('SAC')), ['action' => 'db_tab_remediation', 'sac', 1], ['class' => 'block-hijack']);
$page_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), ['action' => 'db_tab_remediation', 'owner'], ['class' => 'tab-hijack']);
$block_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), ['action' => 'db_tab_remediation', 'owner', 1], ['class' => 'block-hijack']);
$page_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), ['action' => 'db_tab_remediation', 'system'], ['class' => 'tab-hijack']);
$block_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), ['action' => 'db_tab_remediation', 'system', 1], ['class' => 'block-hijack']);

$th = [];
$th['path'] = ['content' => __('Path')];
$th['name'] = ['content' => $scopeName];
$th['total'] = ['content' => __('Total')];

foreach($reportsRemediations as $reportsRemediation_id => $reportsRemediation_name)
{
	$th['ReportsRemediation.'.$reportsRemediation_id] = ['content' => $reportsRemediation_name];
}

$totals = [];
$td = [];
foreach($results as $resultId => $result)
{
	$td[$resultId] = [];
	
	$td[$resultId]['path'] = false;
	if(isset($result['object']))
		$td[$resultId]['path'] = $this->Contacts->makePath($result['object']);
	
	$td[$resultId]['name'] = $this->Html->link($result['name'], $result['url']);
	$td[$resultId]['total'] = 0;
	
	foreach($reportsRemediations as $reportsRemediation_id => $reportsRemediation_name)
	{
		$td[$resultId]['ReportsRemediation.'.$reportsRemediation_id] = 0;
		foreach($result['FovResults'] as $fovResult)
		{
			if($fovResult['FovResult']['reports_remediation_id'] == $reportsRemediation_id)
			{
				$td[$resultId]['ReportsRemediation.'.$reportsRemediation_id]++;
				$td[$resultId]['total']++;
			}
		}
		
		if(!isset($totals['ReportsRemediation.'.$reportsRemediation_id])) 
			$totals['ReportsRemediation.'.$reportsRemediation_id] = 0;
		$totals['ReportsRemediation.'.$reportsRemediation_id] = ($totals['ReportsRemediation.'.$reportsRemediation_id] + $td[$resultId]['ReportsRemediation.'.$reportsRemediation_id]);
	
		if($td[$resultId]['ReportsRemediation.'.$reportsRemediation_id])
			$td[$resultId]['ReportsRemediation.'.$reportsRemediation_id] = [
				$td[$resultId]['ReportsRemediation.'.$reportsRemediation_id],
				['class' => 'highlight'],
			];
	}
	
	if(!isset($totals['total'])) $totals['total'] = 0;
	$totals['total'] = ($totals['total'] + $td[$resultId]['total']);
}

$totals_row = [];
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
			$totals_row[$k] = [
				$totals_row[$k],
				['class' => 'highlight bold'],
			];
	}
	if(is_int($resultId))
		array_push($td, $totals_row);
	else
		$td['totals'] = $totals_row;
}


if($as_block)
{
	$regex = '/(\w+\.\d+|total)/';
	
	$stats = [];
	foreach($totals_row as $k => $totals_data)
	{
		$matches = [];
		if(preg_match_all($regex, $k, $matches))
		{
			$name = '';
			if(isset($th[$k]))
				$name = strip_tags($th[$k]['content']);
			if($k == 'total')
			{
				$name = __('Total');
			}
			
			$stats[$k] = [
				'name' => $name,
				'value' => (is_array($totals_data)?$totals_data[0]:$totals_data),
				'color' => substr(md5($name), 0, 6),
			];
			
			if($k == 'total' or !$stats[$k]['value'])
			{
				$stats[$k]['pie_exclude'] = true;
				$stats[$k]['color'] = 'FFFFFF';
				continue;
			}
		}
	}

	$stats = Hash::sort($stats, '{s}.value', 'desc');
	$pie_data = [[__('FOV Totals'), __('Count') ]];
	$pie_options = ['slices' => []];
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
		$pie_data[] = [__('%s - %s', $stat['value'], $stat['name']), $stat['value'], $i];
		$pie_options['slices'][] = ['color' => '#'. $stat['color']];
	}
	
	$content = $this->element('Utilities.object_dashboard_chart_pie', [
		'title' => '',
		'data' => $pie_data,
		'options' => $pie_options,
	]);
	
	$content .= $this->element('Utilities.object_dashboard_stats', [
		'title' => '',
		'details' => $stats,
	]);

	echo $this->element('Utilities.object_dashboard_block', [
		'title' => __('%s - %s grouped by %s', __('FOV'), __('Remediations'), $scopeName),
		'description' => __('Excluding items that have a 0 count. Based on %s related by %s', __('FOV Results'), $scopeName),
		'content' => $content,
		'page_options' => $block_options,
	]);
}
else
{
	echo $this->element('Utilities.page_index', [
		'page_title' => __('%s - Counts', __('FOV Results')),
		'page_subtitle' => __('%s grouped by %s', __('Remediations'), $scopeName),
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
	]);
}