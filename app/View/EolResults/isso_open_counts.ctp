<?php

$page_options = [];
$page_options['open'] = $this->Html->link(__('Individual Results'), ['action' => 'open', 'prefix' => 'isso']);

$th = [];
$th['path'] = ['content' => __('Organization')];
$th['name'] = ['content' => __('Division')];
$th['total'] = ['content' => __('Open')];

$matrix = [];

$i = 0;
foreach($results as $result)
{
	// overridden results
	if(isset($result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id']) and $result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'])
	{
		$divisionId = $result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'];
		
		if(!isset($matrix[$divisionId]))
		{
			$division = $result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['name'];
			
			$orgId = false;
			$org = false;
			if(isset($result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['Org']['id']) and $result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['Org']['id'])
			{
				$org = $result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname'];
			}
			
			$matrix[$divisionId] = [
				'org' => $org,
				'division' => $division,
				'results' => [],
			];
		}
		$matrix[$divisionId]['results'][$result['EolResult']['id']] = $result['EolResult'];
		continue;
	}
	
	// unmapped results
	if(!isset($result['FismaInventories']) or !$result['FismaInventories'])
	{
		if(!isset($matrix[0]))
		{
			$matrix[0] = [
				'org' => __('Orphaned'),
				'division' => __('Orphaned'),
				'results' => [],
			];
		}
		$matrix[0]['results'][$result['EolResult']['id']] = $result['EolResult'];
		continue;
	}
	
	// the rest of the results
	foreach($result['FismaInventories'] as $inventory)
	{
		// account for inventory that doesn't map due to no system owner set for the fisma system
		$divisionId = 0;
		$org = __('Orphaned');
		if(isset($inventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id']))
		{
			$divisionId = $inventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'];
			$division = $inventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['name'];
		}
		
		if(!isset($matrix[$divisionId]))
		{
			$orgId = false;
			$org = false;
			if(isset($inventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['Org']['id']) and $inventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['Org']['id'])
			{
				$org = $inventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname'];
			}
			
			$matrix[$divisionId] = [
				'org' => $org,
				'division' => $division,
				'results' => [],
			];
		}
		$matrix[$divisionId]['results'][$result['EolResult']['id']] = $result['EolResult'];
	}
}
$matrix = Hash::sort($matrix, '{n}.org', 'asc');

$lastOrg = false;
$orgTotal = 0;
$total = 0;
$td = [];
$i=0;
foreach($matrix as $row)
{
	$thisOrg = $row['org'];
	if(!$lastOrg)
		$lastOrg = $thisOrg;
	
	$total = $total + count($row['results']);
	
	if($lastOrg and $lastOrg != $thisOrg)
	{
		$i++;
		$td[$i] = [];
		$td[$i]['org'] = $lastOrg;
		$td[$i]['division'] = __('Total for %s', $lastOrg);
		$td[$i]['count'] = $orgTotal;
		$orgTotal = 0;
	}
	
	$i++;
	$td[$i] = [];
	$td[$i]['org'] = $row['org'];
	$td[$i]['division'] = $row['division'];
	$td[$i]['count'] = count($row['results']);
	$orgTotal = $orgTotal + count($row['results']);
	
	$lastOrg = $thisOrg;
}

// capture the last org
$i++;
$td[$i] = [];
$td[$i]['org'] = $lastOrg;
$td[$i]['division'] = __('Total for %s', $lastOrg);
$td[$i]['count'] = $orgTotal;

// row for the complete total
$i++;
$td[$i] = [];
$td[$i]['org'] = __('Totals');
$td[$i]['division'] = false;
$td[$i]['count'] = $total;


echo $this->element('Utilities.page_index', [
	'page_title' => __('%s - Open Counts by Division', __('EOL Results')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
	'use_jsordering' => false,
]);
