<?php

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($high_riskResults)),
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
foreach($high_riskResults as $high_riskResult)
{
	$highlightDueDate = false;
	if(isset($high_riskResult['HighRiskResult']['resolved_by_date']) 
		and isset($high_riskResult['ReportsStatus']['name'])
		and $high_riskResult['ReportsStatus']['slug'] == 'open')
	{
		$resolvedByDate = strtotime($high_riskResult['HighRiskResult']['resolved_by_date']);
		if($resolvedByDate <= $thresholdNow)
			$stats['resolveDatePast']['value']++;
		elseif($resolvedByDate <= $thresholdSoon)
			$stats['resolveDateSoon']['value']++;
	}
	
	if($high_riskResult['ReportsStatus']['id'])
		$stats['ReportsStatus.'.$high_riskResult['ReportsStatus']['id']]['value']++;
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
	'title' => __('%s - Overview', __('High Risk')),
	'content' => $content,
	'show_bookmark' => false,
));