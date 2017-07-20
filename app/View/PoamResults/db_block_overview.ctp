<?php

$prefix = false;
if(isset($this->request->params['prefix']) and $this->request->params['prefix'])
	$prefix = $this->request->params['prefix'];

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($poamResults)),
);

foreach($poamStatuses as $poamStatus_id => $poamStatus_name)
{	
	if(!isset($stats['PoamStatus.'.$poamStatus_id]))
		$stats['PoamStatus.'.$poamStatus_id] = array('name' => __('With Status - %s', $poamStatus_name), 'value' => 0);
}

if(!in_array($prefix, array('director')))
{
	$stats['hasFismaSystem'] = array('name' => __('With %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasRogueFismaSystem'] = array('name' => __('With Rogue %s', __('FISMA Systems')), 'value' => 0);
	$stats['hasNotFismaSystem'] = array('name' => __('Without %s', __('FISMA Systems')), 'value' => 0);
}

foreach($poamResults as $poamResult)
{
	if(!in_array($prefix, array('director')))
	{
		$fismaSystemIds = array();
		$inRogue = false;
		if($poamResult['FismaSystem']['id'])
		{
			$stats['hasFismaSystem']['value']++;
			
			$fismaSystemIds[$poamResult['FismaSystem']['id']] = $poamResult['FismaSystem']['id'];
			if(isset($poamResult['FismaSystem']['is_rogue']) and $poamResult['FismaSystem']['is_rogue'] == 2)
				$stats['hasRogueFismaSystem']['value']++;
		}
		else
		{
			$stats['hasNotFismaSystem']['value']++;
		}
	}
		
	if($poamResult['PoamStatus']['id'])
		$stats['PoamStatus.'.$poamResult['PoamStatus']['id']]['value']++;
}

if(!in_array($prefix, array('director')))
{
	if($stats['hasRogueFismaSystem']['value'])
		$stats['hasRogueFismaSystem']['class'] = 'notice';
	
	if($stats['hasNotFismaSystem']['value'])
		$stats['hasNotFismaSystem']['class'] = 'warning';
}

$content = $this->element('Utilities.object_dashboard_stats', array(
	'title' => false,
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => $this->Html->link(__('%s - Overview', __('POA&M')), array('action' => 'dashboard')),
	'content' => $content,
));