<?php 
// File: app/View/HighRiskResultLogs/index.ctp

$page_options = array(
);

// content
$th = array(
	'HighRiskResultLog.ticket_id' => array('content' => __('Ticket ID'), 'options' => array('sort' => 'HighRiskResultLog.ticket_id' )),
	'HighRiskResultLog.reports_system_type_id' => array('content' => __('System Type'), 'options' => array('sort' => 'HighRiskResultLog.reports_system_type_id', 'editable' => array('type' => 'select', 'options' => $reportsSystemTypes) )),
	'HighRiskResultLog.vulnerability' => array('content' => __('Vulnerability'), 'options' => array('sort' => 'HighRiskResultLog.vulnerability', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'HighRiskResultLog.ip_address', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.host_name' => array('content' => __('Host Name'), 'options' => array('sort' => 'HighRiskResultLog.host_name', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.mac_address' => array('content' => __('MAC Address'), 'options' => array('sort' => 'HighRiskResultLog.mac_address', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'HighRiskResultLog.asset_tag', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.port' => array('content' => __('Port'), 'options' => array('sort' => 'HighRiskResultLog.port', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.dhs' => array('content' => __('DHS'), 'options' => array('sort' => 'HighRiskResultLog.dhs', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.reported_to_ic_date' => array('content' => __('Reported to ORG/IC'), 'options' => array('sort' => 'HighRiskResultLog.reported_to_ic_date', 'editable' => array('type' => 'date') )),
	'HighRiskResultLog.resolved_by_date' => array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'HighRiskResultLog.resolved_by_date', 'editable' => array('type' => 'date') )),
	'HighRiskResultLog.estimated_remediation_date' => array('content' => __('Est. Remediation Date'), 'options' => array('sort' => 'HighRiskResultLog.estimated_remediation_date', 'editable' => array('type' => 'date') )),
	'HighRiskResultLog.ticket' => array('content' => __('Ticket'), 'options' => array('sort' => 'HighRiskResultLog.ticket', 'editable' => array('type' => 'text'))),
	'HighRiskResultLog.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'HighRiskResultLog.reports_assignable_party_id', 'editable' => array('type' => 'select', 'options' => $reportsAssignableParties) )),
	'HighRiskResultLog.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'HighRiskResultLog.reports_remediation_id', 'editable' => array('type' => 'select', 'options' => $reportsRemediations) )),
	'HighRiskResultLog.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'HighRiskResultLog.reports_verification_id', 'editable' => array('type' => 'select', 'options' => $reportsVerifications) )),
	'HighRiskResultLog.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'HighRiskResultLog.reports_status_id', 'editable' => array('type' => 'select', 'options' => $reportsStatuses) )),
	'HighRiskResultLog.modified_user_id' => array('content' => __('Change Done By'), 'options' => array('sort' => 'HighRiskResultLog.modified_user_id')),
	'HighRiskResultLog.created' => array('content' => __('Change Done On'), 'options' => array('sort' => 'HighRiskResultLog.created')),
); 

$td = array();
foreach ($high_risk_result_logs as $i => $high_risk_result_log)
{
	// fix for the crazy xref stuff
	if(isset($high_risk_result_log['HighRiskResultLog']['ReportsSystemType']))
		$high_risk_result_log['ReportsSystemType'] = $high_risk_result_log['HighRiskResultLog']['ReportsSystemType'];
	if(isset($high_risk_result_log['HighRiskResultLog']['ReportsAssignableParty']))
		$high_risk_result_log['ReportsAssignableParty'] = $high_risk_result_log['HighRiskResultLog']['ReportsAssignableParty'];
	if(isset($high_risk_result_log['HighRiskResultLog']['ReportsRemediation']))
		$high_risk_result_log['ReportsRemediation'] = $high_risk_result_log['HighRiskResultLog']['ReportsRemediation'];
	if(isset($high_risk_result_log['HighRiskResultLog']['ReportsVerification']))
		$high_risk_result_log['ReportsVerification'] = $high_risk_result_log['HighRiskResultLog']['ReportsVerification'];
	if(isset($high_risk_result_log['HighRiskResultLog']['ReportsStatus']))
		$high_risk_result_log['ReportsStatus'] = $high_risk_result_log['HighRiskResultLog']['ReportsStatus'];
	
	
	$td[$i] = array(
		$high_risk_result_log['HighRiskResultLog']['ticket_id'],
		array(
			(isset($high_risk_result_log['ReportsSystemType']['name'])?$high_risk_result_log['ReportsSystemType']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result_log['ReportsSystemType']['id'])?$high_risk_result_log['ReportsSystemType']['id']:0)),
		),
		$high_risk_result_log['HighRiskResultLog']['vulnerability'],
		$high_risk_result_log['HighRiskResultLog']['ip_address'],
		$high_risk_result_log['HighRiskResultLog']['host_name'],
		$high_risk_result_log['HighRiskResultLog']['mac_address'],
		$high_risk_result_log['HighRiskResultLog']['asset_tag'],
		$high_risk_result_log['HighRiskResultLog']['port'],
		$high_risk_result_log['HighRiskResultLog']['dhs'],
		array(
			$this->Wrap->niceTime($high_risk_result_log['HighRiskResultLog']['reported_to_ic_date']),
			array('value' => $high_risk_result_log['HighRiskResultLog']['reported_to_ic_date']),
		),
		array(
			$this->Wrap->niceTime($high_risk_result_log['HighRiskResultLog']['resolved_by_date']),
			array('value' => $high_risk_result_log['HighRiskResultLog']['resolved_by_date']),
		),
		array(
			$this->Wrap->niceTime($high_risk_result_log['HighRiskResultLog']['estimated_remediation_date']),
			array('value' => $high_risk_result_log['HighRiskResultLog']['estimated_remediation_date']),
		),
		$high_risk_result_log['HighRiskResultLog']['ticket'],
		array(
			(isset($high_risk_result_log['ReportsAssignableParty']['name'])?$high_risk_result_log['ReportsAssignableParty']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result_log['ReportsAssignableParty']['id'])?$high_risk_result_log['ReportsAssignableParty']['id']:0)),
		),
		array(
			(isset($high_risk_result_log['ReportsRemediation']['name'])?$high_risk_result_log['ReportsRemediation']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result_log['ReportsRemediation']['id'])?$high_risk_result_log['ReportsRemediation']['id']:0)),
		),
		array(
			(isset($high_risk_result_log['ReportsVerification']['name'])?$high_risk_result_log['ReportsVerification']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($high_risk_result_log['ReportsVerification']['id'])?$high_risk_result_log['ReportsVerification']['id']:0)),
		),
		array(
			(isset($high_risk_result_log['ReportsStatus']['name'])?$high_risk_result_log['ReportsStatus']['name']:'&nbsp;'), 
			array('class' => 'nowrap', 'value' => (isset($high_risk_result_log['ReportsStatus']['id'])?$high_risk_result_log['ReportsStatus']['id']:0)),
		),
		$high_risk_result_log['HighRiskResultModifiedUser']['name'],
		$this->Wrap->niceTime($high_risk_result_log['HighRiskResultLog']['created']),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('High Risk Results Log'),
	'th' => $th,
	'td' => $td,
));