<?php 

$page_subtitle = (isset($page_subtitle)?$page_subtitle:__('All Results'));
$page_options = [];

if($this->action != 'us_report')
	$page_options['UsReport.latest'] = $this->Html->link(__('From latest report'), $this->Html->urlModify(['latest' => 1]), ['class' => 'tab-hijack block-hijack']);
$page_options['ReportsStatus.0'] = $this->Html->link(__('All Results'), $this->Html->urlModify(array('reports_status_id' => 0, 'latest' => 0)), array('class' => 'tab-hijack block-hijack'));
foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{
	$page_options['ReportsStatus.'. $reportsStatus_id] = $this->Html->link(__('With Status: %s', $reportsStatus_name), $this->Html->urlModify(array('reports_status_id' => $reportsStatus_id)), array('class' => 'tab-hijack'));
}

if(isset($no_options))
	$page_options = [];
	
$page_options2 = [];
if($this->Wrap->roleCheck(['admin', 'saa', 'reviewer']))
{
	$page_options2['autoclose'] = $this->Html->link(__('Auto Close Results'), array('action' => 'autoclose'), array('confirm' => __('Are you sure?')));
}

$th = array(
	'UsResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'UsResult.id')),
	'UsResult.report_count' => array('content' => __('# Reports')),
	'UsResult.Division' => array('content' => __('Division')),
	'UsResult.Branch' => array('content' => __('Branch')),
	'UsResult.fisma_system_id' => array('content' => __('FISMA System'), 'options' => array('editable' => array('type' => 'select', 'options' => $fismaSystems) )),
	'UsResult.fisma_system.owner_contact_id' => array('content' => __('System Owner')),
	'UsResult.fisma_system.tech_poc_id' => array('content' => __('Tech POCs')),
	'UsResult.reports_organization_id' => array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name', 'editable' => array('type' => 'select', 'options' => $reportsOrganizations) )),
	'UsResult.host_description' => array('content' => __('Host Description'), 'options' => array('sort' => 'UsResult.host_description', 'editable' => array('type' => 'text'))),
	
	'UsResult.counts' => array('content' => __('# US/EOL/PT/HR')),
	'UsResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'UsResult.ip_address', 'editable' => array('type' => 'text'))),
	'UsResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'UsResult.host_name', 'editable' => array('type' => 'text'))),
	'UsResult.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'UsResult.mac_address', 'editable' => array('type' => 'text'))),
	'UsResult.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'UsResult.asset_tag', 'editable' => array('type' => 'text'))),
	'UsResult.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'UsResult.netbios', 'editable' => array('type' => 'text'))),
	
	'UsResult.eol_software_id' => array('content' => __('Software/Vulnerability'), 'options' => array('sort' => 'EolSoftware.name')),
	'EolSoftware.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'EolSoftware.tickets', 'editable' => array('type' => 'text'))),
	'EolSoftware.waiver' => array('content' => __('Waivers'), 'options' => array('sort' => 'EolSoftware.waiver', 'editable' => array('type' => 'text'))),
	'EolSoftware.changerequest' => array('content' => __('CR IDs'), 'options' => array('sort' => 'EolSoftware.changerequest', 'editable' => array('type' => 'text'))),
	'UsResult.nessus' => array('content' => __('Nessus'), 'options' => array('sort' => 'UsResult.nessus')),
	'UsResult.reported_to_ic_date' => array('content' => __('Reported to ORG/IC Date'), 'options' => array('sort' => 'UsResult.reported_to_ic_date', 'editable' => array('type' => 'date') )),
	'EolSoftware.resolved_by_date' => array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'EolSoftware.resolved_by_date')),
	'UsResult.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'ReportsStatus.name')),
	'UsResult.status_date' => array('content' => __('Status Changed Date'), 'options' => array('sort' => 'UsResult.status_date')),
	'EolSoftware.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'ReportsAssignableParty.name')),
	'EolSoftware.assignable_party_date' => array('content' => __('Assignable Party Date'), 'options' => array('sort' => 'EolSoftware.remediation_date')),
	'EolSoftware.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'ReportsRemediation.name')),
	'EolSoftware.remediation_date' => array('content' => __('Remediation Date'), 'options' => array('sort' => 'EolSoftware.remediation_date')),
	'EolSoftware.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'ReportsVerification.name')),
	'EolSoftware.verification_date' => array('content' => __('Verification Date'), 'options' => array('sort' => 'EolSoftware.verification_date')),
	'EolSoftware.action_date' => array('content' => __('Action Date'), 'options' => array('sort' => 'EolSoftware.action_date')),
	'EolSoftware.hw_price' => array('content' => __('Hardware $'), 'options' => array('sort' => 'EolSoftware.hw_price')),
	'EolSoftware.sw_price' => array('content' => __('Software $'), 'options' => array('sort' => 'EolSoftware.sw_price')),
	'UsResult.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'UsResult.modified' )),
	'UsResult.created' => array('content' => __('Created'), 'options' => array('sort' => 'UsResult.created' )),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
	'multiselect' => true,
); 

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($us_results as $i => $us_result)
{
	// fix for the crazy xref stuff
	if(isset($us_result['UsResult']['ReportsOrganization']))
		$us_result['ReportsOrganization'] = $us_result['UsResult']['ReportsOrganization'];
	if(isset($us_result['UsResult']['EolSoftware']))
		$us_result['EolSoftware'] = $us_result['UsResult']['EolSoftware'];
	if(isset($us_result['EolSoftware']['ReportsAssignableParty']))
		$us_result['ReportsAssignableParty'] = $us_result['EolSoftware']['ReportsAssignableParty'];
	if(isset($us_result['EolSoftware']['ReportsRemediation']))
		$us_result['ReportsRemediation'] = $us_result['EolSoftware']['ReportsRemediation'];
	if(isset($us_result['EolSoftware']['ReportsVerification']))
		$us_result['ReportsVerification'] = $us_result['EolSoftware']['ReportsVerification'];
	if(isset($us_result['UsResult']['ReportsStatus']))
		$us_result['ReportsStatus'] = $us_result['UsResult']['ReportsStatus'];
	
	$action_date = $this->Wrap->niceTime($us_result['EolSoftware']['action_date']);	
	
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('action' => 'view', $us_result['UsResult']['id'], 'prefix' => false));
	if($this->Wrap->roleCheck(array('admin', 'reviewer', 'saa')))
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $us_result['UsResult']['id'], 'prefix' => false));
	if($this->Wrap->roleCheck(array('admin')))
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $us_result['UsResult']['id'], 'admin' => true), array('confirm' => __('Are you sure?')));
	
	$actions = implode("", $actions);
	
	$edit_id = array(
		'UsResult' => $us_result['UsResult']['id'],
	);
	
	$us_result = $this->ReportResults->addFismaSystemInfo($us_result);
	
	$mclass_ip = ($us_result['match_tracking']['ip_address']?'bold':false);
	$mclass_host = ($us_result['match_tracking']['host_name']?'bold':false);
	$mclass_mac = ($us_result['match_tracking']['mac_address']?'bold':false);
	$mclass_asset = ($us_result['match_tracking']['asset_tag']?'bold':false);
	
	$highlightDueDate = false;
	$statusStyle = false;
	if(isset($us_result['ReportsStatus']['name']))
	{
		if($this->Common->slugify($us_result['ReportsStatus']['name']) == 'open')
		{
			$resolvedByDate = strtotime($us_result['EolSoftware']['resolved_by_date']);
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
		else
		{
			$statusStyle = 'background-color: '.$this->Common->makeRGBfromHex($us_result['ReportsStatus']['color_code_hex'], '0.3').';';
		}
	}
	
	$counts = $this->ReportResults->ajaxCountsLinks($us_result['UsResult'], 'us_result', ['prefix' => false]);
	
	$td[$i] = array(
		$this->Html->link($us_result['UsResult']['id'], array('action' => 'view', $us_result['UsResult']['id'], 'prefix' => false)),
		array('.', array(
			'ajax_count_url' => array('controller' => 'us_reports', 'action' => 'us_result', $us_result['UsResult']['id'], 'prefix' => false), 
			'url' => array('action' => 'view', $us_result['UsResult']['id'], 'prefix' => false, 'tab' => 'us_reports'),
		)),
		$us_result['division_links'],
		$us_result['branch_links'],
		array($us_result['fisma_system_links'], array('value' => (isset($us_result['UsResult']['fisma_system_id'])?$us_result['UsResult']['fisma_system_id']:''))),
		$us_result['owner_links'],
		$us_result['techs_links'],
		array((isset($us_result['ReportsOrganization']['name'])?$us_result['ReportsOrganization']['name']:'&nbsp;'), array('value' => (isset($us_result['ReportsOrganization']['id'])?$us_result['ReportsOrganization']['id']:''))),
		$us_result['UsResult']['host_description'],
		$counts,
		array($this->Html->filterLink($us_result['UsResult']['ip_address'], array('field' => 'ip_address', 'value' => $us_result['UsResult']['ip_address'], 'prefix' => false)), array('class' => 'nowrap '.$mclass_ip )),
		array($this->Html->filterLink($us_result['UsResult']['host_name'], array('field' => 'host_name', 'value' => $us_result['UsResult']['host_name'], 'prefix' => false)), array('class' => 'nowrap '.$mclass_host)),
		array($us_result['UsResult']['mac_address'], array('class' => 'nowrap '.$mclass_mac)),
		array($us_result['UsResult']['asset_tag'], array('class' => 'nowrap '.$mclass_asset)),
		array($us_result['UsResult']['netbios'], array('class' => 'nowrap')),
		array(
			(isset($us_result['EolSoftware']['key_name'])?$this->Html->link($us_result['EolSoftware']['key_name'], array('controller' => 'eol_softwares', 'action' => 'view', $us_result['EolSoftware']['id'])):''), 
			array('class' => 'nowrap', 'value' => (isset($us_result['EolSoftware']['id'])?$us_result['EolSoftware']['id']:'')),
		),
		array($this->Local->ticketLinks($us_result['EolSoftware']['tickets']), array('class' => 'nowrap')),
		array($this->Local->waiverLinks($us_result['EolSoftware']['waiver']), array('class' => 'nowrap')),
		array($this->Local->waiverLinks($us_result['EolSoftware']['changerequest']), array('class' => 'nowrap')),
		$this->Common->yesNo($us_result['UsResult']['nessus']),
		array($this->Wrap->niceDay($us_result['UsResult']['reported_to_ic_date']), array('class' => 'nowrap')),
		array(
			$this->Wrap->niceDay($us_result['EolSoftware']['resolved_by_date']),
			array('class' => $highlightDueDate),
		),
		array(
			(isset($us_result['ReportsStatus']['name'])?$us_result['ReportsStatus']['name']:'&nbsp;'), 
			array('class' => 'nowrap', 'value' => (isset($us_result['ReportsStatus']['id'])?$us_result['ReportsStatus']['id']:0), 'data-style' => $statusStyle),
		),
		array($this->Wrap->niceDay($us_result['UsResult']['status_date']), array('class' => 'nowrap')),
		(isset($us_result['EolSoftware']['ReportsAssignableParty']['name'])?$us_result['EolSoftware']['ReportsAssignableParty']['name']:'&nbsp;'),
		array($this->Wrap->niceDay($us_result['EolSoftware']['assignable_party_date']), array('class' => 'nowrap')),
		(isset($us_result['EolSoftware']['ReportsRemediation']['name'])?$us_result['EolSoftware']['ReportsRemediation']['name']:'&nbsp;'),
		array($this->Wrap->niceDay($us_result['EolSoftware']['remediation_date']), array('class' => 'nowrap')),
		array(
			(isset($us_result['ReportsVerification']['name'])?$us_result['ReportsVerification']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($us_result['ReportsVerification']['id'])?$us_result['ReportsVerification']['id']:0)),
		),
		array($this->Wrap->niceDay($us_result['EolSoftware']['verification_date']), array('class' => 'nowrap')),
		array($this->Wrap->niceDay($us_result['EolSoftware']['action_date']), array('class' => 'nowrap')),
		array(
			(isset($us_result['EolSoftware']['hw_price'])?$this->Common->nicePrice($us_result['EolSoftware']['hw_price']):'&nbsp;'),
			array('class' => 'nowrap'),
		),
		array(
			(isset($us_result['EolSoftware']['sw_price'])?$this->Common->nicePrice($us_result['EolSoftware']['sw_price']):'&nbsp;'),
			array('class' => 'nowrap'),
		),
		array($this->Wrap->niceTime($us_result['UsResult']['modified']), array('class' => 'nowrap')),
		array($this->Wrap->niceTime($us_result['UsResult']['created']), array('class' => 'nowrap')),
		array(
			$actions,
			array('class' => 'actions'),
		),
		'multiselect' => $us_result['UsResult']['id'],
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
	$multiselectOptions[$ms_key] = __('Set all selected %s to one %s', __('US Results'), $ms_name);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => (isset($page_title)?$page_title:__('US Results')),
	'page_subtitle' => (isset($page_subtitle)?$page_subtitle:false),
	'page_description' => $page_description,
	'page_options_title' => __('Filter Results'),
	'page_options' => $page_options,
	'page_options2_title' => __('Options'),
	'page_options2' => $page_options2,
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