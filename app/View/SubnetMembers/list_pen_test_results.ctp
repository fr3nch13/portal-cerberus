<?php 
// File: app/View/PenTestResults/index.ctp

$page_options = array(
);

// content
$th = array(
	'PenTestResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'PenTestResult.id')),
	'PenTestReport.name' => array('content' => __('Report'), 'options' => array('sort' => 'PenTestReport.name')),
	'PenTestResult.reports_organization_id' => array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name' )),
	'PenTestResult.host_description' => array('content' => __('Host Description'), 'options' => array('sort' => 'PenTestResult.host_description' )),
	'PenTestResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'PenTestResult.ip_address')),
	'PenTestResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'PenTestResult.host_name')),
	'PenTestResult.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'PenTestResult.mac_address')),
	'PenTestResult.port' => array('content' => __('Port'), 'options' => array('sort' => 'PenTestResult.port')),
	'PenTestResult.service' => array('content' => __('Service'), 'options' => array('sort' => 'PenTestResult.service')),
	'PenTestResult.vulnerability' => array('content' => __('Vulnerability'), 'options' => array('sort' => 'PenTestResult.vulnerability')),
	'PenTestResult.software' => array('content' => __('Software/Version'), 'options' => array('sort' => 'PenTestResult.software')),
	'PenTestResult.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'PenTestResult.tickets')),
	'PenTestResult.cve' => array('content' => __('CVE'), 'options' => array('sort' => 'PenTestResult.cve')),
	'PenTestResult.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'PenTestResult.netbios')),
	'PenTestResult.reports_severity_id' => array('content' => __('Severity'), 'options' => array('sort' => 'PenTestResult.reports_severity_id')),
	'PenTestResult.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'PenTestResult.reports_remediation_id')),
	'PenTestResult.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'PenTestResult.reports_verification_id')),
	'PenTestResult.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'PenTestResult.reports_status_id')),
	'PenTestResult.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'PenTestResult.reports_assignable_party_id')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($subnet_members as $i => $subnet_member)
{
	$action_date = $this->Wrap->niceTime($subnet_member['PenTestResult']['action_date']);	
	
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('controller' => 'pen_test_results', 'action' => 'view', $subnet_member['PenTestResult']['id']));
	$actions[] = $this->Html->link(__('Edit'), array('controller' => 'pen_test_results', 'action' => 'edit', $subnet_member['PenTestResult']['id'], 'admin' => false));
	
	$actions = implode("\n", $actions);
	
	$td[$i] = array(
		$this->Html->link($subnet_member['PenTestResult']['id'], array('controller' => 'pen_test_results', 'action' => 'view', $subnet_member['PenTestResult']['id'])),
		$this->Html->link($subnet_member['PenTestResult']['PenTestReport']['name'], array('controller' => 'reports_reports', 'action' => 'view', $subnet_member['PenTestResult']['PenTestReport']['id'])),
		$subnet_member['PenTestResult']['ReportsOrganization']['name'],
		$subnet_member['PenTestResult']['host_description'],
		$subnet_member['PenTestResult']['ip_address'],
		$subnet_member['PenTestResult']['host_name'],
		array($subnet_member['PenTestResult']['mac_address'], array('class' => 'nowrap')),
		$subnet_member['PenTestResult']['port'],
		$subnet_member['PenTestResult']['service'],
		array($subnet_member['PenTestResult']['vulnerability'], array('class' => 'nowrap')),
		array($subnet_member['PenTestResult']['software'], array('class' => 'nowrap')),
		array($subnet_member['PenTestResult']['tickets'], array('class' => 'nowrap')),
		array($subnet_member['PenTestResult']['cve'], array('class' => 'nowrap')),
		array($subnet_member['PenTestResult']['netbios'], array('class' => 'nowrap')),
		array((isset($subnet_member['PenTestResult']['ReportsSeverity']['name'])?$subnet_member['PenTestResult']['ReportsSeverity']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['PenTestResult']['ReportsRemediation']['name'])?$subnet_member['PenTestResult']['ReportsRemediation']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['PenTestResult']['ReportsVerification']['name'])?$subnet_member['PenTestResult']['ReportsVerification']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['PenTestResult']['ReportsStatus']['name'])?$subnet_member['PenTestResult']['ReportsStatus']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['PenTestResult']['ReportsAssignableParty']['name'])?$subnet_member['PenTestResult']['ReportsAssignableParty']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array(
			$actions,
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Pen Test Results'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));