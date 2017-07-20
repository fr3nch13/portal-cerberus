<?php 
// File: app/View/UsResults/index.ctp

$page_options = array(
);

// content
$th = array(
	'UsResultLog.reports_organization_id' => array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name' )),
	'UsResultLog.host_description' => array('content' => __('Host Description'), 'options' => array('sort' => 'UsResultLog.host_description')),
	'UsResultLog.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'UsResultLog.ip_address')),
	'UsResultLog.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'UsResultLog.host_name')),
	'UsResultLog.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'UsResultLog.mac_address')),
	'UsResultLog.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'UsResultLog.netbios')),
	'UsResultLog.eol_software_id' => array('content' => __('EOL/US Software'), 'options' => array('sort' => 'EolSoftware.name')),
	'UsResultLog.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'UsResultLog.tickets')),
	'UsResultLog.reports_severity_id' => array('content' => __('Severity'), 'options' => array('sort' => 'UsResultLog.reports_severity_id')),
	'UsResultLog.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'UsResultLog.reports_remediation_id')),
	'UsResultLog.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'UsResultLog.reports_verification_id')),
	'UsResultLog.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'UsResultLog.reports_status_id')),
	'UsResultLog.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'UsResultLog.reports_assignable_party_id')),
	'UsResultLog.modified_user_id' => array('content' => __('Change Done By'), 'options' => array('sort' => 'UsResultLog.modified_user_id')),
	'UsResultLog.created' => array('content' => __('Change Done On'), 'options' => array('sort' => 'UsResultLog.created')),
); 

$td = array();
foreach ($us_result_logs as $i => $us_result_log)
{
	$action_date = false;
	if(isset($us_result_log['UsResultLog']['action_date']))
		$action_date = $this->Wrap->niceTime($us_result_log['UsResultLog']['action_date']);	
	
	$td[$i] = array(
		array((isset($us_result_log['ReportsOrganization']['name'])?$us_result_log['ReportsOrganization']['name']:'&nbsp;'), array('class' => 'nowrap')),
		$us_result_log['UsResultLog']['host_description'],
		$us_result_log['UsResultLog']['ip_address'],
		$us_result_log['UsResultLog']['host_name'],
		array($us_result_log['UsResultLog']['mac_address'], array('class' => 'nowrap')),
		array($us_result_log['UsResultLog']['netbios'], array('class' => 'nowrap')),
		array((isset($us_result_log['EolSoftware']['name'])?$us_result_log['EolSoftware']['name']:''), array('class' => 'nowrap')),
		array($us_result_log['UsResultLog']['tickets'], array('class' => 'nowrap')),
		array((isset($us_result_log['ReportsSeverity']['name'])?$us_result_log['ReportsSeverity']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($us_result_log['ReportsRemediation']['name'])?$us_result_log['ReportsRemediation']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($us_result_log['ReportsVerification']['name'])?$us_result_log['ReportsVerification']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($us_result_log['ReportsStatus']['name'])?$us_result_log['ReportsStatus']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($us_result_log['ReportsAssignableParty']['name'])?$us_result_log['ReportsAssignableParty']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($us_result_log['UsResultModifiedUser']['name'])?$us_result_log['UsResultModifiedUser']['name']:'&nbsp;'), array('class' => 'nowrap')),
		$this->Wrap->niceTime($us_result_log['UsResultLog']['created']),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('US Results'),
	'th' => $th,
	'td' => $td,
));