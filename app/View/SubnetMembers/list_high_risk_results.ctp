<?php 
// File: app/View/HighRiskResults/index.ctp

$page_options = array(
);

// content
$th = array(
	'HighRiskResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'HighRiskResult.id')),
	'HighRiskResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'HighRiskResult.ip_address')),
	'HighRiskResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'HighRiskResult.host_name')),
	'HighRiskResult.ticket' => array('content' => __('Ticket'), 'options' => array('sort' => 'HighRiskResult.ticket')),
	'HighRiskResult.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'HighRiskResult.reports_remediation_id')),
	'HighRiskResult.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'HighRiskResult.reports_verification_id')),
	'HighRiskResult.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'HighRiskResult.reports_status_id')),
	'HighRiskResult.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'HighRiskResult.reports_assignable_party_id')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($subnet_members as $i => $subnet_member)
{
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('controller' => 'high_risk_results', 'action' => 'view', $subnet_member['HighRiskResult']['id']));
	$actions[] = $this->Html->link(__('Edit'), array('controller' => 'high_risk_results', 'action' => 'edit', $subnet_member['HighRiskResult']['id']));
	
	$edit_id = array(
		'HighRiskResult' => $subnet_member['HighRiskResult']['id'],
	);
	
	$actions = implode("\n", $actions);
	
	$td[$i] = array(
		$this->Html->link($subnet_member['HighRiskResult']['id'], array('controller' => 'high_risk_results', 'action' => 'view', $subnet_member['HighRiskResult']['id'])),
		$subnet_member['HighRiskResult']['ip_address'],
		$subnet_member['HighRiskResult']['host_name'],
		array($subnet_member['HighRiskResult']['ticket'], array('class' => 'nowrap')),
		array((isset($subnet_member['HighRiskResult']['ReportsRemediation']['name'])?$subnet_member['HighRiskResult']['ReportsRemediation']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['HighRiskResult']['ReportsVerification']['name'])?$subnet_member['HighRiskResult']['ReportsVerification']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['HighRiskResult']['ReportsStatus']['name'])?$subnet_member['HighRiskResult']['ReportsStatus']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['HighRiskResult']['ReportsAssignableParty']['name'])?$subnet_member['HighRiskResult']['ReportsAssignableParty']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array(
			$actions,
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('HighRisk Results'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));