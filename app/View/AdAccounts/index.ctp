<?php 

$no_counts = (isset($no_counts)?$no_counts:false);

$th = (isset($th)?$th:array());
if(!$no_counts)
{
	$th['FismaSystem.count'] = array('content' => __('# %s', __('FISMA Systems')));
	$th['UsResult.count'] = array('content' => __('# %s', __('US')));
	$th['EolResult.count'] = array('content' => __('# %s', __('EOL')));
	$th['PenTestResult.count'] = array('content' => __('# %s', __('PT')));
	$th['HighRiskResult.count'] = array('content' => __('# %s', __('HR')));
}

$td = (isset($td)?$td:array());

foreach ($adAccounts as $i => $adAccount)
{
	$td[$i] = (isset($td[$i])?$td[$i]:array());
	
	// don't include these counts
	if(!$no_counts)
	{
		$td[$i]['FismaSystem.count'] = array('.', array(
			'ajax_count_url' => array('controller' => 'fisma_systems', 'action' => 'contact', $adAccount['AdAccount']['id']), 
			'url' => array('action' => 'view', $adAccount['AdAccount']['id'], 'tab' => 'fisma_systems_owner'),
		));
		$td[$i]['UsResult.count'] = array('.', array(
			'ajax_count_url' => array('controller' => 'us_results', 'action' => 'owner', $adAccount['AdAccount']['id']), 
			'url' => array('action' => 'view', $adAccount['AdAccount']['id'], 'tab' => 'us_results'),
		));
		$td[$i]['EolResult.count'] = array('.', array(
			'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'owner', $adAccount['AdAccount']['id']), 
			'url' => array('action' => 'view', $adAccount['AdAccount']['id'], 'tab' => 'eol_results'),
		));
		$td[$i]['PenTestResult.count'] = array('.', array(
			'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'owner', $adAccount['AdAccount']['id']), 
			'url' => array('action' => 'view', $adAccount['AdAccount']['id'], 'tab' => 'pen_test_results'),
		));
		$td[$i]['HighRiskResult.count'] = array('.', array(
			'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'owner', $adAccount['AdAccount']['id']), 
			'url' => array('action' => 'view', $adAccount['AdAccount']['id'], 'tab' => 'high_risk_results'),
		));
	}
}

$this->set(compact(array('th', 'td')));

$this->extend('Contacts.ContactsAdAccounts/index');