<?php 
$page_options = array();
$page_options[] = $this->Html->link(__('Edit'), ['action' => 'edit', $fovResult['FovResult']['id'], 'admin' => false]);

$details_blocks = array();

$fovResult = $this->ReportResults->addFismaSystemInfo($fovResult);

$details_blocks[1][1] = [
	'title' => __('Host Details'),
	'details' => [
		['name' => __('Organization'), 'value' => $fovResult['ReportsOrganization']['name']],
		['name' => __('Divisions'), 'value' => $fovResult['division_links']],
		['name' => __('Branches'), 'value' => $fovResult['branch_links']],
		['name' => __('FISMA Systems'), 'value' => $fovResult['fisma_system_links']],
		['name' => __('FISMA Inventories'), 'value' => str_replace(',', '<br />', $fovResult['fisma_inventory_links'])],
	]
];

$details_blocks[1][2] = [
	'title' => __('Result Details'),
	'details' => [
		['name' => __('Software/Vulnerability'), 'value' => $this->Html->link($fovResult['EolSoftware']['name'], ['controller' => 'eol_softwares', 'action' => 'view', $fovResult['EolSoftware']['id']])],
		['name' => __('Tickets'), 'value' => $this->Local->ticketLinks($fovResult['FovResult']['tickets'])],
		['name' => __('Waivers'), 'value' => $this->Local->waiverLinks($fovResult['FovResult']['waiver'])],
		['name' => __('CR IDs'), 'value' => $this->Local->crLinks($fovResult['FovResult']['changerequest'])],
		['name' => __('Assignable Party'), 'value' => $fovResult['ReportsAssignableParty']['name']],
		['name' => __('Remediation'), 'value' => $fovResult['ReportsRemediation']['name']],
		['name' => __('Severity'), 'value' => $fovResult['ReportsSeverity']['name']],
		['name' => __('Status'), 'value' => $fovResult['ReportsStatus']['name']],
		['name' => __('Verification'), 'value' => $fovResult['ReportsVerification']['name']],
	]
];


$remediated_by = false;
if($fovResult['FovResultRemediationUser']['name'])
	$remediated_by = $this->Html->link($fovResult['FovResultRemediationUser']['name'], ['controller' => 'users', 'action' => 'view', $fovResult['FovResultRemediationUser']['id']]);

$verified_by = false;
if($fovResult['FovResultVerificationUser']['name'])
	$verified_by = $this->Html->link($fovResult['FovResultVerificationUser']['name'], ['controller' => 'users', 'action' => 'view', $fovResult['FovResultVerificationUser']['id']]);

$status_changed_by = false;
if($fovResult['FovResultStatusUser']['name'])
	$status_changed_by = $this->Html->link($fovResult['FovResultStatusUser']['name'], ['controller' => 'users', 'action' => 'view', $fovResult['FovResultStatusUser']['id']]);

$details_blocks[1][3] = [
	'title' => __('Milestones'),
	'details' => [
		['name' => __('Created By'), 'value' => $this->Html->link($fovResult['FovResultAddedUser']['name'], ['controller' => 'users', 'action' => 'view', $fovResult['FovResultAddedUser']['id']])],
		['name' => __('Created Date'), 'value' => $this->Wrap->niceTime($fovResult['FovResult']['created'])],
		['name' => __('Modified By'), 'value' => $this->Html->link($fovResult['FovResultModifiedUser']['name'], ['controller' => 'users', 'action' => 'view', $fovResult['FovResultModifiedUser']['id']])],
		['name' => __('Modified Date'), 'value' => $this->Wrap->niceTime($fovResult['FovResult']['modified'])],
		['name' => __('Must be Resolved By'), 'value' => $this->Wrap->niceDay($fovResult['FovResult']['resolved_by_date'])],
		['name' => __('Status Changed By'), 'value' => $status_changed_by],
		['name' => __('Status Date'), 'value' => $this->Wrap->niceDay($fovResult['FovResult']['status_date'])],
		['name' => __('Remediated By'), 'value' => $remediated_by],
		['name' => __('Remediated Date'), 'value' => $this->Wrap->niceDay($fovResult['FovResult']['remediation_date'])],
		['name' => __('Verified By'), 'value' => $verified_by],
		['name' => __('Verified Date'), 'value' => $this->Wrap->niceDay($fovResult['FovResult']['verification_date'])],
	]
];

$stats = [];
$tabs = [];

$tabs['notes'] = [
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($fovResult['FovResult']['notes']),
];
$tabs['comments'] = [
	'id' => 'comments',
	'name' => __('Comments'),
	'content' => $this->Wrap->descView($fovResult['FovResult']['comments']),
];
$tabs['fov_hosts'] = $stats['fov_hosts'] = [
	'id' => 'fov_hosts',
	'name' => __('FOV Hosts'), 
	'ajax_url' => ['controller' => 'fov_hosts', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => false],
];
$tabs['fov_results'] = $stats['fov_results'] = [
	'id' => 'fov_results',
	'name' => __('FOV Results'), 
	'ajax_url' => ['controller' => 'fov_results', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => false],
];
$tabs['us_results'] = $stats['us_results'] = [
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => ['controller' => 'us_results', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => false],
];
$tabs['eol_results'] = $stats['eol_results'] = [
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => ['controller' => 'eol_results', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => false],
];
$tabs['pen_test_results'] = $stats['pen_test_results'] = [
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => ['controller' => 'pen_test_results', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => false],
];
$tabs['high_risk_results'] = $stats['high_risk_results'] = [
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => ['controller' => 'high_risk_results', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => false],
];
if($this->Common->roleCheck(['admin']) and $this->Common->isAdmin())
{
	$tabs['subnets'] = $stats['subnets'] = [
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => ['controller' => 'subnet_members', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => true],
	];
}
else
{
	$tabs['subnets'] = $stats['subnets'] = [
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => ['controller' => 'subnet_members', 'action' => 'fov_result', $fovResult['FovResult']['id'], 'admin' => false],
	];
}
$tabs['tags'] = $stats['tags'] = [
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => ['plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'eol_result', $fovResult['FovResult']['id'], 'admin' => false],
];

echo $this->element('Utilities.page_view_columns', [
	'page_title' => __('%s: #%s', __('Focused Ops Vulnerability'), $fovResult['FovResult']['id']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details_blocks' => $details_blocks,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
]);