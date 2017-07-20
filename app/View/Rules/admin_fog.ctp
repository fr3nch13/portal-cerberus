<?php 
// File: app/View/Rule/admin_fog.ctp

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
	'page_title' => __('All %s for %s: %s', __('Rules'), __('F.O.G.'), $fog['SrcFog']['name']),
	'th' => $th,
	'td' => $td,
	// multiselect options
	'use_multiselect' => $use_multiselect,
	'multiselect_options' => $multiselect_options,
	'multiselect_referer' => array(
		'admin' => true,
		'controller' => 'rules',
		'action' => $this->action,
		$this->params['pass'][0],
	),
));