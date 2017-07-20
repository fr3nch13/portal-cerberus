<?php

$prefix = false;
if(isset($this->request->params['prefix']) and $this->request->params['prefix'])
	$prefix = $this->request->params['prefix'];

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($usResults)),
);

foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{	
	if(!isset($stats['ReportsStatus.'.$reportsStatus_id]))
		$stats['ReportsStatus.'.$reportsStatus_id] = array('name' => __('With Status - %s', $reportsStatus_name), 'value' => 0);
}

if(!in_array($prefix, array('director')))
{
	$stats['hasFismaSystem'] = array('name' => __('With %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasRogueFismaSystem'] = array('name' => __('With Rogue %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasNotFismaSystem'] = array('name' => __('Without %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasManyFismaSystem'] = array('name' => __('Multiple %s', __('FISMA Systems')), 'value' => 0);
}

foreach($usResults as $usResult)
{
	if(!in_array($prefix, array('director')))
	{
		$fismaSystemIds = array();
		$inRogue = false;
		if(count($usResult['FismaInventories']))
		{
			foreach($usResult['FismaInventories'] as $fismaInventory)
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
		
	if($usResult['ReportsStatus']['id'])
		$stats['ReportsStatus.'.$usResult['ReportsStatus']['id']]['value']++;
}

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
	'title' => $this->Html->link(__('%s - Overview', __('US')), array('action' => 'dashboard')),
	'content' => $content,
));