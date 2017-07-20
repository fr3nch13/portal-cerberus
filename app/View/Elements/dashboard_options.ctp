<?php
$this->extend('Utilities.object_dashboard_options');

$dashboard_options_title = __('Switch Dashboards');

$prefix = false;
if(isset($this->request->params['prefix']) and $this->request->params['prefix'])
	$prefix = $this->request->params['prefix'];
$ad_account_id = (isset($ad_account_id)?$ad_account_id:false);

$dashboard_options_items = array();
$dashboard_options_items[] = $this->Html->link(__('Overview'), array('prefix' => $prefix, 'controller' => 'main', 'action' => 'dashboard', $ad_account_id));
$dashboard_options_items[] = $this->Html->link(__('My Overview'), array('prefix' => $prefix, 'controller' => 'main', 'action' => 'my_dashboard'));
$dashboard_options_items[] = $this->Html->link(__('FISMA Systems'), array('prefix' => $prefix, 'controller' => 'fisma_systems', 'action' => 'dashboard', $ad_account_id));
$dashboard_options_items[] = $this->Html->link(__('Usupported Software'), array('prefix' => $prefix, 'controller' => 'us_results', 'action' => 'dashboard', $ad_account_id));
$dashboard_options_items[] = $this->Html->link(__('End of Life'), array('prefix' => $prefix, 'controller' => 'eol_results', 'action' => 'dashboard', $ad_account_id));
$dashboard_options_items[] = $this->Html->link(__('Penetration Tests'), array('prefix' => $prefix, 'controller' => 'pen_test_results', 'action' => 'dashboard', $ad_account_id));
$dashboard_options_items[] = $this->Html->link(__('High Risk Vulnerabilities'), array('prefix' => $prefix, 'controller' => 'high_risk_results', 'action' => 'dashboard', $ad_account_id));
//$dashboard_options_items[] = $this->Html->link(__('Rules'), array('controller' => 'rules', 'action' => 'dashboard'));

$this->set('dashboard_options_title', $dashboard_options_title);
$this->set('dashboard_options_items', $dashboard_options_items);
