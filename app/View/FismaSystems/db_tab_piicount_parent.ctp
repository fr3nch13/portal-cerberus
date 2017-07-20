<?php

// tab-hijack
$page_options = array();

$th = array();
$th['path'] = array('content' => __('Path'));
$th['name'] = array('content' => __('GSS Parent'));
$th['pii_count'] = array('content' => __('PII Count'));

$totals = array();
$td = array();
$stats = array();

$stats['total'] = array(
	'name' => __('Total'),
	'value' => 0,
	'color' => 'FFFFFF',
	'pie_exclude' => true,
);

foreach($fismaSystems as $i => $fismaSystem)
{
	$td[$i] = array();
	
	$td[$i]['path'] = $this->Contacts->makePath($fismaSystem);
	$td[$i]['name'] = $this->Html->link($fismaSystem['FismaSystem']['name'], array('action' => 'view', $fismaSystem['FismaSystem']['id']));
	$td[$i]['pii_count'] = $fismaSystem['piiCount'];
	
	$stats['total']['value'] = $totals['pii_count'] = ($stats['total']['value'] + $td[$i]['pii_count']);
	
	// for the block
	$statId = Inflector::slug(strtolower($fismaSystem['FismaSystem']['name']));
	$stats[$statId] = array(
		'name' => $fismaSystem['FismaSystem']['name'],
		'value' => $fismaSystem['piiCount'],
		'color' => substr(md5($fismaSystem['FismaSystem']['name']), 0, 6),
	);
}

$totals_row = array();
if(isset($i) and isset($td[$i]))
{
	$line_count = 0;
	$totals_row['path'] = __('Totals:');
	$totals_row['name'] = count($td);
	foreach($td[$i] as $k => $v)
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
	if(is_int($i))
		array_push($td, $totals_row);
	else
		$td['totals'] = $totals_row;
}

if($as_block)
{
	$stats = Hash::sort($stats, '{s}.value', 'desc');
	$pie_data = array(array(__('%s', __('GSS Parent')), __('PII Count') ));
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
		$stat['value'] = (int)$stat['value'];
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
		'title' => __('%s by %s', __('PII Counts'), __('GSS Parents')),
		'description' => __('Excluding items that have a 0 count. Based on %s grouped by %s', __('FISMA Systems'), __('GSS Parents')),
		'content' => $content,
	));
}
else
{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('PII Counts'),
		'page_subtitle' => __('By %s', __('GSS Parents')),
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
	));
}