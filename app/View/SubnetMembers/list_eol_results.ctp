<?php 
// File: app/View/EolResults/index.ctp

$page_options = array(
);

// content
$th = array(
	'EolResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'EolResult.id')),
	'EolResult.reports_organization_id' => array('content' => __('Organization'), 'options' => array('sort' => 'ReportsOrganization.name' )),
	'EolResult.host_description' => array('content' => __('Host Description'), 'options' => array('sort' => 'EolResult.host_description')),
	'EolResult.ip_address' => array('content' => __('Ip Address'), 'options' => array('sort' => 'EolResult.ip_address')),
	'EolResult.host_name' => array('content' => __('Hostname'), 'options' => array('sort' => 'EolResult.host_name')),
	'EolResult.mac_address' => array('content' => __('Mac Address'), 'options' => array('sort' => 'EolResult.mac_address')),
	'EolResult.netbios' => array('content' => __('NetBIOS'), 'options' => array('sort' => 'EolResult.netbios')),
	'EolResult.eol_software_id' => array('content' => __('Software'), 'options' => array('sort' => 'EolSoftware.name')),
	'EolResult.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'EolResult.tickets')),
	'EolResult.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'EolResult.reports_remediation_id')),
	'EolResult.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'EolResult.reports_verification_id')),
	'EolResult.reports_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'EolResult.reports_status_id')),
	'EolResult.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'EolResult.reports_assignable_party_id')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($subnet_members as $i => $subnet_member)
{
	$action_date = $this->Wrap->niceTime($subnet_member['EolResult']['action_date']);	
	
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('controller' => 'eol_results', 'action' => 'view', $subnet_member['EolResult']['id']));
	$actions[] = $this->Html->link(__('Edit'), array('controller' => 'eol_results', 'action' => 'edit', $subnet_member['EolResult']['id']));
	
	$edit_id = array(
		'EolResult' => $subnet_member['EolResult']['id'],
	);
	
	$actions = implode("\n", $actions);
	
	$td[$i] = array(
		$this->Html->link($subnet_member['EolResult']['id'], array('controller' => 'eol_results', 'action' => 'view', $subnet_member['EolResult']['id'])),
		array((isset($subnet_member['EolResult']['ReportsOrganization']['name'])?$subnet_member['EolResult']['ReportsOrganization']['name']:'&nbsp;'), array('class' => 'nowrap')),
		$subnet_member['EolResult']['host_description'],
		$subnet_member['EolResult']['ip_address'],
		$subnet_member['EolResult']['host_name'],
		array($subnet_member['EolResult']['mac_address'], array('class' => 'nowrap')),
		array($subnet_member['EolResult']['netbios'], array('class' => 'nowrap')),
		array((isset($subnet_member['EolResult']['EolSoftware']['name'])?$subnet_member['EolResult']['EolSoftware']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array($subnet_member['EolResult']['tickets'], array('class' => 'nowrap')),
		array((isset($subnet_member['EolResult']['ReportsRemediation']['name'])?$subnet_member['EolResult']['ReportsRemediation']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['EolResult']['ReportsVerification']['name'])?$subnet_member['EolResult']['ReportsVerification']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['EolResult']['ReportsStatus']['name'])?$subnet_member['EolResult']['ReportsStatus']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array((isset($subnet_member['EolResult']['ReportsAssignableParty']['name'])?$subnet_member['EolResult']['ReportsAssignableParty']['name']:'&nbsp;'), array('class' => 'nowrap')),
		array(
			$actions,
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('EOL Results'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));