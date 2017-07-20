<?php 
$page_options = array();
$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $us_result['UsResult']['id'], 'admin' => false));

$details_blocks = array();

$us_result = $this->ReportResults->addFismaSystemInfo($us_result);

$details_blocks[1][1] = array(
	'title' => __('Host Details'),
	'details' => array(
		array('name' => __('Organization'), 'value' => $us_result['ReportsOrganization']['name']),
		array('name' => __('Host Description'), 'value' => $us_result['UsResult']['host_description']),
		array('name' => __('IP Address'), 'value' => $us_result['UsResult']['ip_address']),
		array('name' => __('Hostname'), 'value' => $us_result['UsResult']['host_name']),
		array('name' => __('MAC Address'), 'value' => $us_result['UsResult']['mac_address']),
		array('name' => __('Asset Tag'), 'value' => $us_result['UsResult']['asset_tag']),
		array('name' => __('NetBIOS'), 'value' => $us_result['UsResult']['netbios']),
		array('name' => __('Divisions'), 'value' => $us_result['division_links']),
		array('name' => __('Branches'), 'value' => $us_result['branch_links']),
		array('name' => __('FISMA Systems'), 'value' => $us_result['fisma_system_links']),
		array('name' => __('FISMA Inventories'), 'value' => str_replace(',', '<br />', $us_result['fisma_inventory_links'])),
	)
);

$details_blocks[1][2] = array(
	'title' => __('Result Details'),
	'details' => array(
		array('name' => __('Software/Vulnerability'), 'value' => $this->Html->link($us_result['EolSoftware']['key_name'], array('controller' => 'eol_softwares', 'action' => 'view', $us_result['EolSoftware']['id']))),
		array('name' => __('Nessus'), 'value' => $this->Common->yesNo($us_result['UsResult']['nessus'])),
		array('name' => __('Hardware $'), 'value' => $this->Common->nicePrice($us_result['EolSoftware']['hw_price'])),
		array('name' => __('Software $'), 'value' => $this->Common->nicePrice($us_result['EolSoftware']['sw_price'])),
		array('name' => __('Tickets'), 'value' => $this->Local->ticketLinks($us_result['EolSoftware']['tickets'])),
		array('name' => __('Waivers'), 'value' => $this->Local->waiverLinks($us_result['EolSoftware']['waiver'])),
		array('name' => __('CR IDs'), 'value' => $this->Local->crLinks($us_result['EolSoftware']['changerequest'])),
		array('name' => __('Status'), 'value' => $us_result['ReportsStatus']['name']),
		array('name' => __('Assignable Party'), 'value' => (isset($us_result['EolSoftware']['ReportsAssignableParty']['name'])?$us_result['EolSoftware']['ReportsAssignableParty']['name']:false) ),
		array('name' => __('Remediation'), 'value' => (isset($us_result['EolSoftware']['ReportsRemediation']['name'])?$us_result['EolSoftware']['ReportsRemediation']['name']:false) ),
		array('name' => __('Verification'), 'value' => (isset($us_result['EolSoftware']['ReportsVerification']['name'])?$us_result['EolSoftware']['ReportsVerification']['name']:false) ),
	)
);


$remediated_by = false;
if(isset($us_result['EolSoftware']['ReportsVerificationUser']['name']))
	$remediated_by = $this->Html->link($us_result['EolSoftware']['ReportsVerificationUser']['name'], array('controller' => 'users', 'action' => 'view', $us_result['EolSoftware']['ReportsRemediationUser']['id']));

$verified_by = false;
if(isset($us_result['EolSoftware']['ReportsVerificationUser']['name']))
	$verified_by = $this->Html->link($us_result['EolSoftware']['ReportsVerificationUser']['name'], array('controller' => 'users', 'action' => 'view', $us_result['EolSoftware']['ReportsVerificationUser']['id']));
elseif($us_result['EolSoftware']['verified_by'])
	$verified_by = $us_result['EolSoftware']['verified_by'];

$status_changed_by = false;
if($us_result['UsResultStatusUser']['name'])
	$status_changed_by = $this->Html->link($us_result['UsResultStatusUser']['name'], array('controller' => 'users', 'action' => 'view', $us_result['UsResultStatusUser']['id']));


$details_blocks[1][3] = array(
	'title' => __('Milestones'),
	'details' => array(
		array('name' => __('Created By'), 'value' => $this->Html->link($us_result['UsResultAddedUser']['name'], array('controller' => 'users', 'action' => 'view', $us_result['UsResultAddedUser']['id']))),
		array('name' => __('Created Date'), 'value' => $this->Wrap->niceTime($us_result['UsResult']['created'])),
		array('name' => __('Modified By'), 'value' => $this->Html->link($us_result['UsResultModifiedUser']['name'], array('controller' => 'users', 'action' => 'view', $us_result['UsResultModifiedUser']['id']))),
		array('name' => __('Modified Date'), 'value' => $this->Wrap->niceTime($us_result['UsResult']['modified'])),
		array('name' => __('Must be Resolved By'), 'value' => $this->Wrap->niceDay($us_result['EolSoftware']['resolved_by_date'])),
		array('name' => __('Action Taken'), 'value' => $us_result['EolSoftware']['action_taken']),
		array('name' => __('Action Date'), 'value' => $this->Wrap->niceTime($us_result['EolSoftware']['action_date'])),
		array('name' => __('Status Changed By'), 'value' => $status_changed_by),
		array('name' => __('Status Date'), 'value' => $this->Wrap->niceDay($us_result['UsResult']['status_date'])),
		array('name' => __('Remediated By'), 'value' => $remediated_by),
		array('name' => __('Remediated Date'), 'value' => $this->Wrap->niceDay($us_result['EolSoftware']['remediation_date'])),
		array('name' => __('Verified By'), 'value' => $verified_by),
		array('name' => __('Verified Date'), 'value' => $this->Wrap->niceDay($us_result['EolSoftware']['verification_date'])),
	)
);

$stats = array();
$tabs = array();

$tabs['description'] = array(
	'id' => 'description',
	'name' => __('Detailed Description'),
	'content' => $this->Wrap->descView($us_result['UsResult']['description']),
);
$tabs['action_recommended'] = array(
	'id' => 'action_recommended',
	'name' => __('Recommended Action'),
	'content' => $this->Wrap->descView($us_result['EolSoftware']['action_recommended']),
);
$tabs['comments'] = array(
	'id' => 'comments',
	'name' => __('Comments'),
	'content' => $this->Wrap->descView("(Please explain why it's False positive, Acceptable Risk or Action(s) taken)\n\n". $us_result['UsResult']['comments']),
);
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($us_result['UsResult']['notes']),
);
$tabs['reports'] = $stats['reports'] = array(
	'id' => 'reports',
	'name' => __('US Reports'), 
	'ajax_url' => array('controller' => 'us_reports', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);
$tabs['fov_results'] = $stats['fov_results'] = array(
	'id' => 'fov_results',
	'name' => __('FOV Results'), 
	'ajax_url' => array('controller' => 'fov_results', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);
$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);
$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);
$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);
if($this->Common->roleCheck(array('admin')) and $this->Common->isAdmin())
{
	$tabs['subnets'] = $stats['subnets'] = array(
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => array('controller' => 'subnet_members', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => true),
	);
}
else
{
	$tabs['subnets'] = $stats['subnets'] = array(
		'id' => 'subnets',
		'name' => __('Subnets'), 
		'ajax_url' => array('controller' => 'subnet_members', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
	);
}
$tabs['change_log'] = $stats['change_log'] = array(
	'id' => 'change_log',
	'name' => __('Change Logs'), 
	'ajax_url' => array('controller' => 'us_result_logs', 'action' => 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'us_result', $us_result['UsResult']['id'], 'admin' => false),
);

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('%s: #%s', __('US Result'), $us_result['UsResult']['id']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details_blocks' => $details_blocks,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));