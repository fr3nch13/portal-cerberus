<?php 
// File: app/View/Users/admin_view.ctp

$page_options = array(
//	$this->Form->postLink(__('Toggle Active State'),array('action' => 'toggle', 'active', $user['User']['id']),array('confirm' => 'Are you sure?')),
	$this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])),
//	$this->Form->postLink(__('Delete'),array('action' => 'delete', $user['User']['id']),array('confirm' => 'Are you sure?')),
);

$details_left = array(
	array('name' => __('Email'), 'value' => $this->Html->link($user['User']['email'], 'mailto:'. $user['User']['email'])),
	array('name' => __('AD Account'), 'value' => $user['User']['adaccount']),
	array('name' => __('User ID'), 'value' => $this->Html->link($user['User']['userid'], 'https://users.example.com?id='. $user['User']['userid'], array('target' => 'ned'))),
	array('name' => __('Active'), 'value' => $this->Wrap->yesNo($user['User']['active'])),
	array('name' => __('Role'), 'value' => $this->Wrap->userRole($user['User']['role'])),
);
$details_right = array(
	array('name' => __('Last Login'), 'value' => $this->Wrap->niceTime($user['User']['lastlogin'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($user['User']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($user['User']['modified'])),
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
	array(
		'key' => 'logins',
		'title' => __('Login History'),
		'url' => array('controller' => 'login_histories', 'action' => 'user', $user['User']['id']),
	),
);

echo $this->element('Utilities.page_compare', array(
	'page_title' => __('%s: %s', __('User'), $user['User']['name']),
	'page_options' => $page_options,
	'details_left_title' => ' ',
	'details_left' => $details_left,
	'details_right_title' => ' ',
	'details_right' => $details_right,
	'stats' => $stats,
	'tabs' => $tabs,
));
