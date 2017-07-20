<?php 

$allUrl = array('action' => $this->action);
if(isset($passedArgs[0]))
	$allUrl[0] = $passedArgs[0];
$page_options = array(
	'all' => $this->Html->link(__('All Results'), $allUrl, array('class' => 'tab-hijack')),
);
foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{
	$page_options['ReportsStatus.'. $reportsStatus_id] = $this->Html->link(__('With Status: %s', $reportsStatus_name), array_merge($allUrl, array('field' => 'reports_status_id', 'value' => $reportsStatus_id)), array('class' => 'tab-hijack'));
}

if(isset($no_options))
	$page_options = [];

// content
$th = array(
	'HighRiskResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'HighRiskResult.id')),
	'HighRiskResult.ticket_id' => array('content' => __('Ticket ID'), 'options' => array('sort' => 'HighRiskResult.ticket_id', 'editable' => array('type' => 'text') )),
	'HighRiskResult.Division' => array('content' => __('Division')),
	'HighRiskResult.Branch' => array('content' => __('Branch')),
	'HighRiskResult.fisma_system_id' => array('content' => __('FISMA System'), 'options' => array('editable' => array('type' => 'select', 'options' => $fismaSystems) )),
	'HighRiskResult.fisma_system.owner_contact_id' => array('content' => __('System Owner')),
	'HighRiskResult.fisma_system.tech_poc_id' => array('content' => __('Tech POCs')),
	'HighRiskResult.reports_system_type_id' => array('content' => __('System Type'), 'options' => array('sort' => 'ReportsSystemType.name', 'editable' => array('type' => 'select', 'options' => $reportsSystemTypes) )),
	
	'HighRiskResult.counts' => array('content' => __('# US/EOL/PT/HR')),
	'HighRiskResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'HighRiskResult.ip_address', 'editable' => array('type' => 'text'))),
	'HighRiskResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'HighRiskResult.host_name', 'editable' => array('type' => 'text'))),
	'HighRiskResult.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'HighRiskResult.mac_address', 'editable' => array('type' => 'text'))),
	'HighRiskResult.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'HighRiskResult.asset_tag', 'editable' => array('type' => 'text'))),
	
	'HighRiskResult.port' => array('content' => __('Port'), 'options' => array('sort' => 'HighRiskResult.port', 'editable' => array('type' => 'text'))),
	'HighRiskResult.dhs' => array('content' => __('DHS'), 'options' => array('sort' => 'HighRiskResult.dhs', 'editable' => array('type' => 'text'))),
	'HighRiskResult.eol_software_id' => array('content' => __('Software/Vulnerability'), 'options' => array('sort' => 'EolSoftware.name', 'editable' => array('type' => 'select', 'options' => $eolSoftwares) )),
	'HighRiskResult.ticket' => array('content' => __('Ticket'), 'options' => array('sort' => 'HighRiskResult.ticket', 'editable' => array('type' => 'text'))),
	'HighRiskResult.waiver' => array('content' => __('Waivers'), 'options' => array('sort' => 'HighRiskResult.waiver', 'editable' => array('type' => 'text'))),
	'HighRiskResult.changerequest' => array('content' => __('CR IDs'), 'options' => array('sort' => 'HighRiskResult.changerequest', 'editable' => array('type' => 'text'))),
	'HighRiskResult.reported_to_ic_date' => array('content' => __('Reported to ORG/IC'), 'options' => array('sort' => 'HighRiskResult.reported_to_ic_date', 'editable' => array('type' => 'date') )),
	'HighRiskResult.resolved_by_date' => array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'HighRiskResult.resolved_by_date', 'editable' => array('type' => 'date') )),
	'HighRiskResult.estimated_remediation_date' => array('content' => __('Est. Remediation Date'), 'options' => array('sort' => 'HighRiskResult.estimated_remediation_date', 'editable' => array('type' => 'date') )),
	'HighRiskResult.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'ReportsStatus.name', 'editable' => array('type' => 'select', 'options' => $reportsStatuses) )),
	'HighRiskResult.status_date' => array('content' => __('Status Changed Date'), 'options' => array('sort' => 'HighRiskResult.status_date')),
	'HighRiskResult.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'ReportsAssignableParty.name', 'editable' => array('type' => 'select', 'options' => $reportsAssignableParties) )),
	'HighRiskResult.assignable_party_date' => array('content' => __('Assignable Party Date'), 'options' => array('sort' => 'HighRiskResult.assignable_party_date')),
	'HighRiskResult.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'ReportsRemediation.name', 'editable' => array('type' => 'select', 'options' => $reportsRemediations) )),
	'HighRiskResult.remediation_date' => array('content' => __('Remediation Date'), 'options' => array('sort' => 'HighRiskResult.remediation_date')),
	'HighRiskResult.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'ReportsVerification.name', 'editable' => array('type' => 'select', 'options' => $reportsVerifications) )),
	'HighRiskResult.verification_date' => array('content' => __('Verification Date'), 'options' => array('sort' => 'HighRiskResult.verification_date')),
	'HighRiskResult.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'HighRiskResult.modified' )),
	'HighRiskResult.created' => array('content' => __('Created'), 'options' => array('sort' => 'HighRiskResult.created' )),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
	'multiselect' => true,
);

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($high_risk_results as $i => $high_risk_result)
{
	// fix for the crazy xref stuff
	if(isset($high_risk_result['HighRiskResult']['ReportsSystemType']))
		$high_risk_result['ReportsSystemType'] = $high_risk_result['HighRiskResult']['ReportsSystemType'];
	if(isset($high_risk_result['HighRiskResult']['ReportsAssignableParty']))
		$high_risk_result['ReportsAssignableParty'] = $high_risk_result['HighRiskResult']['ReportsAssignableParty'];
	if(isset($high_risk_result['HighRiskResult']['ReportsRemediation']))
		$high_risk_result['ReportsRemediation'] = $high_risk_result['HighRiskResult']['ReportsRemediation'];
	if(isset($high_risk_result['HighRiskResult']['ReportsVerification']))
		$high_risk_result['ReportsVerification'] = $high_risk_result['HighRiskResult']['ReportsVerification'];
	if(isset($high_risk_result['HighRiskResult']['ReportsStatus']))
		$high_risk_result['ReportsStatus'] = $high_risk_result['HighRiskResult']['ReportsStatus'];
	if(isset($high_risk_result['HighRiskResult']['EolSoftware']))
		$high_risk_result['EolSoftware'] = $high_risk_result['HighRiskResult']['EolSoftware'];
	
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('action' => 'view', $high_risk_result['HighRiskResult']['id']));
	if($this->Wrap->roleCheck(array('admin', 'reviewer', 'saa')))
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $high_risk_result['HighRiskResult']['id']));
	if($this->Wrap->roleCheck(array('admin')))
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $high_risk_result['HighRiskResult']['id'], 'admin' => true));
	
	$actions = implode('', $actions);
	
	$edit_id = array(
		'HighRiskResult' => $high_risk_result['HighRiskResult']['id'],
	);
	
	$high_risk_result = $this->ReportResults->addFismaSystemInfo($high_risk_result);
	$mclass_ip = ($high_risk_result['match_tracking']['ip_address']?'bold':false);
	$mclass_host = ($high_risk_result['match_tracking']['host_name']?'bold':false);
	$mclass_mac = ($high_risk_result['match_tracking']['mac_address']?'bold':false);
	$mclass_asset = ($high_risk_result['match_tracking']['asset_tag']?'bold':false);
	
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
	
	$counts = $this->ReportResults->ajaxCountsLinks($high_risk_result['HighRiskResult'], 'high_risk_result', ['prefix' => false]);
	
	$td[$i] = array(
		$this->Html->link($high_risk_result['HighRiskResult']['id'], array('action' => 'view', $high_risk_result['HighRiskResult']['id'])),
		$high_risk_result['HighRiskResult']['ticket_id'],
		$high_risk_result['division_links'],
		$high_risk_result['branch_links'],
		array($high_risk_result['fisma_system_links'], array('value' => (isset($high_risk_result['HighRiskResult']['fisma_system_id'])?$high_risk_result['HighRiskResult']['fisma_system_id']:''))),
		$high_risk_result['owner_links'],
		$high_risk_result['techs_links'],
		array(
			(isset($high_risk_result['ReportsSystemType']['name'])?$high_risk_result['ReportsSystemType']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result['ReportsSystemType']['id'])?$high_risk_result['ReportsSystemType']['id']:0)),
		),
		$counts,
		array($this->Html->filterLink($high_risk_result['HighRiskResult']['ip_address'], array('field' => 'ip_address', 'value' => $high_risk_result['HighRiskResult']['ip_address'])), array('class' => 'nowrap '.$mclass_ip )),
		array($this->Html->filterLink($high_risk_result['HighRiskResult']['host_name'], array('field' => 'host_name', 'value' => $high_risk_result['HighRiskResult']['host_name'])), array('class' => 'nowrap '.$mclass_host)),
		array($high_risk_result['HighRiskResult']['mac_address'], array('class' => 'nowrap '.$mclass_mac)),
		array($high_risk_result['HighRiskResult']['asset_tag'], array('class' => 'nowrap '.$mclass_asset)),
		
		$high_risk_result['HighRiskResult']['port'],
		$high_risk_result['HighRiskResult']['dhs'],
		array(
			(isset($high_risk_result['EolSoftware']['name'])?$this->Html->link($high_risk_result['EolSoftware']['name'], array('controller' => 'eol_softwares', 'action' => 'view', $high_risk_result['EolSoftware']['id'])):''), 
			array('class' => 'nowrap', 'value' => (isset($high_risk_result['EolSoftware']['id'])?$high_risk_result['EolSoftware']['id']:'')),
		),
		$this->Local->ticketLinks($high_risk_result['HighRiskResult']['ticket']),
		$this->Local->waiverLinks($high_risk_result['HighRiskResult']['waiver']),
		array($this->Local->crLinks($high_risk_result['HighRiskResult']['changerequest']), array('class' => 'nowrap')),
		array(
			$this->Wrap->niceDay($high_risk_result['HighRiskResult']['reported_to_ic_date']),
			array('value' => $high_risk_result['HighRiskResult']['reported_to_ic_date']),
		),
		array(
			$this->Wrap->niceDay($high_risk_result['HighRiskResult']['resolved_by_date']),
			array('value' => $high_risk_result['HighRiskResult']['resolved_by_date'], 'class' => $highlightDueDate),
		),
		array(
			$this->Wrap->niceDay($high_risk_result['HighRiskResult']['estimated_remediation_date']),
			array('value' => $high_risk_result['HighRiskResult']['estimated_remediation_date']),
		),
		array(
			(isset($high_risk_result['ReportsStatus']['name'])?$high_risk_result['ReportsStatus']['name']:'&nbsp;'), 
			array('class' => 'nowrap', 'value' => (isset($high_risk_result['ReportsStatus']['id'])?$high_risk_result['ReportsStatus']['id']:0), 'data-style' => $statusStyle),
		),
		array($this->Wrap->niceDay($high_risk_result['HighRiskResult']['status_date']), array('class' => 'nowrap', 'value' => ($high_risk_result['HighRiskResult']['status_date']?$high_risk_result['HighRiskResult']['status_date']:false))),
		array(
			(isset($high_risk_result['ReportsAssignableParty']['name'])?$high_risk_result['ReportsAssignableParty']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result['ReportsAssignableParty']['id'])?$high_risk_result['ReportsAssignableParty']['id']:0)),
		),
		array($this->Wrap->niceDay($high_risk_result['HighRiskResult']['assignable_party_date']), array('class' => 'nowrap', 'value' => ($high_risk_result['HighRiskResult']['assignable_party_date']?$high_risk_result['HighRiskResult']['assignable_party_date']:false))),
		array(
			(isset($high_risk_result['ReportsRemediation']['name'])?$high_risk_result['ReportsRemediation']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result['ReportsRemediation']['id'])?$high_risk_result['ReportsRemediation']['id']:0)),
		),
		array($this->Wrap->niceDay($high_risk_result['HighRiskResult']['remediation_date']), array('class' => 'nowrap', 'value' => ($high_risk_result['HighRiskResult']['remediation_date']?$high_risk_result['HighRiskResult']['remediation_date']:false))),
		array(
			(isset($high_risk_result['ReportsVerification']['name'])?$high_risk_result['ReportsVerification']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result['ReportsVerification']['id'])?$high_risk_result['ReportsVerification']['id']:0)),
		),
		array($this->Wrap->niceDay($high_risk_result['HighRiskResult']['verification_date']), array('class' => 'nowrap', 'value' => ($high_risk_result['HighRiskResult']['verification_date']?$high_risk_result['HighRiskResult']['verification_date']:false))),
		array($this->Wrap->niceTime($high_risk_result['HighRiskResult']['modified']), array('class' => 'nowrap')),
		array($this->Wrap->niceTime($high_risk_result['HighRiskResult']['created']), array('class' => 'nowrap')),
		array(
			$actions,
			array('class' => 'actions'),
		),
		'multiselect' => $high_risk_result['HighRiskResult']['id'],
		'edit_id' => $edit_id,
	);
}

$use_gridedit = false;
$use_griddelete = $user_gridadd = false;
if($this->Wrap->roleCheck(array('admin', 'reviewer', 'saa')))
	$use_gridedit = true;
if($this->Wrap->roleCheck(array('admin')))
	$use_griddelete = $user_gridadd = true;

foreach($multiselectOptions as $ms_key => $ms_name)
{
	$multiselectOptions[$ms_key] = __('Set all selected %s to one %s', __('High Risk Results'), $ms_name);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('High Risk Results'),
	'page_subtitle' => (isset($page_subtitle)?$page_subtitle:false),
	'page_description' => $page_description,
	'page_options_title' => __('View By %s', __('Status')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.<br/>%s with a &dagger; next to them have been manually chosen', __('FISMA Systems')),
	'table_widget_options' => array(
		'setup' => "
			self.element.find('td.highlight-red').parents('tr').addClass('highlight-red');
			self.element.find('td.highlight-yellow').parents('tr').addClass('highlight-yellow');
			self.element.find('td[data-style]').each(function(){ $(this).parents('tr').attr('style', $(this).data('style')) });
		"
	),
	// grid/inline edit options
	'use_gridedit' => $use_gridedit,
	//'use_gridadd' => $user_gridadd,
	'use_griddelete' => $use_griddelete,
	'use_multiselect' => true,
	'multiselect_options' => $multiselectOptions,
));