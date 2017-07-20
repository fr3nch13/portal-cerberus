<?php 

$th = array();
$th['FismaSystem.count'] = array('content' => __('# %s', __('FISMA Systems')));
$th['UsResult.count'] = array('content' => __('# %s', __('US')));
$th['EolResult.count'] = array('content' => __('# %s', __('EOL')));
$th['PenTestResult.count'] = array('content' => __('# %s', __('PT')));
$th['HighRiskResult.count'] = array('content' => __('# %s', __('HR')));

foreach ($sacs as $i => $sac)
{
	$td[$i] = array();
	$td[$i]['FismaSystem.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems', 'action' => 'sac', $sac['Sac']['id']), 
		'url' => array('action' => 'view', $sac['Sac']['id'], 'tab' => 'fisma_systems'),
	));
	$td[$i]['UsResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'us_results', 'action' => 'sac', $sac['Sac']['id']), 
		'url' => array('action' => 'view', $sac['Sac']['id'], 'tab' => 'us_results'),
	));
	$td[$i]['EolResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'sac', $sac['Sac']['id']), 
		'url' => array('action' => 'view', $sac['Sac']['id'], 'tab' => 'eol_results'),
	));
	$td[$i]['PenTestResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'sac', $sac['Sac']['id']), 
		'url' => array('action' => 'view', $sac['Sac']['id'], 'tab' => 'pen_test_results'),
	));
	$td[$i]['HighRiskResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'sac', $sac['Sac']['id']), 
		'url' => array('action' => 'view', $sac['Sac']['id'], 'tab' => 'high_risk_results'),
	));
}

$this->set(compact(array('th', 'td')));
$this->extend('Contacts.ContactsSacs/index');