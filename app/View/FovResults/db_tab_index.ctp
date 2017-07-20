<?php 

$th = [];
$th['EolResult.id'] = ['content' => __('ID'), 'options' => ['sort' => 'FovResult.id']];
if(!$stripped)$th['EolResult.Division'] = ['content' => __('Division')];
if(!$stripped)$th['EolResult.Branch'] = ['content' => __('Branch')];
$th['EolResult.FismaSystem'] = ['content' => __('FISMA System')];
if(!$stripped)$th['EolResult.reports_organization_id'] = ['content' => __('Organization'), 'options' => ['sort' => 'ReportsOrganization.name']];
$th['EolResult.eol_software_id'] = ['content' => __('Software/Vulnerability'), 'options' => ['sort' => 'EolSoftware.name']];
$th['EolResult.tickets'] = ['content' => __('Tickets'), 'options' => ['sort' => 'EolResult.tickets']];
$th['EolResult.waiver'] = ['content' => __('Waivers'), 'options' => ['sort' => 'EolResult.waiver']];
$th['EolResult.changerequest'] = ['content' => __('CR IDs'), 'options' => ['sort' => 'EolResult.changerequest']];
if(!$stripped)$th['EolResult.reports_assignable_party_id'] = ['content' => __('Assignable Party'), 'options' => ['sort' => 'EolResult.reports_assignable_party_id']];
if(!$stripped)$th['EolResult.reports_remediation_id'] = ['content' => __('Remediation'), 'options' => ['sort' => 'EolResult.reports_remediation_id']];
if(!$stripped)$th['EolResult.reports_severity_id'] = ['content' => __('Severity'), 'options' => ['sort' => 'EolResult.reports_severity_id']];
$th['EolResult.reports_status_id'] = ['content' => __('Status'), 'options' => ['sort' => 'EolResult.reports_status_id']];
if(!$stripped)$th['EolResult.reports_verification_id'] = ['content' => __('Verification'), 'options' => ['sort' => 'EolResult.reports_verification_id']];
$th['EolResult.resolved_by_date'] = ['content' => __('Must be Resolved By'), 'options' => ['sort' => 'EolResult.resolved_by_date']];
if(!$stripped)$th['EolResult.modified'] = ['content' => __('Modified'), 'options' => ['sort' => 'EolResult.modified']];
if(!$stripped)$th['EolResult.created'] = ['content' => __('Created'), 'options' => ['sort' => 'EolResult.created']];

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = [];
foreach ($fovResults as $i => $fovResult)
{
	$branch = [];
	$division = [];
	if(isset($fovResult['FismaInventories']) and $fovResult['FismaInventories'])
	{
		foreach($fovResult['FismaInventories'] as $fismaInventory)
		{
			if(isset($fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']))
			{
				$branchId = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['id'];
				$branch[$branchId] = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['shortname'];
			}
			if(isset($fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']))
			{
				$divisionId = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'];
				$division[$divisionId] = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['shortname'];
			}
		}
	}
	$branch = implode('; ', $branch);
	$division = implode('; ', $division);
	
	$fisma_system = [];
	if(isset($fovResult['FismaInventories']) and $fovResult['FismaInventories'])
	{
		foreach($fovResult['FismaInventories'] as $fismaInventory)
		{
			if(isset($fismaInventory['FismaSystem']))
			{
				$fisma_systemId = $fismaInventory['FismaSystem']['id'];
				$fisma_system[$fisma_systemId] = $fismaInventory['FismaSystem']['name'];
			}
		}
	}
	$fisma_system = implode(', ', $fisma_system);
	
	$highlightDueDate = false;
	if(isset($fovResult['ReportsStatus']['name'])
		and $this->Common->slugify($fovResult['ReportsStatus']['name']) == 'open')
	{
		$resolvedByDate = strtotime($fovResult['FovResult']['resolved_by_date']);
		if($resolvedByDate <= $thresholdNow)
			$highlightDueDate = 'highlight-red';
		elseif($resolvedByDate <= $thresholdSoon)
			$highlightDueDate = 'highlight-yellow';
	}
	
	$td[$i] = [];
	$td[$i]['EolResult.id'] = $fovResult['FovResult']['id'];
	if(!$stripped)$td[$i]['EolResult.Division'] = $division;
	if(!$stripped)$td[$i]['EolResult.Branch'] = $branch;
	$td[$i]['EolResult.FismaSystem'] = $fisma_system;
	if(!$stripped)$td[$i]['EolResult.reports_organization_id'] = $fovResult['ReportsOrganization']['name'];
	$td[$i]['EolResult.eol_software_id'] = $fovResult['EolSoftware']['name'];
	$td[$i]['EolResult.tickets'] = $this->Local->ticketLinks($fovResult['FovResult']['tickets']);
	$td[$i]['EolResult.waiver'] = $this->Local->waiverLinks($fovResult['FovResult']['waiver']);
	$td[$i]['EolResult.changerequest'] = $this->Local->crLinks($fovResult['FovResult']['changerequest']);
	if(!$stripped)$td[$i]['EolResult.reports_assignable_party_id'] = $fovResult['ReportsAssignableParty']['name'];
	if(!$stripped)$td[$i]['EolResult.reports_remediation_id'] = $fovResult['ReportsRemediation']['name'];
	if(!$stripped)$td[$i]['EolResult.reports_severity_id'] = $fovResult['ReportsSeverity']['name'];
	$td[$i]['EolResult.reports_status_id'] = $fovResult['ReportsStatus']['name'];
	if(!$stripped)$td[$i]['EolResult.reports_verification_id'] = $fovResult['ReportsVerification']['name'];
	$td[$i]['EolResult.resolved_by_date'] = [$this->Wrap->niceDay($fovResult['FovResult']['resolved_by_date']), ['class' => $highlightDueDate]];
	if(!$stripped)$td[$i]['EolResult.modified'] = $this->Wrap->niceTime($fovResult['FovResult']['modified']);
	if(!$stripped)$td[$i]['EolResult.created'] = $this->Wrap->niceTime($fovResult['FovResult']['created']);
}

if($stripped)
{
	echo $this->element('Utilities.table', [
		'th' => $th,
		'td' => $td,
		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
		'table_stripped' => true,
		'table_widget_options' => [
			'setup' => "
				self.element.find('td.highlight-red').parent().addClass('highlight-red');
				self.element.find('td.highlight-yellow').parent().addClass('highlight-yellow');
			"
		],
	]);
}
else
{
	echo $this->element('Utilities.page_index', [
		'page_title' => __('All Results'),
		'th' => $th,
		'td' => $td,
		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
		'table_widget_options' => [
			'setup' => "
				self.element.find('td.highlight-red').parents('tr').addClass('highlight-red');
				self.element.find('td.highlight-yellow').parents('tr').addClass('highlight-yellow');
			"
		],
	]);
}