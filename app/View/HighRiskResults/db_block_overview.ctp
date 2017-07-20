<?php

$prefix = false;
if(isset($this->request->params['prefix']) and $this->request->params['prefix'])
	$prefix = $this->request->params['prefix'];

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($high_riskResults)),
);

foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{	
	if(!isset($stats['ReportsStatus.'.$reportsStatus_id]))
		$stats['ReportsStatus.'.$reportsStatus_id] = array('name' => __('With Status - %s', $reportsStatus_name), 'value' => 0);
}

$stats['resolveDateSoon'] = array('name' => __('%s/Resolve Date within 10 days', __('Open')), 'value' => 0);
$stats['resolveDatePast'] = array('name' => __('%s/Resolve Date has Passed', __('Open')), 'value' => 0);

if(!in_array($prefix, array('director')))
{
	$stats['hasFismaSystem'] = array('name' => __('With %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasRogueFismaSystem'] = array('name' => __('With Rogue %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasNotFismaSystem'] = array('name' => __('Without %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasManyFismaSystem'] = array('name' => __('Multiple %s', __('FISMA Systems')), 'value' => 0);
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
	
	if(!in_array($prefix, array('director')))
	{
		$fismaSystemIds = array();
		$inRogue = false;
		if(count($high_riskResult['FismaInventories']))
		{
			foreach($high_riskResult['FismaInventories'] as $fismaInventory)
			{
				if(isset($fismaInventory['FismaSystem']['id']))
				{
					$fismaSystemIds[$fismaInventory['FismaSystem']['id']] = $fismaInventory['FismaSystem']['id'];
					if(isset($fismaInventory['FismaSystem']['is_rogue']) and $fismaInventory['FismaSystem']['is_rogue'] == 2)
						$inRogue = true;
				}
			}
		}
		
		$fismaCount = count($fismaSystemIds);
		if($fismaCount)
		{
			$stats['hasFismaSystem']['value']++;
			if($fismaCount > 1)
				$stats['hasManyFismaSystem']['value']++;
		}
		else
			$stats['hasNotFismaSystem']['value']++;
		
		if($inRogue)
			$stats['hasRogueFismaSystem']['value']++;
	}
	
	if($high_riskResult['ReportsStatus']['id'])
		$stats['ReportsStatus.'.$high_riskResult['ReportsStatus']['id']]['value']++;
}

if($stats['resolveDateSoon']['value'])
	$stats['resolveDateSoon']['class'] = 'warning';

if($stats['resolveDatePast']['value'])
	$stats['resolveDatePast']['class'] = 'error';

if(!in_array($prefix, array('director')))
{
	if($stats['hasRogueFismaSystem']['value'])
		$stats['hasRogueFismaSystem']['class'] = 'notice';
	
	if($stats['hasNotFismaSystem']['value'])
		$stats['hasNotFismaSystem']['class'] = 'warning';
	
	if($stats['hasManyFismaSystem']['value'])
		$stats['hasManyFismaSystem']['class'] = 'warning';
}

$content = $this->element('Utilities.object_dashboard_stats', array(
	'title' => false,
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => __('%s - Overview', __('High Risk')),
	'content' => $content,
	'show_bookmark' => false,
));