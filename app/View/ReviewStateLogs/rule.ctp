<?php 
// File: app/View/ReviewStateLogs/rule.ctp

// content
$th = array(
	'OldReviewState.name' => array('content' => __('Review State From'), 'options' => array('sort' => 'OldReviewState.name')),
	'ReviewState.name' => array('content' => __('Review State To'), 'options' => array('sort' => 'ReviewState.name')),
	'User.name' => array('content' => __('Reviewer'), 'options' => array('sort' => 'User.name')),
	'ReviewStateLog.created' => array('content' => __('Date'), 'options' => array('sort' => 'ReviewStateLog.created')),
	'ReviewStateLog.comments' => array('content' => __('Comments'), 'options' => array('sort' => 'ReviewStateLog.comments')),
);

$td = array();
foreach ($review_state_logs as $i => $review_state_log)
{	
	$td[$i] = array(
		$this->Html->link($review_state_log['OldReviewState']['name'], array('controller' => 'rules', 'action' => 'review_state', $review_state_log['OldReviewState']['id'])),
		$this->Html->link($review_state_log['ReviewState']['name'], array('controller' => 'rules', 'action' => 'review_state', $review_state_log['ReviewState']['id'])),
		$this->Html->link($review_state_log['User']['name'], array('controller' => 'users', 'action' => 'view', $review_state_log['User']['id'])),
		$this->Wrap->niceTime($review_state_log['ReviewStateLog']['created']),
		$review_state_log['ReviewStateLog']['comments'],
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Review State Logs'),
	'th' => $th,
	'td' => $td,
));