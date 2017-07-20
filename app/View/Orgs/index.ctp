<?php

$th = array();
$th['FismaSystem.count'] = array('content' => __('# %s', __('FISMA Systems')));
$th['UsResult.count'] = array('content' => __('# %s', __('US')));
$th['EolResult.count'] = array('content' => __('# %s', __('EOL')));
$th['PenTestResult.count'] = array('content' => __('# %s', __('PT')));
$th['HighRiskResult.count'] = array('content' => __('# %s', __('HR')));

foreach ($orgs as $i => $org)
{
	$td[$i] = array();
	$td[$i]['FismaSystem.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems', 'action' => 'org', $org['Org']['id']), 
		'url' => array('action' => 'view', $org['Org']['id'], 'tab' => 'fisma_systems'),
	));
	$td[$i]['UsResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'us_results', 'action' => 'org', $org['Org']['id']), 
		'url' => array('action' => 'view', $org['Org']['id'], 'tab' => 'us_results'),
	));
	$td[$i]['EolResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'org', $org['Org']['id']), 
		'url' => array('action' => 'view', $org['Org']['id'], 'tab' => 'eol_results'),
	));
	$td[$i]['PenTestResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'org', $org['Org']['id']), 
		'url' => array('action' => 'view', $org['Org']['id'], 'tab' => 'pen_test_results'),
	));
	$td[$i]['HighRiskResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'org', $org['Org']['id']), 
		'url' => array('action' => 'view', $org['Org']['id'], 'tab' => 'high_risk_results'),
	));
}

$this->set(compact(array('th', 'td')));
$this->extend('Contacts.ContactsOrgs/index');