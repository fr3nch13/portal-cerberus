<?php

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($poamResults)),
	'resolveDateSoon' => array('name' => __('%s/Resolve Date within 10 days', __('Open')), 'value' => 0),
	'resolveDatePast' => array('name' => __('%s/Resolve Date has Passed', __('Open')), 'value' => 0),
);

foreach($poamStatuses as $poamStatus_id => $poamStatus_name)
{	
	if(!isset($stats['PoamStatus.'.$poamStatus_id]))
		$stats['PoamStatus.'.$poamStatus_id] = array('name' => __('With Status - %s', $poamStatus_name), 'value' => 0);
}

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
foreach($poamResults as $poamResult)
{
	$highlightDueDate = false;
	if(isset($poamResult['PoamResult']['resolved_by_date']) 
		and isset($poamResult['PoamStatus']['name'])
		and $poamResult['PoamStatus']['slug'] == 'open')
	{
		$resolvedByDate = strtotime($poamResult['PoamResult']['resolved_by_date']);
		if($resolvedByDate <= $thresholdNow)
			$stats['resolveDatePast']['value']++;
		elseif($resolvedByDate <= $thresholdSoon)
			$stats['resolveDateSoon']['value']++;
	}
	
	if($poamResult['PoamStatus']['id'])
		$stats['PoamStatus.'.$poamResult['PoamStatus']['id']]['value']++;
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
	'title' => __('%s - Overview', __('POA&M')),
	'content' => $content,
	'show_bookmark' => false,
));