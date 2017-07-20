<?php

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($usResults)),
	'resolveDateSoon' => array('name' => __('%s/Resolve Date within 10 days', __('Open')), 'value' => 0),
	'resolveDatePast' => array('name' => __('%s/Resolve Date has Passed', __('Open')), 'value' => 0),
);

foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{	
	if(!isset($stats['ReportsStatus.'.$reportsStatus_id]))
		$stats['ReportsStatus.'.$reportsStatus_id] = array('name' => __('With Status - %s', $reportsStatus_name), 'value' => 0);
}

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
foreach($usResults as $usResult)
{
	$highlightDueDate = false;
	if(isset($usResult['UsResult']['resolved_by_date']) 
		and isset($usResult['ReportsStatus']['name'])
		and $usResult['ReportsStatus']['slug'] == 'open')
	{
		$resolvedByDate = strtotime($usResult['UsResult']['resolved_by_date']);
		if($resolvedByDate <= $thresholdNow)
			$stats['resolveDatePast']['value']++;
		elseif($resolvedByDate <= $thresholdSoon)
			$stats['resolveDateSoon']['value']++;
	}
	
	if($usResult['ReportsStatus']['id'])
		$stats['ReportsStatus.'.$usResult['ReportsStatus']['id']]['value']++;
}

if($stats['resolveDateSoon']['value'])
	$stats['resolveDateSoon']['class'] = 'warning';

if($stats['resolveDatePast']['value'])
	$stats['resolveDatePast']['class'] = 'error';

$content = $this->element('Utilities.object_dashboard_stats', array(
	'title' => false,
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => __('%s - Overview', __('US')),
	'content' => $content,
	'show_bookmark' => false,
));