<?php 
$page_options = array();
$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $eol_result['EolResult']['id'], 'admin' => false));

$details_blocks = array();

$eol_result = $this->ReportResults->addFismaSystemInfo($eol_result);

$details_blocks[1][1] = array(
	'title' => __('Host Details'),
	'details' => array(
		array('name' => __('Organization'), 'value' => $eol_result['ReportsOrganization']['name']),
		array('name' => __('Host Description'), 'value' => $eol_result['EolResult']['host_description']),
		array('name' => __('IP Address'), 'value' => $eol_result['EolResult']['ip_address']),
		array('name' => __('Hostname'), 'value' => $eol_result['EolResult']['host_name']),
		array('name' => __('MAC Address'), 'value' => $eol_result['EolResult']['mac_address']),
		array('name' => __('Asset Tag'), 'value' => $eol_result['EolResult']['asset_tag']),
		array('name' => __('NetBIOS'), 'value' => $eol_result['EolResult']['netbios']),
		array('name' => __('Divisions'), 'value' => $eol_result['division_links']),
		array('name' => __('Branches'), 'value' => $eol_result['branch_links']),
		array('name' => __('FISMA Systems'), 'value' => $eol_result['fisma_system_links']),
		array('name' => __('FISMA Inventories'), 'value' => str_replace(',', '<br />', $eol_result['fisma_inventory_links'])),
	)
);

$details_blocks[1][2] = array(
	'title' => __('Result Details'),
	'details' => array(
		array('name' => __('Ticket ID'), 'value' => $eol_result['EolResult']['ticket_id']),
		array('name' => __('Software/Vulnerability'), 'value' => $this->Html->link($eol_result['EolSoftware']['name'], array('controller' => 'eol_softwares', 'action' => 'view', $eol_result['EolSoftware']['id']))),
		array('name' => __('Nessus'), 'value' => $this->Common->yesNo($eol_result['EolResult']['nessus'])),
		array('name' => __('Hardware $'), 'value' => $this->Common->nicePrice($eol_result['EolResult']['hw_price'])),
		array('name' => __('Software $'), 'value' => $this->Common->nicePrice($eol_result['EolResult']['sw_price'])),
		array('name' => __('Tickets'), 'value' => $this->Local->ticketLinks($eol_result['EolResult']['tickets'])),
		array('name' => __('Waivers'), 'value' => $this->Local->waiverLinks($eol_result['EolResult']['waiver'])),
		array('name' => __('CR IDs'), 'value' => $this->Local->crLinks($eol_result['EolResult']['changerequest'])),
		array('name' => __('Status'), 'value' => $eol_result['ReportsStatus']['name']),
		array('name' => __('Remediation'), 'value' => $eol_result['ReportsRemediation']['name']),
		array('name' => __('Verification'), 'value' => $eol_result['ReportsVerification']['name']),
		array('name' => __('Assignable Party'), 'value' => $eol_result['ReportsAssignableParty']['name']),
	)
);


$remediated_by = false;
if($eol_result['EolResultRemediationUser']['name'])
	$remediated_by = $this->Html->link($eol_result['EolResultRemediationUser']['name'], array('controller' => 'users', 'action' => 'view', $eol_result['EolResultRemediationUser']['id']));

$verified_by = false;
if($eol_result['EolResultVerificationUser']['name'])
	$verified_by = $this->Html->link($eol_result['EolResultVerificationUser']['name'], array('controller' => 'users', 'action' => 'view', $eol_result['EolResultVerificationUser']['id']));
elseif($eol_result['EolResult']['verified_by'])
	$verified_by = $eol_result['EolResult']['verified_by'];

$status_changed_by = false;
if($eol_result['EolResultStatusUser']['name'])
	$status_changed_by = $this->Html->link($eol_result['EolResultStatusUser']['name'], array('controller' => 'users', 'action' => 'view', $eol_result['EolResultStatusUser']['id']));


$details_blocks[1][3] = array(
	'title' => __('Milestones'),
	'details' => array(
		array('name' => __('Created By'), 'value' => $this->Html->link($eol_result['EolResultAddedUser']['name'], array('controller' => 'users', 'action' => 'view', $eol_result['EolResultAddedUser']['id']))),
		array('name' => __('Created Date'), 'value' => $this->Wrap->niceTime($eol_result['EolResult']['created'])),
		array('name' => __('Modified By'), 'value' => $this->Html->link($eol_result['EolResultModifiedUser']['name'], array('controller' => 'users', 'action' => 'view', $eol_result['EolResultModifiedUser']['id']))),
		array('name' => __('Modified Date'), 'value' => $this->Wrap->niceTime($eol_result['EolResult']['modified'])),
		array('name' => __('Must be Resolved By'), 'value' => $this->Wrap->niceDay($eol_result['EolResult']['resolved_by_date'])),
		array('name' => __('Action Taken'), 'value' => $eol_result['EolResult']['action_taken']),
		array('name' => __('Action Date'), 'value' => $this->Wrap->niceTime($eol_result['EolResult']['action_date'])),
		array('name' => __('Status Changed By'), 'value' => $status_changed_by),
		array('name' => __('Status Date'), 'value' => $this->Wrap->niceDay($eol_result['EolResult']['status_date'])),
		array('name' => __('Remediated By'), 'value' => $remediated_by),
		array('name' => __('Remediated Date'), 'value' => $this->Wrap->niceDay($eol_result['EolResult']['remediation_date'])),
		array('name' => __('Verified By'), 'value' => $verified_by),
		array('name' => __('Verified Date'), 'value' => $this->Wrap->niceDay($eol_result['EolResult']['verification_date'])),
	)
);

$stats = array();
$tabs = array();

$tabs['description'] = array(
	'id' => 'description',
	'name' => __('Detailed Description'),
	'content' => $this->Wrap->descView($eol_result['EolResult']['description']),
);
$tabs['action_recommended'] = array(
	'id' => 'action_recommended',
	'name' => __('Recommended Action'),
	'content' => $this->Wrap->descView($eol_result['EolResult']['action_recommended']),
);
$tabs['comments'] = array(
	'id' => 'comments',
	'name' => __('Comments'),
	'content' => $this->Wrap->descView("(Please explain why it's False positive, Acceptable Risk or Action(s) taken)\n\n". $eol_result['EolResult']['comments']),
);
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($eol_result['EolResult']['notes']),
);
$tabs['eol_reports'] = $stats['eol_reports'] = array(
	'id' => 'eol_reports',
	'name' => __('EOL Reports'), 
	'ajax_url' => array('controller' => 'eol_reports', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);
$tabs['fov_results'] = $stats['fov_results'] = array(
	'id' => 'fov_results',
	'name' => __('FOV Results'), 
	'ajax_url' => array('controller' => 'fov_results', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);
$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);
$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);
$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);
if($this->Common->roleCheck(array('admin')) and $this->Common->isAdmin())
{
	$tabs['subnets'] = $stats['subnets'] = array(
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => array('controller' => 'subnet_members', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => true),
	);
}
else
{
	$tabs['subnets'] = $stats['subnets'] = array(
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => array('controller' => 'subnet_members', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
	);
}
$tabs['change_log'] = $stats['change_log'] = array(
	'id' => 'change_log',
	'name' => __('Change Logs'), 
	'ajax_url' => array('controller' => 'eol_result_logs', 'action' => 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'eol_result', $eol_result['EolResult']['id'], 'admin' => false),
);

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('%s: #%s', __('EOL Result'), $eol_result['EolResult']['id']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details_blocks' => $details_blocks,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));