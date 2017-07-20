<?php 
// File: app/View/AdAccounts/view.ctp

$tabs = array();
$stats = array();

$tabs['fisma_contact_systems'] = $stats['fisma_contact_systems'] = array(
	'id' => 'fisma_contact_systems',
	'name' => __('%s by %s', __('FISMA Systems'), __('Contacts')),
	'ajax_url' => array('controller' => 'ad_accounts_fisma_systems', 'action' => 'ad_account', $adAccount['AdAccount']['id']),
);
$tabs['fisma_system_owner'] = $stats['fisma_system_owner'] = array(
	'id' => 'fisma_system_owner',
	'name' => __('%s by %s', __('FISMA Systems'), __('System Owner')),
	'ajax_url' => array('controller' => 'fisma_systems', 'action' => 'contact', $adAccount['AdAccount']['id'], 'list' => 'all'),
);
$tabs['us_results_owner'] = $stats['us_results_owner'] = array(
	'id' => 'us_results_owner',
	'name' => __('%s by %s', __('US Results'), __('Owner')),
	'ajax_url' => array('controller' => 'us_results', 'action' => 'owner', $adAccount['AdAccount']['id']),
);
$tabs['eol_results_owner'] = $stats['eol_results_owner'] = array(
	'id' => 'eol_results_owner',
	'name' => __('%s by %s', __('EOL Results'), __('Owner')),
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'owner', $adAccount['AdAccount']['id']),
);
$tabs['pen_test_results_owner'] = $stats['pen_test_results_owner'] = array(
	'id' => 'pen_test_results_owner',
	'name' => __('%s by %s', __('Pen Test Results'), __('Owner')),
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'owner', $adAccount['AdAccount']['id']),
);
$tabs['high_risk_results_owner'] = $stats['high_risk_results_owner'] = array(
	'id' => 'high_risk_results_owner',
	'name' => __('%s by %s', __('High Risk Results'), __('Owner')),
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'owner', $adAccount['AdAccount']['id']),
);
$tabs['fisma_system_crm'] = $stats['fisma_system_crm'] = array(
	'id' => 'fisma_system_crm',
	'name' => __('%s by %s', __('FISMA Systems'), __('CRM')),
	'ajax_url' => array('controller' => 'fisma_systems', 'action' => 'crm', $adAccount['AdAccount']['id']),
);
$tabs['us_results_crm'] = $stats['us_results_crm'] = array(
	'id' => 'us_results_crm',
	'name' => __('%s by %s', __('US Results'), __('CRM')),
	'ajax_url' => array('controller' => 'us_results', 'action' => 'crm', $adAccount['AdAccount']['id']),
);
$tabs['eol_results_crm'] = $stats['eol_results_crm'] = array(
	'id' => 'eol_results_crm',
	'name' => __('%s by %s', __('EOL Results'), __('CRM')),
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'crm', $adAccount['AdAccount']['id']),
);
$tabs['pen_test_results_crm'] = $stats['pen_test_results_crm'] = array(
	'id' => 'pen_test_results_crm',
	'name' => __('%s by %s', __('Pen Test Results'), __('CRM')),
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'crm', $adAccount['AdAccount']['id']),
);
$tabs['high_risk_results_crm'] = $stats['high_risk_results_crm'] = array(
	'id' => 'high_risk_results_crm',
	'name' => __('%s by %s', __('High Risk Results'), __('CRM')),
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'crm', $adAccount['AdAccount']['id']),
);

$this->set(compact(array('stats', 'tabs')));
$this->extend('Contacts.ContactsAdAccounts/view');