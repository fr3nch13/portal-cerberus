<?php 
// File: app/View/PogLogs/admin_pog.ctp

// content
$th = array(
	'PogLog.old_name' => array('content' => __('Old Name'), 'options' => array('sort' => 'PogLog.old_name')),
	'PogLog.name' => array('content' => __('New Name'), 'options' => array('sort' => 'PogLog.name')),
//	'PogLog.old_ports' => array('content' => __('Old Ports'), 'options' => array('sort' => 'PogLog.old_ports')),
//	'PogLog.ports' => array('content' => __('Ports'), 'options' => array('sort' => 'PogLog.ports')),
	'User.name' => array('content' => __('Changed By'), 'options' => array('sort' => 'User.name')),
	'PogLog.created' => array('content' => __('Date'), 'options' => array('sort' => 'PogLog.created')),
	'PogLog.comments' => array('content' => __('Comments'), 'options' => array('sort' => 'PogLog.comments')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($pog_logs as $i => $pog_log)
{	
	$td[$i] = array(
		$pog_log['PogLog']['old_name'],
		$pog_log['PogLog']['name'],
//		$pog_log['PogLog']['old_ports'],
//		$pog_log['PogLog']['ports'],
		$this->Html->link($pog_log['User']['name'], array('controller' => 'users', 'action' => 'view', $pog_log['User']['id'])),
		$this->Wrap->niceTime($pog_log['PogLog']['created']),
		$pog_log['PogLog']['comments'],
		array(
			$this->Html->link(__('View'), array('controller' => 'pog_logs', 'action' => 'view', $pog_log['PogLog']['id'])),
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Port Object Group Logs'),
	'page_description' => __('Port Object Group changes aren\'t shown, but they are tracked.'),
	'th' => $th,
	'td' => $td,
));