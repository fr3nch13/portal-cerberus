<?php 
// File: app/View/EolResults/index.ctp

$page_options = array(
);

// content
$th = array(
	'EolResultLog.ticket_id' => array('content' => __('Ticket ID'), 'options' => array('sort' => 'EolResultLog.ticket_id' )),
	'EolResultLog.reports_organization_id' => array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name' )),
	'EolResultLog.host_description' => array('content' => __('Host Description'), 'options' => array('sort' => 'EolResultLog.host_description')),
	'EolResultLog.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'EolResultLog.ip_address')),
	'EolResultLog.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'EolResultLog.host_name')),
	'EolResultLog.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'EolResultLog.mac_address')),
	'EolResultLog.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'EolResultLog.netbios')),
	'EolResultLog.eol_software_id' => array('content' => __('Software'), 'options' => array('sort' => 'EolSoftware.name')),
	'EolResultLog.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'EolResultLog.tickets')),
	'EolResultLog.reports_severity_id' => array('content' => __('Severity'), 'options' => array('sort' => 'EolResultLog.reports_severity_id')),
	'EolResultLog.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'EolResultLog.reports_remediation_id')),
	'EolResultLog.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'EolResultLog.reports_verification_id')),
	'EolResultLog.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'EolResultLog.reports_status_id')),
	'EolResultLog.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'EolResultLog.reports_assignable_party_id')),
	'EolResultLog.modified_user_id' => array('content' => __('Change Done By'), 'options' => array('sort' => 'EolResultLog.modified_user_id')),
	'EolResultLog.created' => array('content' => __('Change Done On'), 'options' => array('sort' => 'EolResultLog.created')),
); 

$td = array();
foreach ($eol_result_logs as $i => $eol_result_log)
{	
	$action_date = $this->Wrap->niceTime($eol_result_log['EolResultLog']['action_date']);	
	
	$td[$i] = array(
		$eol_result_log['EolResultLog']['ticket_id'],
		array((isset($eol_result_log['ReportsOrganization']['name'])?$eol_result_log['ReportsOrganization']['name']:'&nbsp;'), array('class' => 'nowrap')),
		$eol_result_log['EolResultLog']['host_description'],
		$eol_result_log['EolResultLog']['ip_address'],
		$eol_result_log['EolResultLog']['host_name'],
		array($eol_result_log['EolResultLog']['mac_address'], array('class' => 'nowrap')),
		array($eol_result_log['EolResultLog']['netbios'], array('class' => 'nowrap')),
		array((isset($eol_result_log['EolSoftware']['name'])?$eol_result_log['EolSoftware']['name']:''), array('class' => 'nowrap')),
		array($eol_result_log['EolResultLog']['tickets'], array('class' => 'nowrap')),
		array((isset($eol_result_log['ReportsSeverity']['name'])?$eol_result_log['ReportsSeverity']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($eol_result_log['ReportsRemediation']['name'])?$eol_result_log['ReportsRemediation']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($eol_result_log['ReportsVerification']['name'])?$eol_result_log['ReportsVerification']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($eol_result_log['ReportsStatus']['name'])?$eol_result_log['ReportsStatus']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($eol_result_log['ReportsAssignableParty']['name'])?$eol_result_log['ReportsAssignableParty']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($eol_result_log['EolResultModifiedUser']['name'])?$eol_result_log['EolResultModifiedUser']['name']:'&nbsp;'), array('class' => 'nowrap')),
		$this->Wrap->niceTime($eol_result_log['EolResultLog']['created']),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('EOL Results'),
	'th' => $th,
	'td' => $td,
));