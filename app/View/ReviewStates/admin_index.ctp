<?php 
// File: app/View/ReviewStates/index.ctp


$page_options = array(
	$this->Html->link(__('Add Review State'), array('action' => 'add')),
);

// content
$th = array(
	'ReviewState.name' => array('content' => __('Review State'), 'options' => array('sort' => 'ReviewState.name')),
	'ReviewState.default' => array('content' => __('Default'), 'options' => array('sort' => 'ReviewState.default')),
	'ReviewState.sendemail' => array('content' => __('Send Email?'), 'options' => array('sort' => 'ReviewState.sendemail')),
	'ReviewState.mon' => array('content' => __('Mon'), 'options' => array('sort' => 'ReviewState.mon')),
	'ReviewState.tue' => array('content' => __('Tues'), 'options' => array('sort' => 'ReviewState.tue')),
	'ReviewState.wed' => array('content' => __('Wed'), 'options' => array('sort' => 'ReviewState.wed')),
	'ReviewState.thu' => array('content' => __('Thurs'), 'options' => array('sort' => 'ReviewState.thu')),
	'ReviewState.fri' => array('content' => __('Fri'), 'options' => array('sort' => 'ReviewState.fri')),
	'ReviewState.sat' => array('content' => __('Sat'), 'options' => array('sort' => 'ReviewState.sat')),
	'ReviewState.sun' => array('content' => __('Sun'), 'options' => array('sort' => 'ReviewState.sun')),
	'ReviewState.notify_time' => array('content' => __('Send Email At'), 'options' => array('sort' => 'ReviewState.notify_time')),
	'ReviewState.notify_email' => array('content' => __('Notification Email'), 'options' => array('sort' => 'ReviewState.notify_email')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($review_states as $i => $review_state)
{
	$default_button = '';
	
	if(!$review_state['ReviewState']['default'])
	{
		$default_button = $this->Html->link(__('Make Default'), array('action' => 'default', $review_state['ReviewState']['id']));
	}
	
	$td[$i] = array(
		$review_state['ReviewState']['name'],
		$this->Wrap->yesNo($review_state['ReviewState']['default']),
		$this->Wrap->yesNo($review_state['ReviewState']['sendemail']),
		$this->Wrap->check($review_state['ReviewState']['mon']),
		$this->Wrap->check($review_state['ReviewState']['tue']),
		$this->Wrap->check($review_state['ReviewState']['wed']),
		$this->Wrap->check($review_state['ReviewState']['thu']),
		$this->Wrap->check($review_state['ReviewState']['fri']),
		$this->Wrap->check($review_state['ReviewState']['sat']),
		$this->Wrap->check($review_state['ReviewState']['sun']),
		$this->Local->reviewTimes($review_state['ReviewState']['notify_time']),
		$review_state['ReviewState']['notify_email'],
		array(
			$default_button.
			$this->Html->link(__('Edit'), array('action' => 'edit', $review_state['ReviewState']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $review_state['ReviewState']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Review States'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>