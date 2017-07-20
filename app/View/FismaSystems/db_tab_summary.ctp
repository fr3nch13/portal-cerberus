<?php 
$page_options = array();


// content
$th = array();
$th['org'] = array('content' => __('ORG/IC'));
$th['division'] = array('content' => __('Division'));
$th['branch'] = array('content' => __('Branch'));
$th['sac'] = array('content' => __('SAC'));
$th['crm_name'] = array('content' => __('CRM'));
$th['owner_username'] = array('content' => __('System Owner AD Account'));
$th['owner_name'] = array('content' => __('System Owner Name'));
$th['parent'] = array('content' => __('Parent'));
$th['name'] = array('content' => __('Short Name'));
$th['fullname'] = array('content' => __('Full Name'));
$th['uuid'] = array('content' => __('UUID'));
$th['fips_rating'] = array('content' => __('FIPS Rating'));
$th['fo_risk_assessment'] = array('content' => __('FO Risk Assessment'));
$th['fo_threat_assessment'] = array('content' => __('FO Threat Assessment'));
$th['ahe_hosting'] = array('content' => __('AHE Hosting'));
$th['interconnection'] = array('content' => __('Interconnection'));
$th['gss_status'] = array('content' => __('GSS Status'));
$th['fisma_reportable'] = array('content' => __('Reportable'));
$th['ongoing_auth'] = array('content' => __('Under OA'));
$th['fisma_system_nist_id'] = array('content' => __('NIST'));
$th['ato_expiration'] = array('content' => __('ATO Expiration'));

foreach($fismaContactTypes as $fismaContactType_id => $fismaContactType_name)
{
	$th['ContactType.'. $fismaContactType_id] = array('content' => __('Contact: %s ', $fismaContactType_name));
}

$th['FismaInventory.count'] = array('content' => __('# Inventory'));
$th['FismaSoftwareFismaSystem.count'] = array('content' => __('# Software'));
$th['SrcRule.count'] = array('content' => __('# Rules'));
$th['pii_count'] = array('content' => __('PII Count'));

$th['EolResult.count'] = array('content' => __('# All EOL'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['EolResult.ReportsStatus.'. $reportsStatus_id] = array('content' => __('# EOL %s', $reportsStatus['ReportsStatus']['name']));
}
$th['PenTestResult.count'] = array('content' => __('# All PT'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['PenTestResult.ReportsStatus.'. $reportsStatus_id] = array('content' => __('# PT %s', $reportsStatus['ReportsStatus']['name']));
}
$th['HighRiskResult.count'] = array('content' => __('# All HR'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['HighRiskResult.ReportsStatus.'. $reportsStatus_id] = array('content' => __('# HR %s', $reportsStatus['ReportsStatus']['name']));
}

$th['FismaSystem.created'] = array('content' => __('Created'));
$th['FismaSystem.modified'] = array('content' => __('Modified'));


$totals = array();
$td = array();
$stats = array();

foreach ($fismaSystems as $i => $fismaSystem)
{	
	$td[$i] = array();
	
	$td[$i]['org'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname']:'');
	$td[$i]['division'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname']:'');
	$td[$i]['branch'] = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['shortname']:'');
	$td[$i]['sac'] = (isset($fismaSystem['OwnerContact']['Sac']['shortname'])?$fismaSystem['OwnerContact']['Sac']['shortname']:'');
	$td[$i]['crm_name'] = $this->Contacts->getClosestCrm($fismaSystem, true);
	$td[$i]['owner_username'] = (isset($fismaSystem['OwnerContact']['username'])?$fismaSystem['OwnerContact']['username']:'');
	$td[$i]['owner_name'] = (isset($fismaSystem['OwnerContact']['name'])?$fismaSystem['OwnerContact']['name']:'');
	
	$td[$i]['parent'] = (isset($fismaSystem['FismaSystemParent']['name'])?$fismaSystem['FismaSystemParent']['name']:'');
	$td[$i]['name'] = $this->Html->link($fismaSystem['FismaSystem']['name'], array('action' => 'view', $fismaSystem['FismaSystem']['id']));
	$td[$i]['fullname'] = $this->Html->link($fismaSystem['FismaSystem']['fullname'], array('action' => 'view', $fismaSystem['FismaSystem']['id']));
	
	$td[$i]['uuid'] = $fismaSystem['FismaSystem']['uuid'];
	$td[$i]['fips_rating'] = $fismaSystem['FismaSystemFipsRating']['name'];
	$td[$i]['fo_risk_assessment'] =  $fismaSystem['FismaSystemRiskAssessment']['name'];
	$td[$i]['fo_threat_assessment'] = $fismaSystem['FismaSystemThreatAssessment']['name'];
	$td[$i]['ahe_hosting'] = $fismaSystem['FismaSystemHosting']['name'];
	$td[$i]['interconnection'] = $fismaSystem['FismaSystemInterconnection']['name'];
	$td[$i]['gss_status'] = $fismaSystem['FismaSystemGssStatus']['name'];
	
	$td[$i]['fisma_reportable'] = $this->Wrap->yesNoUnknown($fismaSystem['FismaSystem']['fisma_reportable']);
	$td[$i]['ongoing_auth'] = $this->Wrap->yesNoUnknown($fismaSystem['FismaSystem']['ongoing_auth']);
	$td[$i]['fisma_system_nist_id'] = $fismaSystem['FismaSystemNist']['name'];
	$td[$i]['ato_expiration'] = $this->Wrap->niceTime($fismaSystem['FismaSystem']['ato_expiration']);
	
	foreach($fismaContactTypes as $fismaContactType_id => $fismaContactType_name)
	{
		$td[$i]['ContactType.'. $fismaContactType_id] = ' ';
		
		foreach($fismaSystem['primaryContacts'] as $primaryContact)
		{
			if(!$primaryContact['FismaContactType']['id'])
				continue;
			if($primaryContact['FismaContactType']['id'] == $fismaContactType_id)
			{
				$td[$i]['ContactType.'. $fismaContactType_id] = '';
				if(isset($primaryContact['AdAccount']['name']))
				{
					$td[$i]['ContactType.'. $fismaContactType_id] = $primaryContact['AdAccount']['name'];
					break;
				}
			}
		}
	}
	
	
	$td[$i]['FismaInventory.count'] = array(
		(($fismaSystem['FismaSystem']['FismaInventory.count'] > 0)?$fismaSystem['FismaSystem']['FismaInventory.count']:0),
		array( 'class' => ($fismaSystem['FismaSystem']['FismaInventory.count']?'highlight':''))
	);
	if(!isset($totals['FismaInventory.count']))
		$totals['FismaInventory.count'] = 0;
	$totals['FismaInventory.count'] = ($totals['FismaInventory.count'] + $fismaSystem['FismaSystem']['FismaInventory.count']);
	
	$td[$i]['FismaSoftwareFismaSystem.count'] = array(
		(($fismaSystem['FismaSystem']['FismaSoftwareFismaSystem.count'] > 0)?$fismaSystem['FismaSystem']['FismaSoftwareFismaSystem.count']:0),
		array( 'class' => ($fismaSystem['FismaSystem']['FismaSoftwareFismaSystem.count']?'highlight':''))
	);
	if(!isset($totals['FismaSoftwareFismaSystem.count']))
		$totals['FismaSoftwareFismaSystem.count'] = 0;
	$totals['FismaSoftwareFismaSystem.count'] = ($totals['FismaSoftwareFismaSystem.count'] + $fismaSystem['FismaSystem']['FismaSoftwareFismaSystem.count']);
	
	$td[$i]['SrcRule.count'] = array(
		(($fismaSystem['FismaSystem']['SrcRule.count'] > 0)?$fismaSystem['FismaSystem']['SrcRule.count']:0),
		array( 'class' => ($fismaSystem['FismaSystem']['SrcRule.count']?'highlight':''))
	);
	if(!isset($totals['SrcRule.count']))
		$totals['SrcRule.count'] = 0;
	$totals['SrcRule.count'] = ($totals['SrcRule.count'] + $fismaSystem['FismaSystem']['SrcRule.count']);
	
	$td[$i]['pii_count'] = array(
		(($fismaSystem['FismaSystem']['pii_count'] > 0)?$fismaSystem['FismaSystem']['pii_count']:0),
		array(
			'class' => (($fismaSystem['FismaSystem']['pii_count'] > 0)?'highlight highlight-yellow':''),
		)
	);
	if(!isset($totals['pii_count']))
		$totals['pii_count'] = 0;
	$totals['pii_count'] = ($totals['pii_count'] + $fismaSystem['FismaSystem']['pii_count']);
	
	$td[$i]['EolResult.count'] = array(
		((count($fismaSystem['EolResults']) > 0)?count($fismaSystem['EolResults']):0),
		array(
			'class' => ((count($fismaSystem['EolResults']) > 0)?'highlight':''),
		)
	);
	if(!isset($totals['EolResult.count']))
		$totals['EolResult.count'] = 0;
	$totals['EolResult.count'] = ($totals['EolResult.count'] + count($fismaSystem['EolResults']));
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
	
	$td[$i]['PenTestResult.count'] = array(
		((count($fismaSystem['PenTestResults']) > 0)?count($fismaSystem['PenTestResults']):0),
		array(
			'class' => ((count($fismaSystem['PenTestResults']) > 0)?'highlight':''),
		)
	);
	if(!isset($totals['PenTestResult.count']))
		$totals['PenTestResult.count'] = 0;
	$totals['PenTestResult.count'] = ($totals['PenTestResult.count'] + count($fismaSystem['PenTestResults']));
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
	
	$td[$i]['HighRiskResult.count'] = array(
		((count($fismaSystem['HighRiskResults']) > 0)?count($fismaSystem['HighRiskResults']):0),
		array(
			'class' => ((count($fismaSystem['HighRiskResults']) > 0)?'highlight':''),
		)
	);
	if(!isset($totals['HighRiskResult.count']))
		$totals['HighRiskResult.count'] = 0;
	$totals['HighRiskResult.count'] = ($totals['HighRiskResult.count'] + count($fismaSystem['HighRiskResults']));
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
	$td[$i]['FismaSystem.created'] =  $this->Wrap->niceTime($fismaSystem['FismaSystem']['created']);
	$td[$i]['FismaSystem.modified'] =  $this->Wrap->niceTime($fismaSystem['FismaSystem']['modified']);
}

$totals_row = array();
if(isset($fismaSystem) and isset($td[$i]))
{
	$line_count = 0;
	$totals_row['org'] =  __('Totals:');
	$totals_row['division'] = count($td);
	$totals_row['branch'] = '&nbsp;';
	$totals_row['sac'] = '&nbsp;';
	$totals_row['crm_name'] = '&nbsp;';
	$totals_row['owner_username'] = '&nbsp;';
	$totals_row['owner_name'] = '&nbsp;';
	$totals_row['parent'] = '&nbsp;';
	$totals_row['fips_rating'] = '&nbsp;';
	$totals_row['fo_risk_assessment'] = '&nbsp;';
	$totals_row['fo_threat_assessment'] = '&nbsp;';
	$totals_row['ahe_hosting'] = '&nbsp;';
	$totals_row['interconnection'] = '&nbsp;';
	$totals_row['gss_status'] = '&nbsp;';
	$totals_row['fisma_reportable'] = '&nbsp;';
	$totals_row['ongoing_auth'] = '&nbsp;';
	$totals_row['fisma_system_nist_id'] = '&nbsp;';
	$totals_row['ato_expiration'] = '&nbsp;';
	
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
	'page_title' => __('%s Summary Dashboard', __('FISMA Systems')),
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
));