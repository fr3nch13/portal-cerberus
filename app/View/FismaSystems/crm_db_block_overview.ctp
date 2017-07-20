<?php

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($fismaSystems)),
);

$soon = strtotime('+2 weeks');
$now = time();

foreach($fismaSystems as $fismaSystem)
{
	if(!isset($stats['auth']))
		$stats['auth'] = array('name' => __('Under Ongoing Authorization'), 'value' => 0);
	
	if($fismaSystem['FismaSystem']['ongoing_auth'])
		$stats['auth']['value']++;
		
	if(!isset($stats['reportable']))
		$stats['reportable'] = array('name' => __('FISMA Reportable'), 'value' => 0);
	
	if($fismaSystem['FismaSystem']['fisma_reportable'])
		$stats['reportable']['value']++;
		
	if(!isset($stats['expiring']))
		$stats['expiring'] = array('name' => __('ATO expiring soon'), 'value' => 0);
		
	if(!isset($stats['expired']))
		$stats['expired'] = array('name' => __('ATO expired'), 'value' => 0);
		
	if(!isset($stats['noexpire']))
		$stats['noexpire'] = array('name' => __('No ATO expiration'), 'value' => 0);
	
	if($fismaSystem['FismaSystem']['ato_expiration'])
	{
		$ato_expiration = strtotime($fismaSystem['FismaSystem']['ato_expiration']);
		
		if($ato_expiration < $now)
		{
			$stats['expired']['class'] = 'error';
			$stats['expired']['value']++;
		}
			
		if($ato_expiration < $soon and $ato_expiration > $now)
		{
			$stats['expiring']['class'] = 'warning';
			$stats['expiring']['value']++;
		}
	}
	else
	{
		$stats['noexpire']['value']++;
	}	
}

$content = $this->element('Utilities.object_dashboard_stats', array(
	'title' => false,
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => __('%s - Overview', __('FISMA Systems')),
	'content' => $content,
	'show_bookmark' => false,
));