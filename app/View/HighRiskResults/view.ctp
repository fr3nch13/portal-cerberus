<?php 
$page_options = array();
$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $high_risk_result['HighRiskResult']['id'], 'admin' => false));

$details_blocks = array();

$high_risk_result = $this->ReportResults->addFismaSystemInfo($high_risk_result);

$details_blocks[1][1] = array(
	'title' => __('Host Details'),
	'details' => array(
		array('name' => __('System Type'), 'value' => $high_risk_result['ReportsSystemType']['name']),
		array('name' => __('IP Address'), 'value' => $high_risk_result['HighRiskResult']['ip_address']),
		array('name' => __('Host Name'), 'value' => $high_risk_result['HighRiskResult']['host_name']),
		array('name' => __('MAC Address'), 'value' => $high_risk_result['HighRiskResult']['mac_address']),
		array('name' => __('Asset Tag'), 'value' => $high_risk_result['HighRiskResult']['asset_tag']),
		array('name' => __('Port'), 'value' => $high_risk_result['HighRiskResult']['port']),
		array('name' => __('Divisions'), 'value' => $high_risk_result['division_links']),
		array('name' => __('Branches'), 'value' => $high_risk_result['branch_links']),
		array('name' => __('FISMA Systems'), 'value' => $high_risk_result['fisma_system_links']),
		array('name' => __('FISMA Inventories'), 'value' => str_replace(',', '<br />', $high_risk_result['fisma_inventory_links'])),
	)
);

$details_blocks[1][2] = array(
	'title' => __('Result Details'),
	'details' => array(
		array('name' => __('Ticket ID'), 'value' => $high_risk_result['HighRiskResult']['ticket_id']),
		array('name' => __('Software/Vulnerability'), 'value' => $high_risk_result['EolSoftware']['name']),
		array('name' => __('DHS'), 'value' => $high_risk_result['HighRiskResult']['dhs']),
		array('name' => __('Ticket'), 'value' => $this->Local->ticketLinks($high_risk_result['HighRiskResult']['ticket'])),
		array('name' => __('Waivers'), 'value' => $this->Local->waiverLinks($high_risk_result['HighRiskResult']['waiver'])),
		array('name' => __('CR IDs'), 'value' => $this->Local->crLinks($high_risk_result['HighRiskResult']['changerequest'])),
		array('name' => __('Status'), 'value' => $high_risk_result['ReportsStatus']['name']),
		array('name' => __('Remediation'), 'value' => $high_risk_result['ReportsRemediation']['name']),
		array('name' => __('Verification'), 'value' => $high_risk_result['ReportsVerification']['name']),
		array('name' => __('Assignable Party'), 'value' => $high_risk_result['ReportsAssignableParty']['name']),
	)
);

$status_changed_by = false;
if($high_risk_result['HighRiskResultStatusUser']['name'])
	$status_changed_by = $this->Html->link($high_risk_result['HighRiskResultStatusUser']['name'], array('controller' => 'users', 'action' => 'view', $high_risk_result['HighRiskResultStatusUser']['id']));

$remediated_by = false;
if($high_risk_result['HighRiskResultRemediationUser']['name'])
	$remediated_by = $this->Html->link($high_risk_result['HighRiskResultRemediationUser']['name'], array('controller' => 'users', 'action' => 'view', $high_risk_result['HighRiskResultRemediationUser']['id']));

/*
$verified_by = false;
if($high_risk_result['HighRiskResultVerificationUser']['name'])
	$verified_by = $this->Html->link($high_risk_result['HighRiskResultVerificationUser']['name'], array('controller' => 'users', 'action' => 'view', $high_risk_result['HighRiskResultVerificationUser']['id']));
elseif($high_risk_result['HighRiskResult']['verified_by'])
	$verified_by = $high_risk_result['HighRiskResult']['verified_by'];
*/

$details_blocks[1][3] = array(
	'title' => __('Milestones'),
	'details' => array(
		array('name' => __('Created By'), 'value' => $this->Html->link($high_risk_result['HighRiskResultAddedUser']['name'], array('controller' => 'users', 'action' => 'view', $high_risk_result['HighRiskResultAddedUser']['id']))),
		array('name' => __('Created Date'), 'value' => $this->Wrap->niceTime($high_risk_result['HighRiskResult']['created'])),
		array('name' => __('Modified By'), 'value' => $this->Html->link($high_risk_result['HighRiskResultModifiedUser']['name'], array('controller' => 'users', 'action' => 'view', $high_risk_result['HighRiskResultModifiedUser']['id']))),
		array('name' => __('Modified Date'), 'value' => $this->Wrap->niceTime($high_risk_result['HighRiskResult']['modified'])),
		array('name' => __('Reported to ORG/IC'), 'value' => $this->Wrap->niceDay($high_risk_result['HighRiskResult']['reported_to_ic_date'])),
		array('name' => __('Must be Resolved By'), 'value' => $this->Wrap->niceDay($high_risk_result['HighRiskResult']['resolved_by_date'])),
		array('name' => __('Est. Remediation Date'), 'value' => $this->Wrap->niceDay($high_risk_result['HighRiskResult']['estimated_remediation_date'])),
		
		array('name' => __('Status Changed By'), 'value' => $status_changed_by),
		array('name' => __('Status Date'), 'value' => $this->Wrap->niceDay($high_risk_result['HighRiskResult']['status_date'])),
		array('name' => __('Remediated By'), 'value' => $remediated_by),
		array('name' => __('Remediated Date'), 'value' => $this->Wrap->niceDay($high_risk_result['HighRiskResult']['remediation_date'])),
//		array('name' => __('Verified By'), 'value' => $verified_by),
		array('name' => __('Verified Date'), 'value' => $this->Wrap->niceDay($high_risk_result['HighRiskResult']['verification_date'])),
	)
);

$stats = array();
$tabs = array();

$tabs['comments'] = array(
	'id' => 'comments',
	'name' => __('Comments'),
	'content' => $this->Wrap->descView($high_risk_result['HighRiskResult']['comments']),
);
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($high_risk_result['HighRiskResult']['notes']),
);
$tabs['high_risk_reports'] = $stats['high_risk_reports'] = array(
	'id' => 'high_risk_reports',
	'name' => __('High Risk Reports'), 
	'ajax_url' => array('controller' => 'high_risk_reports', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);
$tabs['fov_results'] = $stats['fov_results'] = array(
	'id' => 'fov_results',
	'name' => __('FOV Results'), 
	'ajax_url' => array('controller' => 'fov_results', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);
$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);
$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);
$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);

if($this->Common->roleCheck(array('admin')) and $this->Common->isAdmin())
{
	$tabs['subnets'] = $stats['subnets'] = array(
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => array('controller' => 'subnet_members', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => true),
	);
}
else
{
	$tabs['subnets'] = $stats['subnets'] = array(
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => array('controller' => 'subnet_members', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
	);
}
$tabs['change_log'] = $stats['change_log'] = array(
	'id' => 'change_log',
	'name' => __('Change Logs'), 
	'ajax_url' => array('controller' => 'high_risk_result_logs', 'action' => 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'high_risk_result', $high_risk_result['HighRiskResult']['id'], 'admin' => false),
);

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('%s: #%s', __('High Risk Result'), $high_risk_result['HighRiskResult']['id']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details_blocks' => $details_blocks,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));