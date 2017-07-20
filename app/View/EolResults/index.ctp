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

$th = array(
	'EolResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'EolResult.id')),
	'EolResult.ticket_id' => array('content' => __('Ticket ID'), 'options' => array('sort' => 'EolResult.ticket_id', 'editable' => array('type' => 'text') )),
	'EolResult.Division' => array('content' => __('Division')),
	'EolResult.Branch' => array('content' => __('Branch')),
	'EolResult.fisma_system_id' => array('content' => __('FISMA System'), 'options' => array('editable' => array('type' => 'select', 'options' => $fismaSystems) )),
	'EolResult.fisma_system.owner_contact_id' => array('content' => __('System Owner')),
	'EolResult.fisma_system.tech_poc_id' => array('content' => __('Tech POCs')),
	'EolResult.reports_organization_id' => array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name', 'editable' => array('type' => 'select', 'options' => $reportsOrganizations) )),
	'EolResult.host_description' => array('content' => __('Host Description'), 'options' => array('sort' => 'EolResult.host_description', 'editable' => array('type' => 'text'))),
	
	'EolResult.counts' => array('content' => __('# US/EOL/PT/HR')),
	'EolResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'EolResult.ip_address', 'editable' => array('type' => 'text'))),
	'EolResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'EolResult.host_name', 'editable' => array('type' => 'text'))),
	'EolResult.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'EolResult.mac_address', 'editable' => array('type' => 'text'))),
	'EolResult.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'EolResult.asset_tag', 'editable' => array('type' => 'text'))),
	'EolResult.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'EolResult.netbios', 'editable' => array('type' => 'text'))),
	
	'EolResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'EolResult.ip_address', 'editable' => array('type' => 'text'))),
	'EolResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'EolResult.host_name', 'editable' => array('type' => 'text'))),
	'EolResult.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'EolResult.mac_address', 'editable' => array('type' => 'text'))),
	'EolResult.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'EolResult.asset_tag', 'editable' => array('type' => 'text'))),
	'EolResult.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'EolResult.netbios', 'editable' => array('type' => 'text'))),
	'EolResult.eol_software_id' => array('content' => __('Software/Vulnerability'), 'options' => array('sort' => 'EolSoftware.name', 'editable' => array('type' => 'select', 'options' => $eolSoftwares) )),
	'EolResult.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'EolResult.tickets', 'editable' => array('type' => 'text'))),
	'EolResult.waiver' => array('content' => __('Waivers'), 'options' => array('sort' => 'EolResult.waiver', 'editable' => array('type' => 'text'))),
	'EolResult.changerequest' => array('content' => __('CR IDs'), 'options' => array('sort' => 'EolResult.changerequest', 'editable' => array('type' => 'text'))),
	'EolResult.nessus' => array('content' => __('Nessus'), 'options' => array('sort' => 'EolResult.nessus')),
	'EolResult.resolved_by_date' => array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'EolResult.resolved_by_date', 'editable' => array('type' => 'date') )),
	'EolResult.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'ReportsStatus.name', 'editable' => array('type' => 'select', 'options' => $reportsStatuses) )),
	'EolResult.status_date' => array('content' => __('Status Changed Date'), 'options' => array('sort' => 'EolResult.status_date')),
	'EolResult.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'ReportsAssignableParty.name', 'editable' => array('type' => 'select', 'options' => $reportsAssignableParties) )),
	'EolResult.assignable_party_date' => array('content' => __('Assignable Party Date'), 'options' => array('sort' => 'EolResult.assignable_party_date')),
	'EolResult.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'ReportsRemediation.name', 'editable' => array('type' => 'select', 'options' => $reportsRemediations) )),
	'EolResult.remediation_date' => array('content' => __('Remediation Date'), 'options' => array('sort' => 'EolResult.remediation_date')),
	'EolResult.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'ReportsVerification.name', 'editable' => array('type' => 'select', 'options' => $reportsVerifications) )),
	'EolResult.verification_date' => array('content' => __('Verification Date'), 'options' => array('sort' => 'EolResult.verification_date')),
	'EolResult.action_date' => array('content' => __('Action Date'), 'options' => array('sort' => 'EolResult.action_date', 'editable' => array('type' => 'date') )),
	'EolResult.hw_price' => array('content' => __('Hardware $'), 'options' => array('sort' => 'EolResult.hw_price', 'editable' => array('type' => 'price'))),
	'EolResult.sw_price' => array('content' => __('Software $'), 'options' => array('sort' => 'EolResult.sw_price', 'editable' => array('type' => 'price'))),
	'EolResult.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'EolResult.modified' )),
	'EolResult.created' => array('content' => __('Created'), 'options' => array('sort' => 'EolResult.created' )),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
	'multiselect' => true,
); 

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($eol_results as $i => $eol_result)
{
	// fix for the crazy xref stuff
	if(isset($eol_result['EolResult']['ReportsOrganization']))
		$eol_result['ReportsOrganization'] = $eol_result['EolResult']['ReportsOrganization'];
	if(isset($eol_result['EolResult']['EolSoftware']))
		$eol_result['EolSoftware'] = $eol_result['EolResult']['EolSoftware'];
	if(isset($eol_result['EolResult']['ReportsRemediation']))
		$eol_result['ReportsRemediation'] = $eol_result['EolResult']['ReportsRemediation'];
	if(isset($eol_result['EolResult']['ReportsVerification']))
		$eol_result['ReportsVerification'] = $eol_result['EolResult']['ReportsVerification'];
	if(isset($eol_result['EolResult']['ReportsVerification']))
		$eol_result['ReportsVerification'] = $eol_result['EolResult']['ReportsVerification'];
	if(isset($eol_result['EolResult']['ReportsStatus']))
		$eol_result['ReportsStatus'] = $eol_result['EolResult']['ReportsStatus'];
	if(isset($eol_result['EolResult']['ReportsAssignableParty']))
		$eol_result['ReportsAssignableParty'] = $eol_result['EolResult']['ReportsAssignableParty'];
	
	$action_date = $this->Wrap->niceTime($eol_result['EolResult']['action_date']);	
	
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('action' => 'view', $eol_result['EolResult']['id'], 'admin' => false));
	if($this->Wrap->roleCheck(array('admin', 'reviewer', 'saa')))
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $eol_result['EolResult']['id'], 'admin' => false));
	if($this->Wrap->roleCheck(array('admin')))
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $eol_result['EolResult']['id'], 'admin' => true), array('confirm' => __('Are you sure?')));
	
	$actions = implode("", $actions);
	
	$edit_id = array(
		'EolResult' => $eol_result['EolResult']['id'],
	);
	
	$eol_result = $this->ReportResults->addFismaSystemInfo($eol_result);
	$mclass_ip = ($eol_result['match_tracking']['ip_address']?'bold':false);
	$mclass_host = ($eol_result['match_tracking']['host_name']?'bold':false);
	$mclass_mac = ($eol_result['match_tracking']['mac_address']?'bold':false);
	$mclass_asset = ($eol_result['match_tracking']['asset_tag']?'bold':false);
	
	$highlightDueDate = false;
	$statusStyle = false;
	if(isset($eol_result['ReportsStatus']['name']))
	{
		if($this->Common->slugify($eol_result['ReportsStatus']['name']) == 'open')
		{
			$resolvedByDate = strtotime($eol_result['EolResult']['resolved_by_date']);
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
		else
		{
			$statusStyle = 'background-color: '.$this->Common->makeRGBfromHex($eol_result['ReportsStatus']['color_code_hex'], '0.3').';';
		}
	}
	
	$counts = $this->ReportResults->ajaxCountsLinks($eol_result['EolResult'], 'eol_result', ['prefix' => false]);
	
	$td[$i] = array(
		$this->Html->link($eol_result['EolResult']['id'], array('action' => 'view', $eol_result['EolResult']['id'])),
		$eol_result['EolResult']['ticket_id'],
		$eol_result['division_links'],
		$eol_result['branch_links'],
		array($eol_result['fisma_system_links'], array('value' => (isset($eol_result['EolResult']['fisma_system_id'])?$eol_result['EolResult']['fisma_system_id']:''))),
		$eol_result['owner_links'],
		$eol_result['techs_links'],
		array((isset($eol_result['ReportsOrganization']['name'])?$eol_result['ReportsOrganization']['name']:'&nbsp;'), array('class' => 'nowrap', 'value' => (isset($eol_result['ReportsOrganization']['id'])?$eol_result['ReportsOrganization']['id']:false))),
		$eol_result['EolResult']['host_description'],
		$counts,
		array($this->Html->filterLink($eol_result['EolResult']['ip_address'], array('field' => 'ip_address', 'value' => $eol_result['EolResult']['ip_address'])), array('class' => 'nowrap '.$mclass_ip )),
		array($this->Html->filterLink($eol_result['EolResult']['host_name'], array('field' => 'host_name', 'value' => $eol_result['EolResult']['host_name'])), array('class' => 'nowrap '.$mclass_host)),
		array($eol_result['EolResult']['mac_address'], array('class' => 'nowrap '.$mclass_mac)),
		array($eol_result['EolResult']['asset_tag'], array('class' => 'nowrap '.$mclass_asset)),
		array($eol_result['EolResult']['netbios'], array('class' => 'nowrap')),
		array(
			(isset($eol_result['EolSoftware']['name'])?$this->Html->link($eol_result['EolSoftware']['name'], array('controller' => 'eol_softwares', 'action' => 'view', $eol_result['EolSoftware']['id'])):''), 
			array('class' => 'nowrap', 'value' => (isset($eol_result['EolSoftware']['id'])?$eol_result['EolSoftware']['id']:'')),
		),
		array($this->Local->ticketLinks($eol_result['EolResult']['tickets']), array('class' => 'nowrap')),
		array($this->Local->waiverLinks($eol_result['EolResult']['waiver']), array('class' => 'nowrap')),
		array($this->Local->crLinks($eol_result['EolResult']['changerequest']), array('class' => 'nowrap')),
		$this->Common->yesNo($eol_result['EolResult']['nessus']),
		array(
			$this->Wrap->niceDay($eol_result['EolResult']['resolved_by_date']),
			array('value' => $eol_result['EolResult']['resolved_by_date'], 'class' => $highlightDueDate),
		),
		array(
			(isset($eol_result['ReportsStatus']['name'])?$eol_result['ReportsStatus']['name']:'&nbsp;'), 
			array('class' => 'nowrap', 'value' => (isset($eol_result['ReportsStatus']['id'])?$eol_result['ReportsStatus']['id']:0), 'data-style' => $statusStyle),
		),
		array($this->Wrap->niceDay($eol_result['EolResult']['status_date']), array('class' => 'nowrap', 'value' => ($eol_result['EolResult']['status_date']?$eol_result['EolResult']['status_date']:false))),
		array(
			(isset($eol_result['ReportsAssignableParty']['name'])?$eol_result['ReportsAssignableParty']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eol_result['ReportsAssignableParty']['id'])?$eol_result['ReportsAssignableParty']['id']:0)),
		),
		array($this->Wrap->niceDay($eol_result['EolResult']['assignable_party_date']), array('class' => 'nowrap', 'value' => ($eol_result['EolResult']['remediation_date']?$eol_result['EolResult']['assignable_party_date']:false))),
		array(
			(isset($eol_result['ReportsRemediation']['name'])?$eol_result['ReportsRemediation']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eol_result['ReportsRemediation']['id'])?$eol_result['ReportsRemediation']['id']:0)),
		),
		array($this->Wrap->niceDay($eol_result['EolResult']['remediation_date']), array('class' => 'nowrap', 'value' => ($eol_result['EolResult']['remediation_date']?$eol_result['EolResult']['remediation_date']:false))),
		array(
			(isset($eol_result['ReportsVerification']['name'])?$eol_result['ReportsVerification']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eol_result['ReportsVerification']['id'])?$eol_result['ReportsVerification']['id']:0)),
		),
		array($this->Wrap->niceDay($eol_result['EolResult']['verification_date']), array('class' => 'nowrap', 'value' => ($eol_result['EolResult']['verification_date']?$eol_result['EolResult']['verification_date']:false))),
		array($this->Wrap->niceDay($eol_result['EolResult']['action_date']), array('class' => 'nowrap', 'value' => ($eol_result['EolResult']['action_date']?$eol_result['EolResult']['action_date']:false))),
		array(
			(isset($eol_result['EolResult']['hw_price'])?$this->Common->nicePrice($eol_result['EolResult']['hw_price']):'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eol_result['EolResult']['hw_price'])?$eol_result['EolResult']['hw_price']:0)),
		),
		array(
			(isset($eol_result['EolResult']['sw_price'])?$this->Common->nicePrice($eol_result['EolResult']['sw_price']):'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eol_result['EolResult']['sw_price'])?$eol_result['EolResult']['sw_price']:0)),
		),
		array($this->Wrap->niceTime($eol_result['EolResult']['modified']), array('class' => 'nowrap')),
		array($this->Wrap->niceTime($eol_result['EolResult']['created']), array('class' => 'nowrap')),
		array(
			$actions,
			array('class' => 'actions'),
		),
		'multiselect' => $eol_result['EolResult']['id'],
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
	$multiselectOptions[$ms_key] = __('Set all selected %s to one %s', __('EOL Results'), $ms_name);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('EOL Results'),
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
			self.element.find('td[data-style]').each(function(){ $(this).parents('tr').find('td').attr('style', $(this).data('style')) });
		"
	),
	// grid/inline edit options
	'use_gridedit' => $use_gridedit,
	//'use_gridadd' => $user_gridadd,
	'use_griddelete' => $use_griddelete,
	'use_multiselect' => true,
	'multiselect_options' => $multiselectOptions,
));