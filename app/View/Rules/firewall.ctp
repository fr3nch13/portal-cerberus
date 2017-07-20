<?php 
// File: app/View/Rule/firewall.ctp

$page_options = array(
	$this->Html->link(__('Add New %s to this %s', __('Rule'), __('Firewall')), array('action' => 'add', 0, 0, $firewall['Firewall']['id'])),
);

$this->set('page_options', $page_options);

$this->extend('index');