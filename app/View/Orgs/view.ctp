<?php
$stats = array();
$tabs = array();

$tabs['fisma_systems'] = $stats['fisma_systems'] = array(
	'id' => 'fisma_systems',
	'name' => __('FISMA Systems'),
	'ajax_url' => array('controller' => 'fisma_systems', 'action' => 'org', $org['Org']['id']),
);
$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'),
	'ajax_url' => array('controller' => 'us_results', 'action' => 'org', $org['Org']['id']),
);
$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'),
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'org', $org['Org']['id']),
);
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'),
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'org', $org['Org']['id']),
);
$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'),
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'org', $org['Org']['id']),
);

$this->set(compact(array('stats', 'tabs')));
$this->extend('Contacts.ContactsOrgs/view');