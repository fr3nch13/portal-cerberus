<?php 
$page_options = array();

// content
$th = array();
$th['org'] = array('content' => __('IC'));
if(!$by_division)
	$th['division'] = array('content' => __('Division'));
$th['name'] = array('content' => __('Name'), 'options' => array('sort' => 'FismaSystem.name'));
$th['all'] = array('content' => __('All'));

foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{
	$th['ReportsStatus.'.$reportsStatus_id] = array('content' => $reportsStatus_name);
	foreach($reportsSeverities as $reportsSeverity_id => $reportsSeverity_name)
	{
		$th['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id] = array('content' => __('%s - %s', $reportsStatus_name, $reportsSeverity_name));
	}
}
if($by_division)
	$th['duplicate'] = array('content' => __('Crossovers'));

$totals = array();
if($reports_severity_id)
{
	$totals_row = array('org' =>  __('Totals:'));
	if(!$by_division)
		$totals_row['division'] = '';
	$totals_row['all'] = 0;
	
	foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
	{
		if(!isset($totals_row['ReportsStatus.'.$reportsStatus_id]))
			$totals_row['ReportsStatus.'.$reportsStatus_id] = 0;
	}
	
	foreach ($fismaSystems as $i => $fismaSystem)
	{
		foreach($fismaSystem['PenTestResults'] as $penTestResult)
		{
			if($penTestResult['PenTestResult']['reports_severity_id'] == $reports_severity_id)
			{
				$totals_row['all']++;
				foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
				{
					if($penTestResult['PenTestResult']['reports_status_id'] == $reportsStatus_id)
					{
						if(!isset($totals_row['ReportsStatus.'.$reportsStatus_id]))
							$totals_row['ReportsStatus.'.$reportsStatus_id] = 0;
						$totals_row['ReportsStatus.'.$reportsStatus_id]++;
					}
				}
			}
		}
	}
}
else 
{
	$td = array();
	foreach ($fismaSystems as $i => $fismaSystem)
	{
		$td[$i] = array();
		$td[$i]['org'] = (isset($fismaSystem['OwnerContact']['Division']['org'])?$fismaSystem['OwnerContact']['Division']['org']:'');
		if(!$by_division)
			$td[$i]['division'] = (isset($fismaSystem['OwnerContact']['Division']['shortname'])?$fismaSystem['OwnerContact']['Division']['shortname']:'');
		
		$td[$i]['name'] = __('%s (%s)', (isset($fismaSystem['FismaSystem']['fullname'])?$fismaSystem['FismaSystem']['fullname']:''), $fismaSystem['FismaSystem']['name']);
		if(isset($fismaSystem['FismaSystem']['id']))
			$td[$i]['name'] = $this->Html->link($td[$i]['name'], array('action' => 'view', $fismaSystem['FismaSystem']['id']));
		
		$td[$i]['all'] = count($fismaSystem['PenTestResults']);
		if(!isset($totals['all'])) $totals['all'] = 0;
		$totals['all'] = ($totals['all'] + count($fismaSystem['PenTestResults']));
		
		$duplicateCount = 0;
		foreach($fismaSystem['PenTestResults'] as $penTestResult)
		{
			$duplicateCount = ($duplicateCount + (isset($penTestResult['duplicate'])?$penTestResult['duplicate']:0));
		}
		
		foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
		{
			$td[$i]['ReportsStatus.'.$reportsStatus_id] = 0;
			foreach($fismaSystem['PenTestResults'] as $penTestResult)
			{
				if($penTestResult['PenTestResult']['reports_status_id'] == $reportsStatus_id)
				{
					$td[$i]['ReportsStatus.'.$reportsStatus_id]++;
				}
			}
			
			if(!isset($totals['ReportsStatus.'.$reportsStatus_id])) 
				$totals['ReportsStatus.'.$reportsStatus_id] = 0;
			$totals['ReportsStatus.'.$reportsStatus_id] = ($totals['ReportsStatus.'.$reportsStatus_id] + $td[$i]['ReportsStatus.'.$reportsStatus_id]);
		
			if($td[$i]['ReportsStatus.'.$reportsStatus_id])
				$td[$i]['ReportsStatus.'.$reportsStatus_id] = array(
					$td[$i]['ReportsStatus.'.$reportsStatus_id],
					array('class' => 'highlight'),
				);
		
			foreach($reportsSeverities as $reportsSeverity_id => $reportsSeverity_name)
			{
				$td[$i]['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id] = 0;
				
				foreach($fismaSystem['PenTestResults'] as $penTestResult)
				{
					if($penTestResult['PenTestResult']['reports_status_id'] == $reportsStatus_id 
						and $penTestResult['PenTestResult']['reports_severity_id'] == $reportsSeverity_id)
					{
						$td[$i]['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id]++;
					}
				}
			
				if(!isset($totals['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id])) 
					$totals['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id] = 0;
				$totals['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id] = ($totals['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id] + $td[$i]['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id]);
		
				if($td[$i]['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id])
					$td[$i]['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id] = array(
						$td[$i]['ReportsStatus.'.$reportsStatus_id.'.ReportsSeverity.'.$reportsSeverity_id],
						array('class' => 'highlight'),
					);
			}
		}
		
		if($by_division)
		{
			$td[$i]['duplicate'] = $duplicateCount;
			if($td[$i]['duplicate'])
				$td[$i]['duplicate'] = array(
					$td[$i]['duplicate'],
					array('class' => 'highlight'),
				);
			if(!isset($totals['duplicate']))
				$totals['duplicate'] = 0;
			
			$totals['duplicate'] = ($totals['duplicate'] + $duplicateCount);
		}
	}
}

$totals_row = array();
if(isset($i) and isset($td[$i]))
{
	$line_count = 0;
	$totals_row = array('org' =>  __('Totals:'));
	if(!$by_division)
		$totals_row['division'] = '';
	$totals_row['name'] = count($td);
	foreach($td[$i] as $k => $v)
	{
		//$totals_row[$k] = false;
		if(isset($totals[$k]))
			$totals_row[$k] = $totals[$k];
		
		if(!isset($totals_row[$k]))
			$totals_row[$k] = false;
		
		if($totals_row[$k])
			$totals_row[$k] = array(
				$totals_row[$k],
				array('class' => 'highlight bold'),
			);
	}
	if(is_int($i))
		array_push($td, $totals_row);
	else
		$td['totals'] = $totals_row;
}

if($as_block)
{
	$regex = '/(\w+\.\d+\.\w+\.\d+|all)/';
	if($reports_severity_id)
		$regex = '/(\w+\.\d+|all)/';
	
	$stats = array();
	foreach($totals_row as $k => $totals_data)
	{
		$matches = array();
		if(preg_match_all($regex, $k, $matches))
		{
			$name = '';
			if(isset($th[$k]))
				$name = strip_tags($th[$k]['content']);
			if($k == 'all')
			{
				$name = __('Total');
			}
			
			$stats[$k] = array(
				'name' => $name,
				'value' => (is_array($totals_data)?$totals_data[0]:$totals_data),
				'color' => substr(md5($name), 0, 6),
			);
			
			if($k == 'all' or !$stats[$k]['value'])
			{
				$stats[$k]['pie_exclude'] = true;
				$stats[$k]['color'] = 'FFFFFF';
				continue;
			}
		}
	}

	$stats = Hash::sort($stats, '{s}.value', 'desc');
	$pie_data = array(array(__('Pen Test Totals'), __('num Status - Severity') ));
	$pie_options = array('slices' => array());
	foreach($stats as $i => $stat)
	{
		if($i == 'all')
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
	
	$title_suffix = '';
	if($reports_severity_id)
	{
		$title_suffix = __(' - Severity: %s', $reportsSeverity['ReportsSeverity']['name']);
	}

	echo $this->element('Utilities.object_dashboard_block', array(
		'title' => __('Related %s Counts%s', __('Pen Test'), $title_suffix),
		'description' => __('Excluding items that have a 0 count.'),
		'content' => $content,
	));
}
else
{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('%s - %s Totals', __('FISMA Systems'), __('Pen Test Results')),
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
	));
}