<?php 
$page_options = array();


// content
$th = array();
$th['org'] = array('content' => __('ORG/IC'));
$th['division'] = array('content' => __('Division'));
$th['branch'] = array('content' => __('Branch'));
$th['sac'] = array('content' => __('SAC'));
$th['owner_username'] = array('content' => __('System Owner AD Account'));
$th['owner_name'] = array('content' => __('System Owner Name'));
$th['parent'] = array('content' => __('Parent'));
$th['name'] = array('content' => __('Name'));
$th['EolResult.all'] = array('content' => __('# EOL All'));
foreach($reportsStatuses as $reportsStatus)
{
	$th['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = array('content' => __('# EOL - %s', $reportsStatus['ReportsStatus']['name']));
}

$th['PenTestResult.all'] = array('content' => __('# PT All'));
foreach($reportsStatuses as $reportsStatus)
{
	$th['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = array('content' => __('# PT - %s', $reportsStatus['ReportsStatus']['name']));
}

$th['HighRiskResult.all'] = array('content' => __('# HR All'));
foreach($reportsStatuses as $reportsStatus)
{
	$th['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = array('content' => __('# HR - %s', $reportsStatus['ReportsStatus']['name']));
}

$th['actions'] = array('content' => __('Actions'));

$totals = array();
$td = array();
$stats = array();

foreach ($fismaSystems as $i => $fismaSystem)
{
	// only list out systems with positive counts
/*
	if(!$fismaSystem['FismaSystem']['pii_count'] and !count($fismaSystem['EolResults']) and !count($fismaSystem['PenTestResults']) and !count($fismaSystem['HighRiskResults']))
	{
		continue;
	}
*/
	
	$td[$i] = array();
	
	$actions = array(
		'view' => $this->Html->link(__('View'), array('action' => 'view', $fismaSystem['FismaSystem']['id'])),
	);
	
	$systemOwner['AdAccount'] = (isset($fismaSystem['OwnerContact'])?$fismaSystem['OwnerContact']:array());
	$systemOwnerLink = (isset($systemOwner['AdAccount']['id'])?$this->Html->link($systemOwner['AdAccount']['name'], array('controller' => 'ad_accounts', 'action' => 'view', $systemOwner['AdAccount']['id'])):'');
	$systemOwnerPath = $this->Contacts->makePath($systemOwner);
	
	$td[$i]['org'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname']:'');
	$td[$i]['division'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname']:'');
	$td[$i]['branch'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['shortname']:'');
	$td[$i]['sac'] = (isset($fismaSystem['OwnerContact']['Sac']['shortname'])?$fismaSystem['OwnerContact']['Sac']['shortname']:'');
	$td[$i]['owner_username'] = (isset($fismaSystem['OwnerContact']['username'])?$fismaSystem['OwnerContact']['username']:'');
	$td[$i]['owner_name'] = (isset($fismaSystem['OwnerContact']['name'])?$fismaSystem['OwnerContact']['name']:'');
	
	$td[$i]['parent'] = (isset($fismaSystem['FismaSystemParent']['name'])?$fismaSystem['FismaSystemParent']['name']:'');
	$td[$i]['name'] = $this->Html->link($fismaSystem['FismaSystem']['name'], array('action' => 'view', $fismaSystem['FismaSystem']['id']));
	
	$td[$i]['EolResult.all'] = array(
		((count($fismaSystem['EolResults']) > 0)?count($fismaSystem['EolResults']):0),
		array(
			'class' => ((count($fismaSystem['EolResults']) > 0)?'highlight':''),
		)
	);
	if(!isset($totals['EolResult.all']))
		$totals['EolResult.all'] = 0;
	$totals['EolResult.all'] = ($totals['EolResult.all'] + count($fismaSystem['EolResults']));
	foreach($reportsStatuses as $reportsStatus)
	{
		$td[$i]['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = 0;
		
		foreach($fismaSystem['EolResults'] as $eolResult)
		{
			if($eolResult['EolResult']['reports_status_id'] == $reportsStatus['ReportsStatus']['id'])
			{
				$td[$i]['EolResult.ReportsStatus.'. $reportsStatus['ReportsStatus']['id']]++;
				
			}
		}
		
		if(!isset($totals['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']]))
			$totals['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = 0;
		$totals['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = ($totals['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] + $td[$i]['EolResult.ReportsStatus.'. $reportsStatus['ReportsStatus']['id']]);
		
		if($td[$i]['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']])
		{
			$td[$i]['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
				'displayValue' => $td[$i]['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']],
				'colorShow' => true,
				'class' => 'highlight',
			));
		}
	}
	
	$td[$i]['PenTestResult.all'] = array(
		((count($fismaSystem['PenTestResults']) > 0)?count($fismaSystem['PenTestResults']):0),
		array(
			'class' => ((count($fismaSystem['PenTestResults']) > 0)?'highlight':''),
		)
	);
	if(!isset($totals['PenTestResult.all']))
		$totals['PenTestResult.all'] = 0;
	$totals['PenTestResult.all'] = ($totals['PenTestResult.all'] + count($fismaSystem['PenTestResults']));
	foreach($reportsStatuses as $reportsStatus)
	{
		$td[$i]['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = 0;
		foreach($fismaSystem['PenTestResults'] as $penTestResult)
		{
			if($penTestResult['PenTestResult']['reports_status_id'] == $reportsStatus['ReportsStatus']['id'])
			{
				$td[$i]['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']]++;
				
			}
		}
		
		if(!isset($totals['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']]))
			$totals['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = 0;
		$totals['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = ($totals['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] + $td[$i]['PenTestResult.ReportsStatus.'. $reportsStatus['ReportsStatus']['id']]);
		
		if($td[$i]['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']])
		{
			$td[$i]['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
				'displayValue' => $td[$i]['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']],
				'colorShow' => true,
				'class' => 'highlight',
			));
		}
	}
	
	$td[$i]['HighRiskResult.all'] = array(
		((count($fismaSystem['HighRiskResults']) > 0)?count($fismaSystem['HighRiskResults']):0),
		array(
			'class' => ((count($fismaSystem['HighRiskResults']) > 0)?'highlight':''),
		)
	);
	if(!isset($totals['HighRiskResult.all']))
		$totals['HighRiskResult.all'] = 0;
	$totals['HighRiskResult.all'] = ($totals['HighRiskResult.all'] + count($fismaSystem['HighRiskResults']));
	foreach($reportsStatuses as $reportsStatus)
	{
		$td[$i]['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = 0;
		foreach($fismaSystem['HighRiskResults'] as $highRiskResult)
		{
			if($highRiskResult['HighRiskResult']['reports_status_id'] == $reportsStatus['ReportsStatus']['id'])
			{
				$td[$i]['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']]++;
				
			}
		}
		
		if(!isset($totals['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']]))
			$totals['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = 0;
		$totals['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = ($totals['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] + $td[$i]['HighRiskResult.ReportsStatus.'. $reportsStatus['ReportsStatus']['id']]);
		
		if($td[$i]['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']])
		{
			$td[$i]['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
				'displayValue' => $td[$i]['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']],
				'colorShow' => true,
				'class' => 'highlight',
			));
		}
	}
	
	$td[$i]['actions'] = array(implode('', $actions), array('class' => 'actions'));
}

if(isset($fismaSystem) and isset($td[$i]))
{
	$line_count = 0;
	$totals_row['org'] =  __('Totals:');
	$totals_row['division'] = count($td);
	$totals_row['branch'] = '&nbsp;';
	$totals_row['sac'] = '&nbsp;';
	$totals_row['owner_username'] = '&nbsp;';
	$totals_row['owner_name'] = '&nbsp;';
	$totals_row['parent'] = '&nbsp;';
	$totals_row['name'] = '&nbsp;';
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
				array('class' => 'highlight'),
			);
	}
	if(is_int($i))
		array_push($td, $totals_row);
	else
		$td['totals'] = $totals_row;
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Systems'),
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
));