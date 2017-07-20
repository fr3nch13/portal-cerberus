<?php 
// File: app/View/Users/view.ctp
$page_options = array(
);

$details = array(
	array('name' => __('Email'), 'value' => $this->Html->link($user['User']['email'], 'mailto:'. $user['User']['email'])),
	array('name' => __('AD Account'), 'value' => $user['User']['adaccount']),
	array('name' => __('User ID'), 'value' => $this->Html->link($user['User']['userid'], 'https://users.example.com?id='. $user['User']['userid'], array('target' => 'ned'))),
);

$stats = array(
	array(
		'id' => 'RuleAddedUser',
		'name' => __('Added %s', __('Rules')),
		'ajax_count_url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'added'),
		'tab' => array('tabs', '1'), // the tab to display
	),
	array(
		'id' => 'RuleModifiedUser',
		'name' => __('Last Updated %s', __('Rules')),
		'ajax_count_url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'modified'),
		'tab' => array('tabs', '2'), // the tab to display
	),
	array(
		'id' => 'RuleReviewedUser',
		'name' => __('Last Reviewed %s', __('Rules')),
		'ajax_count_url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'reviewed'),
		'tab' => array('tabs', '3'), // the tab to display
	),
	array(
		'id' => 'RulePocUser',
		'name' => __('POC %s', __('Rules')),
		'ajax_count_url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'poc'),
		'tab' => array('tabs', '4'), // the tab to display
	),
);

$tabs = array(
	array(
		'key' => 'RuleAddedUser',
		'title' => __('Added %s', __('Rules')),
		'url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'added'),
	),
	array(
		'key' => 'RuleModifiedUser',
		'title' => __('Last Updated %s', __('Rules')),
		'url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'modified'),
	),
	array(
		'key' => 'RuleReviewedUser',
		'title' => __('Last Reviewed %s', __('Rules')),
		'url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'reviewed'),
	),
	array(
		'key' => 'RulePocUser',
		'title' => __('POC %s', __('Rules')),
		'url' => array('controller' => 'rules', 'action' => 'user', $user['User']['id'], 'poc'),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s: %s', __('User'), $user['User']['name']),
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs' => $tabs,
));