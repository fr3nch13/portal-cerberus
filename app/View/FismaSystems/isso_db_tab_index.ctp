<?php 
$page_options = array();


// content
$th = array();
$th['org'] = array('content' => __('ORG/IC'));
$th['division'] = array('content' => __('Division'));
$th['owner_name'] = array('content' => __('System Owner Name'));
$th['name'] = array('content' => __('Name'));
$th['pii_count'] = array('content' => __('PII Count'));
foreach($reportsStatuses as $reportsStatus)
{
	$th['EolResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = array('content' => __('# EOL - %s', $reportsStatus['ReportsStatus']['name']));
}
foreach($reportsStatuses as $reportsStatus)
{
	$th['PenTestResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = array('content' => __('# PT - %s', $reportsStatus['ReportsStatus']['name']));
}
foreach($reportsStatuses as $reportsStatus)
{
	$th['HighRiskResult.ReportsStatus.'.$reportsStatus['ReportsStatus']['id']] = array('content' => __('# HR - %s', $reportsStatus['ReportsStatus']['name']));
}

$totals = array();
$td = array();
$stats = array();

foreach ($fismaSystems as $i => $fismaSystem)
{
	// only list out sustems with positive counts
	if(!$fismaSystem['FismaSystem']['pii_count'] and !count($fismaSystem['EolResults']) and !count($fismaSystem['PenTestResults']) and !count($fismaSystem['HighRiskResults']))
	{
		continue;
	}
	
	$td[$i] = array();
	
	$systemOwner['AdAccount'] = (isset($fismaSystem['OwnerContact'])?$fismaSystem['OwnerContact']:array());
	
	$td[$i]['org'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname']:'');
	$td[$i]['division'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname']:'');
	$td[$i]['owner_name'] = (isset($fismaSystem['OwnerContact']['name'])?$fismaSystem['OwnerContact']['name']:'');
	$td[$i]['name'] = $fismaSystem['FismaSystem']['name'];
	
	$td[$i]['pii_count'] = array(
		(($fismaSystem['FismaSystem']['pii_count'] > 0)?$fismaSystem['FismaSystem']['pii_count']:0),
		array(
			'class' => (($fismaSystem['FismaSystem']['pii_count'] > 0)?'highlight highlight-yellow':''),
		)
	);
	if(!isset($totals['pii_count']))
		$totals['pii_count'] = 0;
	$totals['pii_count'] = ($totals['pii_count'] + $fismaSystem['FismaSystem']['pii_count']);
	
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
}

$totals_row = array();
if(isset($fismaSystem) and isset($td[$i]))
{
	$line_count = 0;
	$totals_row['org'] =  __('Totals:');
	$totals_row['owner_name'] = '&nbsp;';
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
	'page_title' => __('%s Counts', __('FISMA Systems')),
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
));