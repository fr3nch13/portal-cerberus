<?php 

$page_subtitle = (isset($page_subtitle)?$page_subtitle:__('All'));

$page_options = (isset($page_options)?$page_options:array(
	$this->Html->link(__('Create New %s', __('Rule')), array('action' => 'add')),
));

$reviewer_admin = (in_array(AuthComponent::user('role'), array('admin', 'reviewer'))?true:false);
$use_multiselect = true;
$multiselect_options = array(
	'notify' => __('Send an Email Notification'),
);
if($reviewer_admin)
{
	$multiselect_options['review_state'] = __('Change %s', __('Review State'));
}

// content
list($th, $td) = $this->Local->mapRulesToTable($rules, array(
	'use_multiselect' => $use_multiselect,
	'reviewer_admin' => $reviewer_admin,
));

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Rules'),
	'page_subtitle' => $page_subtitle,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	// multiselect options
	'use_multiselect' => $use_multiselect,
	'multiselect_options' => $multiselect_options,
	'multiselect_referer' => array(
		'admin' => false,
		'controller' => 'rules',
		'action' => $this->action,
		(isset($this->params['pass'][0])?$this->params['pass'][0]:false),
	),
));