<?php 

$th = array();
$th['HighRiskResult.id'] = array('content' => __('ID'), 'options' => array('sort' => 'HighRiskResult.id'));
if(!$stripped) $th['HighRiskResult.Division'] = array('content' => __('Division'));
if(!$stripped) $th['HighRiskResult.Branch'] = array('content' => __('Branch'));
$th['HighRiskResult.FismaSystem'] = array('content' => __('FISMA System'));
if(!$stripped) $th['HighRiskResult.reports_system_type_id'] = array('content' => __('System Type'), 'options' => array('sort' => 'HighRiskResult.reports_system_type_id'));
$th['HighRiskResult.eol_software_id'] = array('content' => __('Software/Vulnerability'), 'options' => array('sort' => 'EolSoftware.name'));
$th['HighRiskResult.ip_address'] = array('content' => __('Ip Address'), 'options' => array('sort' => 'HighRiskResult.ip_address'));
$th['HighRiskResult.host_name'] = array('content' => __('Host Name'), 'options' => array('sort' => 'HighRiskResult.host_name'));
if(!$stripped) $th['HighRiskResult.mac_address'] = array('content' => __('MAC Address'), 'options' => array('sort' => 'HighRiskResult.mac_address'));
if(!$stripped) $th['HighRiskResult.asset_tag'] = array('content' => __('Asset Tag'), 'options' => array('sort' => 'HighRiskResult.asset_tag'));
if(!$stripped) $th['HighRiskResult.port'] = array('content' => __('Port'), 'options' => array('sort' => 'HighRiskResult.port'));
if(!$stripped) $th['HighRiskResult.dhs'] = array('content' => __('DHS'), 'options' => array('sort' => 'HighRiskResult.dhs'));
$th['HighRiskResult.reported_to_ic_date'] = array('content' => __('Reported to ORG/IC'), 'options' => array('sort' => 'HighRiskResult.reported_to_ic_date'));
$th['HighRiskResult.resolved_by_date'] = array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'HighRiskResult.resolved_by_date'));
if(!$stripped) $th['HighRiskResult.estimated_remediation_date'] = array('content' => __('Est. Remediation Date'), 'options' => array('sort' => 'HighRiskResult.estimated_remediation_date'));
$th['HighRiskResult.ticket'] = array('content' => __('Ticket'), 'options' => array('sort' => 'HighRiskResult.ticket'));
$th['HighRiskResult.waiver'] = array('content' => __('Waivers'), 'options' => array('sort' => 'HighRiskResult.waiver'));
$th['HighRiskResult.changerequest'] = array('content' => __('CR IDs'), 'options' => array('sort' => 'HighRiskResult.changerequest'));
if(!$stripped) $th['HighRiskResult.reports_assignable_party_id'] = array('content' => __('Assignable Party'), 'options' => array('sort' => 'HighRiskResult.reports_assignable_party_id'));
if(!$stripped) $th['HighRiskResult.reports_remediation_id'] = array('content' => __('Remediation'), 'options' => array('sort' => 'HighRiskResult.reports_remediation_id'));
if(!$stripped) $th['HighRiskResult.reports_verification_id'] = array('content' => __('Verification'), 'options' => array('sort' => 'HighRiskResult.reports_verification_id'));
$th['HighRiskResult.reports_status_id'] = array('content' => __('Status'), 'options' => array('sort' => 'HighRiskResult.reports_status_id'));
$th['HighRiskResult.status_date'] = array('content' => __('Status Changed Date'), 'options' => array('sort' => 'HighRiskResult.status_date'));
if(!$stripped) $th['HighRiskResult.modified'] = array('content' => __('Modified'), 'options' => array('sort' => 'HighRiskResult.modified' ));
if(!$stripped) $th['HighRiskResult.created'] = array('content' => __('Created'), 'options' => array('sort' => 'HighRiskResult.created' ));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($high_risk_results as $i => $high_risk_result)
{
	$branch = array();
	$division = array();
	if(isset($high_risk_result['FismaInventories']) and $high_risk_result['FismaInventories'])
	{
		foreach($high_risk_result['FismaInventories'] as $fismaInventory)
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
	if(isset($high_risk_result['FismaInventories']) and $high_risk_result['FismaInventories'])
	{
		foreach($high_risk_result['FismaInventories'] as $fismaInventory)
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
	$statusStyle = false;
	if(isset($high_risk_result['ReportsStatus']['name']))
	{
		if($this->Common->slugify($high_risk_result['ReportsStatus']['name']) == 'open')
		{
			$resolvedByDate = strtotime($high_risk_result['HighRiskResult']['resolved_by_date']);
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
		else
		{
			$statusStyle = 'background-color: '.$this->Common->makeRGBfromHex($high_risk_result['ReportsStatus']['color_code_hex'], '0.3').';';
		}
	}
	
	$td[$i] = array();
	$td[$i]['HighRiskResult.id'] = $high_risk_result['HighRiskResult']['id'];
	if(!$stripped) $td[$i]['HighRiskResult.Division'] = $division;
	if(!$stripped) $td[$i]['HighRiskResult.Branch'] = $branch;
	$td[$i]['HighRiskResult.FismaSystem'] = $fisma_system;
	if(!$stripped) $td[$i]['HighRiskResult.reports_system_type_id'] = $high_risk_result['ReportsSystemType']['name'];
	$td[$i]['HighRiskResult.vulnerability'] = $high_risk_result['HighRiskResult']['vulnerability'];
	$td[$i]['HighRiskResult.ip_address'] = $high_risk_result['HighRiskResult']['ip_address'];
	$td[$i]['HighRiskResult.host_name'] = $high_risk_result['HighRiskResult']['host_name'];
	if(!$stripped) $td[$i]['HighRiskResult.mac_address'] = $high_risk_result['HighRiskResult']['mac_address'];
	if(!$stripped) $td[$i]['HighRiskResult.asset_tag'] = $high_risk_result['HighRiskResult']['asset_tag'];
	if(!$stripped) $td[$i]['HighRiskResult.port'] = $high_risk_result['HighRiskResult']['port'];
	if(!$stripped) $td[$i]['HighRiskResult.dhs'] = $high_risk_result['HighRiskResult']['dhs'];
	$td[$i]['HighRiskResult.reported_to_ic_date'] = $this->Wrap->niceDay($high_risk_result['HighRiskResult']['reported_to_ic_date']);
	$td[$i]['HighRiskResult.resolved_by_date'] = array($this->Wrap->niceDay($high_risk_result['HighRiskResult']['resolved_by_date']), array('class' => $highlightDueDate));
	if(!$stripped)$td[$i]['HighRiskResult.estimated_remediation_date'] = $this->Wrap->niceDay($high_risk_result['HighRiskResult']['estimated_remediation_date']);
	$td[$i]['HighRiskResult.ticket'] = $this->Local->ticketLinks($high_risk_result['HighRiskResult']['ticket']);
	$td[$i]['HighRiskResult.waiver'] = $this->Local->waiverLinks($high_risk_result['HighRiskResult']['waiver']);
	$td[$i]['HighRiskResult.changerequest'] = $this->Local->crLinks($high_risk_result['HighRiskResult']['changerequest']);
	if(!$stripped)$td[$i]['HighRiskResult.reports_assignable_party_id'] = $high_risk_result['ReportsAssignableParty']['name'];
	if(!$stripped)$td[$i]['HighRiskResult.reports_remediation_id'] = $high_risk_result['ReportsRemediation']['name'];
	if(!$stripped)$td[$i]['HighRiskResult.reports_verification_id'] = $high_risk_result['ReportsVerification']['name'];
	$td[$i]['HighRiskResult.reports_status_id'] = array($high_risk_result['ReportsStatus']['name'], array('data-style' => $statusStyle));
	$td[$i]['HighRiskResult.status_date'] = $this->Wrap->niceTime($high_risk_result['HighRiskResult']['status_date']);
	if(!$stripped)$td[$i]['HighRiskResult.modified'] = $this->Wrap->niceTime($high_risk_result['HighRiskResult']['modified']);
	if(!$stripped)$td[$i]['HighRiskResult.created'] = $this->Wrap->niceTime($high_risk_result['HighRiskResult']['created']);
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
				self.element.find('td[data-style]').each(function(){ $(this).parents('tr').attr('style', $(this).data('style')) });
			"
		),
	));
}
else
{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('All Results'),
		'th' => $th,
		'td' => $td,
		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
		'table_widget_options' => array(
			'setup' => "
				self.element.find('td.highlight-red').parents('tr').addClass('highlight-red');
				self.element.find('td.highlight-yellow').parents('tr').addClass('highlight-yellow');
				self.element.find('td[data-style]').each(function(){ $(this).parents('tr').attr('style', $(this).data('style')) });
			"
		),
	));
}