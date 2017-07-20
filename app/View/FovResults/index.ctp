<?php 

$allUrl = ['action' => $this->action];
if(isset($passedArgs[0]))
	$allUrl[0] = $passedArgs[0];
$page_options = [
	'all' => $this->Html->link(__('All Results'), $allUrl, ['class' => 'tab-hijack']),
];
foreach($reportsStatuses as $reportsStatus_id => $reportsStatus_name)
{
	$page_options['ReportsStatus.'. $reportsStatus_id] = $this->Html->link(__('With Status: %s', $reportsStatus_name), array_merge($allUrl, ['field' => 'reports_status_id', 'value' => $reportsStatus_id]), ['class' => 'tab-hijack']);
}

$page_options2 = [
	'add' => $this->Html->link(__('Add %s', __('FOV Result')), ['action' => 'add']),
];

$th = [
	'FovResult.id' => ['content' => __('ID'), 'options' => ['sort' => 'FovResult.id']],
	'FovResult.Division' => ['content' => __('Division')],
	'FovResult.Branch' => ['content' => __('Branch')],
	'FovResult.fisma_system_id' => ['content' => __('FISMA System'), 'options' => ['editable' => ['type' => 'select', 'options' => $fismaSystems] ]],
	'FovResult.fisma_system.owner_contact_id' => array('content' => __('System Owner')),
	'FovResult.fisma_system.tech_poc_id' => array('content' => __('Tech POCs')),
	'FovResult.reports_organization_id' => ['content' => __('Organization'), 'options' => ['sort' => 'ReportsOrganization.name', 'editable' => ['type' => 'select', 'options' => $reportsOrganizations] ]],
	'FovResult.eol_software_id' => ['content' => __('Software/Vulnerability'), 'options' => ['sort' => 'EolSoftware.name', 'editable' => ['type' => 'select', 'options' => $eolSoftwares] ]],
	'FovResult.tickets' => ['content' => __('Tickets'), 'options' => ['sort' => 'FovResult.tickets', 'editable' => ['type' => 'text'] ]],
	'FovResult.waiver' => ['content' => __('Waivers'), 'options' => ['sort' => 'FovResult.waiver', 'editable' => ['type' => 'text'] ]],
	'FovResult.changerequest' => ['content' => __('CR IDs'), 'options' => ['sort' => 'FovResult.changerequest', 'editable' => ['type' => 'text'] ]],
	'FovResult.hostcount' => ['content' => __('# Hosts')],
	'FovResult.resolved_by_date' => ['content' => __('Must be Resolved By'), 'options' => ['sort' => 'FovResult.resolved_by_date', 'editable' => ['type' => 'date'] ]],
	'FovResult.reports_assignable_party_id' => ['content' => __('Assignable Party'), 'options' => ['sort' => 'ReportsAssignableParty.name', 'editable' => ['type' => 'select', 'options' => $reportsAssignableParties] ]],
	'FovResult.reports_remediation_id' => ['content' => __('Remediation'), 'options' => ['sort' => 'ReportsRemediation.name', 'editable' => ['type' => 'select', 'options' => $reportsRemediations] ]],
	'FovResult.reports_severity_id' => ['content' => __('Severity'), 'options' => ['sort' => 'ReportsSeverity.name', 'editable' => ['type' => 'select', 'options' => $reportsSeverities] ]],
	'FovResult.reports_status_id' => ['content' => __('Status'), 'options' => ['sort' => 'ReportsStatus.name', 'editable' => ['type' => 'select', 'options' => $reportsStatuses] ]],
	'FovResult.reports_verification_id' => ['content' => __('Verification'), 'options' => ['sort' => 'ReportsVerification.name', 'editable' => ['type' => 'select', 'options' => $reportsVerifications] ]],
	'FovResult.modified' => ['content' => __('Modified'), 'options' => ['sort' => 'FovResult.modified']],
	'FovResult.created' => ['content' => __('Created'), 'options' => ['sort' => 'FovResult.created']],
	'actions' => ['content' => __('Actions'), 'options' => ['class' => 'actions']],
	'multiselect' => true,
]; 

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = [];
foreach ($fovResults as $i => $fovResult)
{
	// fix for the crazy xref stuff
	if(isset($fovResult['FovResult']['ReportsOrganization']))
		$fovResult['ReportsOrganization'] = $fovResult['FovResult']['ReportsOrganization'];
	if(isset($fovResult['FovResult']['EolSoftware']))
		$fovResult['EolSoftware'] = $fovResult['FovResult']['EolSoftware'];
	if(isset($fovResult['FovResult']['ReportsRemediation']))
		$fovResult['ReportsRemediation'] = $fovResult['FovResult']['ReportsRemediation'];
	if(isset($fovResult['FovResult']['ReportsVerification']))
		$fovResult['ReportsVerification'] = $fovResult['FovResult']['ReportsVerification'];
	if(isset($fovResult['FovResult']['ReportsVerification']))
		$fovResult['ReportsVerification'] = $fovResult['FovResult']['ReportsVerification'];
	if(isset($fovResult['FovResult']['ReportsStatus']))
		$fovResult['ReportsStatus'] = $fovResult['FovResult']['ReportsStatus'];
	if(isset($fovResult['FovResult']['ReportsAssignableParty']))
		$fovResult['ReportsAssignableParty'] = $fovResult['FovResult']['ReportsAssignableParty'];
	
	$actions = [];
	$actions[] = $this->Html->link(__('View'), ['action' => 'view', $fovResult['FovResult']['id'], 'admin' => false]);
	if($this->Wrap->roleCheck(['admin', 'reviewer', 'saa']))
		$actions[] = $this->Html->link(__('Edit'), ['action' => 'edit', $fovResult['FovResult']['id'], 'admin' => false]);
	if($this->Wrap->roleCheck(['admin']))
		$actions[] = $this->Html->link(__('Delete'), ['action' => 'delete', $fovResult['FovResult']['id'], 'admin' => true], ['confirm' => __('Are you sure?')]);
	
	$actions = implode("", $actions);
	
	$edit_id = [
		'FovResult' => $fovResult['FovResult']['id'],
	];
	
	$fovResult = $this->ReportResults->addFismaSystemInfo($fovResult);
	
	$highlightDueDate = false;
	$statusStyle = false;
	if(isset($fovResult['ReportsStatus']['name']))
	{
		if($this->Common->slugify($fovResult['ReportsStatus']['name']) == 'open')
		{
			$resolvedByDate = strtotime($fovResult['FovResult']['resolved_by_date']);
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
		else
		{
			$statusStyle = 'background-color: '.$this->Common->makeRGBfromHex($fovResult['ReportsStatus']['color_code_hex'], '0.3').';';
		}
	}
	
	$counts = $this->ReportResults->ajaxCountsLinks($fovResult['FovResult'], 'fov_result');
	
	$td[$i] = [
		$this->Html->link($fovResult['FovResult']['id'], ['action' => 'view', $fovResult['FovResult']['id']]),
		$fovResult['division_links'],
		$fovResult['branch_links'],
		[$fovResult['fisma_system_links'], array('value' => (isset($fovResult['FovResult']['fisma_system_id'])?$fovResult['FovResult']['fisma_system_id']:''))],
		$fovResult['owner_links'],
		$fovResult['techs_links'],
		[(isset($fovResult['ReportsOrganization']['name'])?$fovResult['ReportsOrganization']['name']:'&nbsp;'), ['class' => 'nowrap', 'value' => (isset($fovResult['ReportsOrganization']['id'])?$fovResult['ReportsOrganization']['id']:'')]],
		[
			(isset($fovResult['EolSoftware']['name'])?$this->Html->link($fovResult['EolSoftware']['name'], ['controller' => 'eol_softwares', 'action' => 'view', $fovResult['EolSoftware']['id']]):''), 
			['class' => 'nowrap', 'value' => (isset($fovResult['EolSoftware']['id'])?$fovResult['EolSoftware']['id']:'')],
		],
		[$this->Local->ticketLinks($fovResult['FovResult']['tickets']), ['class' => 'nowrap']],
		[$this->Local->waiverLinks($fovResult['FovResult']['waiver']), ['class' => 'nowrap']],
		[$this->Local->crLinks($fovResult['FovResult']['changerequest']), ['class' => 'nowrap']],
		['.', [
			'ajax_count_url' => ['controller' => 'fov_hosts', 'action' => 'fov_result', $fovResult['FovResult']['id']],
			'url' => ['action' => 'view', $fovResult['FovResult']['id'], 'tab' => 'fov_hosts'],
		]],
		[
			$this->Wrap->niceDay($fovResult['FovResult']['resolved_by_date']),
			['value' => $fovResult['FovResult']['resolved_by_date'], 'class' => $highlightDueDate],
		],
		[
			(isset($fovResult['ReportsAssignableParty']['name'])?$fovResult['ReportsAssignableParty']['name']:'&nbsp;'),
			['class' => 'nowrap', 'value' => (isset($fovResult['ReportsAssignableParty']['id'])?$fovResult['ReportsAssignableParty']['id']:0)],
		],
		[
			(isset($fovResult['ReportsRemediation']['name'])?$fovResult['ReportsRemediation']['name']:'&nbsp;'),
			['class' => 'nowrap', 'value' => (isset($fovResult['ReportsRemediation']['id'])?$fovResult['ReportsRemediation']['id']:0)],
		],
		[
			(isset($fovResult['ReportsSeverity']['name'])?$fovResult['ReportsSeverity']['name']:'&nbsp;'), 
			['class' => 'nowrap', 'value' => (isset($fovResult['ReportsSeverity']['id'])?$fovResult['ReportsSeverity']['id']:0)],
		],
		[
			(isset($fovResult['ReportsStatus']['name'])?$fovResult['ReportsStatus']['name']:'&nbsp;'), 
			['class' => 'nowrap', 'value' => (isset($fovResult['ReportsStatus']['id'])?$fovResult['ReportsStatus']['id']:0), 'data-style' => $statusStyle],
		],
		[
			(isset($fovResult['ReportsVerification']['name'])?$fovResult['ReportsVerification']['name']:'&nbsp;'),
			['class' => 'nowrap', 'value' => (isset($fovResult['ReportsVerification']['id'])?$fovResult['ReportsVerification']['id']:0)],
		],
		[$this->Wrap->niceTime($fovResult['FovResult']['modified']), ['class' => 'nowrap']],
		[$this->Wrap->niceTime($fovResult['FovResult']['created']), ['class' => 'nowrap']],
		[
			$actions,
			['class' => 'actions'],
		],
		'multiselect' => $fovResult['FovResult']['id'],
		'edit_id' => $edit_id,
	];
}

$use_gridedit = false;
$use_griddelete = $user_gridadd = false;
if($this->Wrap->roleCheck(['admin', 'reviewer', 'saa']))
	$use_gridedit = true;
if($this->Wrap->roleCheck(['admin']))
	$use_griddelete = $user_gridadd = true;

foreach($multiselectOptions as $ms_key => $ms_name)
{
	$multiselectOptions[$ms_key] = __('Set all selected %s to one %s', __('FOV'), $ms_name);
}

echo $this->element('Utilities.page_index', [
	'page_title' => __('Focused Ops Vulnerabilities'),
	'page_subtitle' => (isset($page_subtitle)?$page_subtitle:false),
	'page_description' => $page_description,
	'page_options_title' => __('View By %s', __('Status')),
	'page_options' => $page_options,
	'page_options2' => $page_options2,
	'th' => $th,
	'td' => $td,
	'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.<br/>%s with a &dagger; next to them have been manually chosen', __('FISMA Systems')),
	'table_widget_options' => [
		'setup' => "
			self.element.find('td.highlight-red').parents('tr').addClass('highlight-red');
			self.element.find('td.highlight-yellow').parents('tr').addClass('highlight-yellow');
			self.element.find('td[data-style]').each(function(){ $(this).parents('tr').find('td').attr('style', $(this).data('style')) });
		"
	],
	// grid/inline edit options
	'use_gridedit' => $use_gridedit,
	//'use_gridadd' => $user_gridadd,
	'use_griddelete' => $use_griddelete,
	'use_multiselect' => true,
	'multiselect_options' => $multiselectOptions,
]);