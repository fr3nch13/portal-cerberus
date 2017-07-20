<?php

$prefix = false;
if(isset($this->request->params['prefix']) and $this->request->params['prefix'])
	$prefix = $this->request->params['prefix'];
$ad_account_id = (isset($ad_account_id)?$ad_account_id:false);

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($fismaSystems)),
);

$stats['auth'] = array('name' => __('Under Ongoing Authorization'), 'value' => 0);
$stats['reportable'] = array('name' => __('FISMA Reportable'), 'value' => 0);
$stats['valid'] = array('name' => __('ATO valid'), 'value' => 0);
$stats['expiring'] = array('name' => __('ATO expiring soon'), 'value' => 0);
$stats['expired'] = array('name' => __('ATO expired'), 'value' => 0);
$stats['noexpire'] = array('name' => __('No ATO expiration'), 'value' => 0);

$soon = strtotime('+2 weeks');
$now = time();

foreach($fismaSystems as $fismaSystem)
{
	if($fismaSystem['FismaSystem']['ongoing_auth'])
		$stats['auth']['value']++;
	
	if($fismaSystem['FismaSystem']['fisma_reportable'])
		$stats['reportable']['value']++;
	
	$atoExpirationDate = false;
	if($fismaSystem['FismaSystem']['ato_expiration'])
			$atoExpirationDate = strtotime($fismaSystem['FismaSystem']['ato_expiration']);
	if($atoExpirationDate)
	{
		if($atoExpirationDate < $now)
		{
			$stats['expired']['class'] = 'error';
			$stats['expired']['value']++;
		}
		elseif($atoExpirationDate < $soon and $atoExpirationDate > $now)
		{
			$stats['expiring']['class'] = 'warning';
			$stats['expiring']['value']++;
		}
		else
		{
			$stats['valid']['class'] = 'info';
			$stats['valid']['value']++;
			
		}
		
	}
	else
	{
		$stats['noexpire']['class'] = 'notice';
		$stats['noexpire']['value']++;
	}	
}

$content = $this->element('Utilities.object_dashboard_stats', array(
	'title' => false,
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => $this->Html->link(__('%s - Overview', __('FISMA Systems')), array('prefix' => $prefix, 'action' => 'dashboard', $ad_account_id)),
	'content' => $content,
));