<?php 

$page_options = array(
);

// content
$th = array(
	'UsResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'UsResult.id')),
	'UsResult.reports_organization_id' => array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name' )),
	'UsResult.host_description' => array('content' => __('Host Description'), 'options' => array('sort' => 'UsResult.host_description')),
	'UsResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'UsResult.ip_address')),
	'UsResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'UsResult.host_name')),
	'UsResult.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'UsResult.mac_address')),
	'UsResult.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'UsResult.netbios')),
	'UsResult.eol_software_id' => array('content' => __('EOL/US Software'), 'options' => array('sort' => 'EolSoftware.name')),
	'UsResult.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'UsResult.tickets')),
	'UsResult.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'UsResult.reports_remediation_id')),
	'UsResult.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'UsResult.reports_verification_id')),
	'UsResult.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'UsResult.reports_status_id')),
	'UsResult.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'UsResult.reports_assignable_party_id')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($subnet_members as $i => $subnet_member)
{
	$action_date = $this->Wrap->niceDay($subnet_member['UsResult']['action_date']);	
	
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('controller' => 'us_results', 'action' => 'view', $subnet_member['UsResult']['id']));
	$actions[] = $this->Html->link(__('Edit'), array('controller' => 'us_results', 'action' => 'edit', $subnet_member['UsResult']['id']));
	
	$edit_id = array(
		'UsResult' => $subnet_member['UsResult']['id'],
	);
	
	$actions = implode("\n", $actions);
	
	$td[$i] = array(
		$this->Html->link($subnet_member['UsResult']['id'], array('controller' => 'us_results', 'action' => 'view', $subnet_member['UsResult']['id'])),
		array((isset($subnet_member['UsResult']['ReportsOrganization']['name'])?$subnet_member['UsResult']['ReportsOrganization']['name']:'&nbsp;'), array('class' => 'nowrap')),
		$subnet_member['UsResult']['host_description'],
		$subnet_member['UsResult']['ip_address'],
		$subnet_member['UsResult']['host_name'],
		array($subnet_member['UsResult']['mac_address'], array('class' => 'nowrap')),
		array($subnet_member['UsResult']['netbios'], array('class' => 'nowrap')),
		array((isset($subnet_member['UsResult']['EolSoftware']['name'])?$subnet_member['UsResult']['EolSoftware']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array($subnet_member['UsResult']['tickets'], array('class' => 'nowrap')),
		array((isset($subnet_member['UsResult']['ReportsRemediation']['name'])?$subnet_member['UsResult']['ReportsRemediation']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['UsResult']['ReportsVerification']['name'])?$subnet_member['UsResult']['ReportsVerification']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['UsResult']['ReportsStatus']['name'])?$subnet_member['UsResult']['ReportsStatus']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['UsResult']['ReportsAssignableParty']['name'])?$subnet_member['UsResult']['ReportsAssignableParty']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array(
			$actions,
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('US Results'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));