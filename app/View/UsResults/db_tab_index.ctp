<?php 

$th = array();
$th['UsResult.id'] = array('content' => __('ID'), 'options' => array('sort' => 'UsResult.id'));
if(!$stripped)$th['UsResult.Division'] = array('content' => __('Division'));
if(!$stripped)$th['UsResult.Branch'] = array('content' => __('Branch'));
$th['UsResult.FismaSystem'] = array('content' => __('FISMA System'));
if(!$stripped)$th['UsResult.reports_organization_id'] = array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name'));
if(!$stripped)$th['UsResult.host_description'] = array('content' => __('Host Description'), 'options' => array('sort' => 'UsResult.host_description'));
$th['UsResult.ip_address'] = array('content' => __('Ip Address'), 'options' => array('sort' => 'UsResult.ip_address'));
$th['UsResult.host_name'] = array('content' => __('Hostname'), 'options' => array('sort' => 'UsResult.host_name'));
if(!$stripped)$th['UsResult.mac_address'] = array('content' => __('Mac Address'), 'options' => array('sort' => 'UsResult.mac_address'));
if(!$stripped)$th['UsResult.asset_tag'] = array('content' => __('Asset Tag'), 'options' => array('sort' => 'UsResult.asset_tag'));
$th['UsResult.netbios'] = array('content' => __('NetBIOS'), 'options' => array('sort' => 'UsResult.netbios'));
$th['UsResult.eol_software_id'] = array('content' => __('Software/Vulnerability'), 'options' => array('sort' => 'EolSoftware.name'));
$th['EolSoftware.tickets'] = array('content' => __('Tickets'), 'options' => array('sort' => 'EolSoftware.tickets'));
$th['EolSoftware.waiver'] = array('content' => __('Waivers'), 'options' => array('sort' => 'EolSoftware.waiver'));
$th['EolSoftware.changerequest'] = array('content' => __('CR IDs'), 'options' => array('sort' => 'EolSoftware.changerequest'));
if(!$stripped)$th['EolSoftware.reports_assignable_party_id'] = array('content' => __('Assignable Party'), 'options' => array('sort' => 'EolSoftware.reports_assignable_party_id'));
if(!$stripped)$th['EolSoftware.reports_remediation_id'] = array('content' => __('Remediation'), 'options' => array('sort' => 'EolSoftware.reports_remediation_id'));
if(!$stripped)$th['EolSoftware.reports_verification_id'] = array('content' => __('Verification'), 'options' => array('sort' => 'EolSoftware.reports_verification_id'));
$th['UsResult.reports_status_id'] = array('content' => __('Status'), 'options' => array('sort' => 'UsResult.reports_status_id'));
$th['EolSoftware.hw_price'] = array('content' => __('Hardware $'), 'options' => array('sort' => 'EolSoftware.hw_price'));
$th['EolSoftware.sw_price'] = array('content' => __('Software $'), 'options' => array('sort' => 'EolSoftware.sw_price'));
if(!$stripped)$th['UsResult.status_date'] = array('content' => __('Status Changed Date'), 'options' => array('sort' => 'UsResult.status_date' ));
$th['UsResult.reported_to_ic_date'] = array('content' => __('Reported to ORG/IC Date'), 'options' => array('sort' => 'UsResult.reported_to_ic_date'));
$th['EolSoftware.resolved_by_date'] = array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'EolSoftware.resolved_by_date'));
if(!$stripped)$th['EolSoftware.verification_date'] = array('content' => __('Verified Date'), 'options' => array('sort' => 'EolSoftware.verification_date' ));
if(!$stripped)$th['EolSoftware.remediation_date'] = array('content' => __('Remediated Date'), 'options' => array('sort' => 'EolSoftware.remediation_date' ));
if(!$stripped)$th['EolSoftware.action_date'] = array('content' => __('Action Date'), 'options' => array('sort' => 'EolSoftware.action_date' ));
if(!$stripped)$th['UsResult.modified'] = array('content' => __('Modified'), 'options' => array('sort' => 'UsResult.modified' ));
if(!$stripped)$th['UsResult.created'] = array('content' => __('Created'), 'options' => array('sort' => 'UsResult.created' ));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($usResults as $i => $usResult)
{
	$usResult = $this->ReportResults->addFismaSystemInfo($usResult);
	
	$highlightDueDate = false;
	if(isset($usResult['ReportsStatus']['name'])
		and $this->Common->slugify($usResult['ReportsStatus']['name']) == 'open')
	{
		$resolvedByDate = strtotime($usResult['EolSoftware']['resolved_by_date']);
		if($resolvedByDate <= $thresholdNow)
			$highlightDueDate = 'highlight-red';
		elseif($resolvedByDate <= $thresholdSoon)
			$highlightDueDate = 'highlight-yellow';
	}
	
	$td[$i] = array();
	$td[$i]['UsResult.id'] = $usResult['UsResult']['id'];
	if(!$stripped)$td[$i]['UsResult.Division'] = $usResult['division_links'];
	if(!$stripped)$td[$i]['UsResult.Branch'] = $usResult['branch_links'];
	$td[$i]['UsResult.FismaSystem'] = $usResult['fisma_system_links'];
	if(!$stripped)$td[$i]['UsResult.reports_organization_id'] = $usResult['ReportsOrganization']['name'];
	if(!$stripped)$td[$i]['UsResult.host_description'] = $usResult['UsResult']['host_description'];
	$td[$i]['UsResult.ip_address'] = $usResult['UsResult']['ip_address'];
	$td[$i]['UsResult.host_name'] = $usResult['UsResult']['host_name'];
	if(!$stripped)$td[$i]['UsResult.mac_address'] = $usResult['UsResult']['mac_address'];
	if(!$stripped)$td[$i]['UsResult.asset_tag'] = $usResult['UsResult']['asset_tag'];
	$td[$i]['UsResult.netbios'] = $usResult['UsResult']['netbios'];
	$td[$i]['UsResult.eol_software_id'] = $usResult['EolSoftware']['name'];
	$td[$i]['EolSoftware.tickets'] = $this->Local->ticketLinks($usResult['EolSoftware']['tickets']);
	$td[$i]['EolSoftware.waiver'] = $this->Local->waiverLinks($usResult['EolSoftware']['waiver']);
	$td[$i]['EolSoftware.changerequest'] = $this->Local->crLinks($usResult['EolSoftware']['changerequest']);
	if(!$stripped)$td[$i]['EolSoftware.reports_assignable_party_id'] = (isset($usResult['EolSoftware']['ReportsAssignableParty']['name'])?$usResult['EolSoftware']['ReportsAssignableParty']['name']:false);
	if(!$stripped)$td[$i]['EolSoftware.reports_remediation_id'] = (isset($usResult['EolSoftware']['ReportsRemediation']['name'])?$usResult['EolSoftware']['ReportsRemediation']['name']:false);
	if(!$stripped)$td[$i]['EolSoftware.reports_verification_id'] = (isset($usResult['EolSoftware']['ReportsVerification']['name'])?$usResult['EolSoftware']['ReportsVerification']['name']:false);
	$td[$i]['UsResult.reports_status_id'] = $usResult['ReportsStatus']['name'];
	$td[$i]['EolSoftware.hw_price'] = $this->Common->nicePrice($usResult['EolSoftware']['hw_price']);
	$td[$i]['EolSoftware.sw_price'] = $this->Common->nicePrice($usResult['EolSoftware']['sw_price']);
	if(!$stripped)$td[$i]['UsResult.status_date'] = $this->Wrap->niceDay($usResult['UsResult']['status_date']);
	$td[$i]['UsResult.reported_to_ic_date'] = $this->Wrap->niceDay($usResult['UsResult']['reported_to_ic_date']);
	$td[$i]['EolSoftware.resolved_by_date'] = array($this->Wrap->niceDay($usResult['EolSoftware']['resolved_by_date']), array('class' => $highlightDueDate));
	if(!$stripped)$td[$i]['EolSoftware.verification_date'] = $this->Wrap->niceDay($usResult['EolSoftware']['verification_date']);
	if(!$stripped)$td[$i]['EolSoftware.remediation_date'] = $this->Wrap->niceDay($usResult['EolSoftware']['remediation_date']);
	if(!$stripped)$td[$i]['EolSoftware.action_date'] = $this->Wrap->niceDay($usResult['EolSoftware']['action_date']);
	if(!$stripped)$td[$i]['UsResult.modified'] = $this->Wrap->niceTime($usResult['UsResult']['modified']);
	if(!$stripped)$td[$i]['UsResult.created'] = $this->Wrap->niceTime($usResult['UsResult']['created']);
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