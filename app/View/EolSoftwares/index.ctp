<?php 

$page_options = array();

if($this->Common->roleCheck(array('admin', 'saa')))
{
	$page_options['add'] = $this->Html->link(__('Add %s', __('Software/Vulnerability') ), array('action' => 'add', 'saa' => true));
}

// content
$th = array(
	'EolSoftware.key' => array('content' => __('Key'), 'options' => array('sort' => 'EolSoftware.key', 'editable' => array('type' => 'text'))),
	'EolSoftware.name' => array('content' => __('Name'), 'options' => array('sort' => 'EolSoftware.name', 'editable' => array('type' => 'text'))),
	'EolSoftware.is_us' => array('content' => __('US?'), 'options' => array('sort' => 'EolSoftware.is_us')),
	'EolSoftware.is_vuln' => array('content' => __('Vuln?'), 'options' => array('sort' => 'EolSoftware.is_vuln')),
	'EolSoftware.family' => array('content' => __('Family'), 'options' => array('sort' => 'EolSoftware.family', 'editable' => array('type' => 'text'))),
	'EolSoftware.severity' => array('content' => __('Severity'), 'options' => array('sort' => 'EolSoftware.severity', 'editable' => array('type' => 'text'))),
	'EolSoftware.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'EolSoftware.tickets', 'editable' => array('type' => 'text'))),
	'EolSoftware.waiver' => array('content' => __('Waivers'), 'options' => array('sort' => 'EolSoftware.waiver', 'editable' => array('type' => 'text'))),
	'EolSoftware.changerequest' => array('content' => __('CR IDs'), 'options' => array('sort' => 'EolSoftware.changerequest', 'editable' => array('type' => 'text'))),
	'EolSoftware.action_recommended' => array('content' => __('Recommended Action'), 'options' => array('sort' => 'EolSoftware.action_recommended', 'editable' => array('type' => 'textarea'))),
	'EolSoftware.resolved_by_date' => array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'EolSoftware.resolved_by_date', 'editable' => array('type' => 'date') )),
	'EolSoftware.reports_assignable_party_id' => array('content' => __('Assignable Party'), 'options' => array('sort' => 'ReportsAssignableParty.name', 'editable' => array('type' => 'select', 'options' => $reportsAssignableParties) )),
	'EolSoftware.assignable_party_date' => array('content' => __('Assignable Party Date'), 'options' => array('sort' => 'EolSoftware.assignable_party_date')),
	'EolSoftware.reports_remediation_id' => array('content' => __('Remediation'), 'options' => array('sort' => 'ReportsRemediation.name', 'editable' => array('type' => 'select', 'options' => $reportsRemediations) )),
	'EolSoftware.remediation_date' => array('content' => __('Remediation Date'), 'options' => array('sort' => 'EolSoftware.remediation_date')),
	'EolSoftware.reports_verification_id' => array('content' => __('Verification'), 'options' => array('sort' => 'ReportsVerification.name', 'editable' => array('type' => 'select', 'options' => $reportsVerifications) )),
	'EolSoftware.verification_date' => array('content' => __('Verification Date'), 'options' => array('sort' => 'EolSoftware.verification_date')),
	'EolSoftware.action_date' => array('content' => __('Action Date'), 'options' => array('sort' => 'EolSoftware.action_date', 'editable' => array('type' => 'date') )),
	'EolSoftware.hw_price' => array('content' => __('Hardware $'), 'options' => array('sort' => 'EolSoftware.hw_price', 'editable' => array('type' => 'price'))),
	'EolSoftware.sw_price' => array('content' => __('Software $'), 'options' => array('sort' => 'EolSoftware.sw_price', 'editable' => array('type' => 'price'))),
	'alias_count' => array('content' => __('# Aliases')),
	'us_count' => array('content' => __('# US')),
	'eol_count' => array('content' => __('# EOL')),
	'pt_count' => array('content' => __('# PT')),
	'hr_count' => array('content' => __('# HR')),
	'EolSoftware.created' => array('content' => __('Created'), 'options' => array('sort' => 'EolSoftware.created')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($eolSoftwares as $i => $eolSoftware)
{
	if(isset($eolSoftware['EolSoftware']['ReportsAssignableParty']))
		$eolSoftware['ReportsAssignableParty'] = $eolSoftware['EolSoftware']['ReportsAssignableParty'];
	if(isset($eolSoftware['EolSoftware']['ReportsRemediation']))
		$eolSoftware['ReportsRemediation'] = $eolSoftware['EolSoftware']['ReportsRemediation'];
	if(isset($eolSoftware['EolSoftware']['ReportsVerification']))
		$eolSoftware['ReportsVerification'] = $eolSoftware['EolSoftware']['ReportsVerification'];
	
	$edit_id = array(
		'EolSoftware' => $eolSoftware['EolSoftware']['id'],
	);
	
	$actions = array();
	$actions['view'] = $this->Html->link(__('View'), array('action' => 'view', $eolSoftware['EolSoftware']['id']));
	if($this->Common->roleCheck(array('admin', 'saa')))
	{
		$actions['edit'] = $this->Html->link(__('Edit'), array('action' => 'edit', $eolSoftware['EolSoftware']['id'], 'saa' => true));
		$actions['makealias'] = $this->Html->link(__('Make Alias'), array('action' => 'makealias', $eolSoftware['EolSoftware']['id'], 'saa' => true));
	}
	if($this->Common->roleCheck(array('admin')))
	{
		$actions['delete'] = $this->Html->link(__('Delete'), array('action' => 'delete', $eolSoftware['EolSoftware']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
	}
	
	$td[$i] = array(
		$this->Html->link($eolSoftware['EolSoftware']['key'], array('action' => 'view', $eolSoftware['EolSoftware']['id'])),
		$this->Html->link($eolSoftware['EolSoftware']['name'], array('action' => 'view', $eolSoftware['EolSoftware']['id'])),
		$this->Common->yesNo($eolSoftware['EolSoftware']['is_us']),
		$this->Common->yesNo($eolSoftware['EolSoftware']['is_vuln']),
		$eolSoftware['EolSoftware']['family'],
		$eolSoftware['EolSoftware']['severity'],
		array($this->Local->ticketLinks($eolSoftware['EolSoftware']['tickets']), array('class' => 'nowrap')),
		array($this->Local->waiverLinks($eolSoftware['EolSoftware']['waiver']), array('class' => 'nowrap')),
		array($this->Local->crLinks($eolSoftware['EolSoftware']['changerequest']), array('class' => 'nowrap')),
		$this->Html->tableDesc($eolSoftware['EolSoftware']['action_recommended']),
		array(
			$this->Wrap->niceDay($eolSoftware['EolSoftware']['resolved_by_date']),
			array('value' => $eolSoftware['EolSoftware']['resolved_by_date']),
		),
		array(
			(isset($eolSoftware['ReportsAssignableParty']['name'])?$eolSoftware['ReportsAssignableParty']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eolSoftware['ReportsAssignableParty']['id'])?$eolSoftware['ReportsAssignableParty']['id']:0)),
		),
		array($this->Wrap->niceDay($eolSoftware['EolSoftware']['assignable_party_date']), array('class' => 'nowrap', 'value' => ($eolSoftware['EolSoftware']['assignable_party_date']?$eolSoftware['EolSoftware']['assignable_party_date']:false))),
		array(
			(isset($eolSoftware['ReportsRemediation']['name'])?$eolSoftware['ReportsRemediation']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eolSoftware['ReportsRemediation']['id'])?$eolSoftware['ReportsRemediation']['id']:0)),
		),
		array($this->Wrap->niceDay($eolSoftware['EolSoftware']['remediation_date']), array('class' => 'nowrap', 'value' => ($eolSoftware['EolSoftware']['remediation_date']?$eolSoftware['EolSoftware']['remediation_date']:false))),
		array(
			(isset($eolSoftware['ReportsVerification']['name'])?$eolSoftware['ReportsVerification']['name']:'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eolSoftware['ReportsVerification']['id'])?$eolSoftware['ReportsVerification']['id']:0)),
		),
		array($this->Wrap->niceDay($eolSoftware['EolSoftware']['verification_date']), array('class' => 'nowrap', 'value' => ($eolSoftware['EolSoftware']['verification_date']?$eolSoftware['EolSoftware']['verification_date']:false))),
		array($this->Wrap->niceDay($eolSoftware['EolSoftware']['action_date']), array('class' => 'nowrap', 'value' => ($eolSoftware['EolSoftware']['action_date']?$eolSoftware['EolSoftware']['action_date']:false))),
		array(
			(isset($eolSoftware['EolSoftware']['hw_price'])?$this->Common->nicePrice($eolSoftware['EolSoftware']['hw_price']):'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eolSoftware['EolSoftware']['hw_price'])?$eolSoftware['EolSoftware']['hw_price']:0)),
		),
		array(
			(isset($eolSoftware['EolSoftware']['sw_price'])?$this->Common->nicePrice($eolSoftware['EolSoftware']['sw_price']):'&nbsp;'),
			array('class' => 'nowrap', 'value' => (isset($eolSoftware['EolSoftware']['sw_price'])?$eolSoftware['EolSoftware']['sw_price']:0)),
		),
		array('.', array(
			'ajax_count_url' => array('controller' => 'eol_software_aliases', 'action' => 'eol_software', $eolSoftware['EolSoftware']['id'], 'admin' => false), 
			'url' => array('action' => 'view', $eolSoftware['EolSoftware']['id'], 'admin' => false, 'tab' => 'us_results'),
		)),
		array('.', array(
			'ajax_count_url' => array('controller' => 'us_results', 'action' => 'eol_software', $eolSoftware['EolSoftware']['id'], 'admin' => false), 
			'url' => array('action' => 'view', $eolSoftware['EolSoftware']['id'], 'admin' => false, 'tab' => 'us_results'),
		)),
		array('.', array(
			'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'eol_software', $eolSoftware['EolSoftware']['id'], 'admin' => false), 
			'url' => array('action' => 'view', $eolSoftware['EolSoftware']['id'], 'admin' => false, 'tab' => 'eol_results'),
		)),
		array('.', array(
			'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'eol_software', $eolSoftware['EolSoftware']['id'], 'admin' => false), 
			'url' => array('action' => 'view', $eolSoftware['EolSoftware']['id'], 'admin' => false, 'tab' => 'pen_test_results'),
		)),
		array('.', array(
			'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'eol_software', $eolSoftware['EolSoftware']['id'], 'admin' => false), 
			'url' => array('action' => 'view', $eolSoftware['EolSoftware']['id'], 'admin' => false, 'tab' => 'high_risk_results'),
		)),
		$this->Wrap->niceTime($eolSoftware['EolSoftware']['created']),
		array(
			implode('', $actions), 
			array('class' => 'actions'),
		),
		'edit_id' => $edit_id,
	);
}

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$use_gridedit = true;
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Software/Vulnerabilities'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
));