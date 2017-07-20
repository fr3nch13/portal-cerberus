<?php 

$th = array();
$th['EolResult.id'] = array('content' => __('ID'), 'options' => array('sort' => 'EolResult.id'));
if(!$stripped)$th['EolResult.Division'] = array('content' => __('Division'));
if(!$stripped)$th['EolResult.Branch'] = array('content' => __('Branch'));
$th['EolResult.FismaSystem'] = array('content' => __('FISMA System'));
if(!$stripped)$th['EolResult.reports_organization_id'] = array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name'));
if(!$stripped)$th['EolResult.host_description'] = array('content' => __('Host Description'), 'options' => array('sort' => 'EolResult.host_description'));
$th['EolResult.ip_address'] = array('content' => __('Ip Address'), 'options' => array('sort' => 'EolResult.ip_address'));
$th['EolResult.host_name'] = array('content' => __('Hostname'), 'options' => array('sort' => 'EolResult.host_name'));
if(!$stripped)$th['EolResult.mac_address'] = array('content' => __('Mac Address'), 'options' => array('sort' => 'EolResult.mac_address'));
if(!$stripped)$th['EolResult.asset_tag'] = array('content' => __('Asset Tag'), 'options' => array('sort' => 'EolResult.asset_tag'));
$th['EolResult.netbios'] = array('content' => __('NetBIOS'), 'options' => array('sort' => 'EolResult.netbios'));
$th['EolResult.eol_software_id'] = array('content' => __('Software/Vulnerability'), 'options' => array('sort' => 'EolSoftware.name'));
$th['EolResult.tickets'] = array('content' => __('Tickets'), 'options' => array('sort' => 'EolResult.tickets'));
$th['EolResult.waiver'] = array('content' => __('Waivers'), 'options' => array('sort' => 'EolResult.waiver'));
$th['EolResult.changerequest'] = array('content' => __('CR IDs'), 'options' => array('sort' => 'EolResult.changerequest'));
if(!$stripped)$th['EolResult.reports_remediation_id'] = array('content' => __('Remediation'), 'options' => array('sort' => 'EolResult.reports_remediation_id'));
if(!$stripped)$th['EolResult.reports_verification_id'] = array('content' => __('Verification'), 'options' => array('sort' => 'EolResult.reports_verification_id'));
$th['EolResult.reports_status_id'] = array('content' => __('Status'), 'options' => array('sort' => 'EolResult.reports_status_id'));
$th['EolResult.status_date'] = array('content' => __('Status Changed Date'), 'options' => array('sort' => 'EolResult.status_date'));
if(!$stripped)$th['EolResult.reports_assignable_party_id'] = array('content' => __('Assignable Party'), 'options' => array('sort' => 'EolResult.reports_assignable_party_id'));
$th['EolResult.hw_price'] = array('content' => __('Hardware $'), 'options' => array('sort' => 'EolResult.hw_price'));
$th['EolResult.sw_price'] = array('content' => __('Software $'), 'options' => array('sort' => 'EolResult.sw_price'));
$th['EolResult.resolved_by_date'] = array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'EolResult.resolved_by_date'));
if(!$stripped)$th['EolResult.verification_date'] = array('content' => __('Verified Date'), 'options' => array('sort' => 'EolResult.verification_date' ));
if(!$stripped)$th['EolResult.remediation_date'] = array('content' => __('Remediated Date'), 'options' => array('sort' => 'EolResult.remediation_date' ));
if(!$stripped)$th['EolResult.action_date'] = array('content' => __('Action Date'), 'options' => array('sort' => 'EolResult.action_date' ));
if(!$stripped)$th['EolResult.modified'] = array('content' => __('Modified'), 'options' => array('sort' => 'EolResult.modified' ));
if(!$stripped)$th['EolResult.created'] = array('content' => __('Created'), 'options' => array('sort' => 'EolResult.created' ));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($eolResults as $i => $eolResult)
{
	$branch = array();
	$division = array();
	if(isset($eolResult['FismaInventories']) and $eolResult['FismaInventories'])
	{
		foreach($eolResult['FismaInventories'] as $fismaInventory)
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
	
	$fisma_system = array();
	if(isset($eolResult['FismaInventories']) and $eolResult['FismaInventories'])
	{
		foreach($eolResult['FismaInventories'] as $fismaInventory)
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
	if(isset($eolResult['ReportsStatus']['name'])
		and $this->Common->slugify($eolResult['ReportsStatus']['name']) == 'open')
	{
		$resolvedByDate = strtotime($eolResult['EolResult']['resolved_by_date']);
		if($resolvedByDate <= $thresholdNow)
			$highlightDueDate = 'highlight-red';
		elseif($resolvedByDate <= $thresholdSoon)
			$highlightDueDate = 'highlight-yellow';
	}
	
	$td[$i] = array();
	$td[$i]['EolResult.id'] = $eolResult['EolResult']['id'];
	if(!$stripped)$td[$i]['EolResult.Division'] = $division;
	if(!$stripped)$td[$i]['EolResult.Branch'] = $branch;
	$td[$i]['EolResult.FismaSystem'] = $fisma_system;
	if(!$stripped)$td[$i]['EolResult.reports_organization_id'] = $eolResult['ReportsOrganization']['name'];
	if(!$stripped)$td[$i]['EolResult.host_description'] = $eolResult['EolResult']['host_description'];
	$td[$i]['EolResult.ip_address'] = $eolResult['EolResult']['ip_address'];
	$td[$i]['EolResult.host_name'] = $eolResult['EolResult']['host_name'];
	if(!$stripped)$td[$i]['EolResult.mac_address'] = $eolResult['EolResult']['mac_address'];
	if(!$stripped)$td[$i]['EolResult.asset_tag'] = $eolResult['EolResult']['asset_tag'];
	$td[$i]['EolResult.netbios'] = $eolResult['EolResult']['netbios'];
	$td[$i]['EolResult.eol_software_id'] = $eolResult['EolSoftware']['name'];
	$td[$i]['EolResult.tickets'] = $this->Local->ticketLinks($eolResult['EolResult']['tickets']);
	$td[$i]['EolResult.waiver'] = $this->Local->waiverLinks($eolResult['EolResult']['waiver']);
	$td[$i]['EolResult.changerequest'] = $this->Local->crLinks($eolResult['EolResult']['changerequest']);
	if(!$stripped)$td[$i]['EolResult.reports_remediation_id'] = $eolResult['ReportsRemediation']['name'];
	if(!$stripped)$td[$i]['EolResult.reports_verification_id'] = $eolResult['ReportsVerification']['name'];
	$td[$i]['EolResult.reports_status_id'] = $eolResult['ReportsStatus']['name'];
	$td[$i]['EolResult.status_date'] = $this->Wrap->niceTime($eolResult['EolResult']['status_date']);
	if(!$stripped)$td[$i]['EolResult.reports_assignable_party_id'] = $eolResult['ReportsAssignableParty']['name'];
	$td[$i]['EolResult.hw_price'] = $this->Common->nicePrice($eolResult['EolResult']['hw_price']);
	$td[$i]['EolResult.sw_price'] = $this->Common->nicePrice($eolResult['EolResult']['sw_price']);
	$td[$i]['EolResult.resolved_by_date'] = array($this->Wrap->niceDay($eolResult['EolResult']['resolved_by_date']), array('class' => $highlightDueDate));
	if(!$stripped)$td[$i]['EolResult.verification_date'] = $this->Wrap->niceDay($eolResult['EolResult']['verification_date']);
	if(!$stripped)$td[$i]['EolResult.remediation_date'] = $this->Wrap->niceDay($eolResult['EolResult']['remediation_date']);
	if(!$stripped)$td[$i]['EolResult.action_date'] = $this->Wrap->niceDay($eolResult['EolResult']['action_date']);
	if(!$stripped)$td[$i]['EolResult.modified'] = $this->Wrap->niceTime($eolResult['EolResult']['modified']);
	if(!$stripped)$td[$i]['EolResult.created'] = $this->Wrap->niceTime($eolResult['EolResult']['created']);
}

if($stripped)
{
	echo $this->element('Utilities.table', array(
		'th' => $th,
		'td' => $td,
		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
		'table_stripped' => true,
		'table_widget_options' => array(
			'setup' => "
				self.element.find('td.highlight-red').parent().addClass('highlight-red');
				self.element.find('td.highlight-yellow').parent().addClass('highlight-yellow');
			"
		),
	));
}
else{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('All Results'),
		'th' => $th,
		'td' => $td,
		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
		'table_widget_options' => array(
			'setup' => "
				self.element.find('td.highlight-red').parents('tr').addClass('highlight-red');
				self.element.find('td.highlight-yellow').parents('tr').addClass('highlight-yellow');
			"
		),
	));
}