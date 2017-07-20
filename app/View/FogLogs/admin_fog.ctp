<?php 
// File: app/View/FogLogs/admin_fog.ctp

// content
$th = array(
	'FogLog.old_name' => array('content' => __('Old Name'), 'options' => array('sort' => 'FogLog.old_name')),
	'FogLog.name' => array('content' => __('New Name'), 'options' => array('sort' => 'FogLog.name')),
//	'FogLog.old_ip_addresses' => array('content' => __('Old IP Addresses'), 'options' => array('sort' => 'FogLog.old_ip_addresses')),
//	'FogLog.ip_addresses' => array('content' => __('IP Addresses'), 'options' => array('sort' => 'FogLog.ip_addresses')),
	'User.name' => array('content' => __('Changed By'), 'options' => array('sort' => 'User.name')),
	'FogLog.created' => array('content' => __('Date'), 'options' => array('sort' => 'FogLog.created')),
	'FogLog.comments' => array('content' => __('Comments'), 'options' => array('sort' => 'FogLog.comments')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fog_logs as $i => $fog_log)
{	
	$td[$i] = array(
		$fog_log['FogLog']['old_name'],
		$fog_log['FogLog']['name'],
//		$fog_log['FogLog']['old_ip_addresses'],
//		$fog_log['FogLog']['ip_addresses'],
		$this->Html->link($fog_log['User']['name'], array('controller' => 'users', 'action' => 'view', $fog_log['User']['id'])),
		$this->Wrap->niceTime($fog_log['FogLog']['created']),
		$fog_log['FogLog']['comments'],
		array(
			$this->Html->link(__('View'), array('controller' => 'fog_logs', 'action' => 'view', $fog_log['FogLog']['id'])),
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('F.O.G. Logs'),
	'page_description' => __('Ip Address changes aren\'t shown, but they are tracked.'),
	'th' => $th,
	'td' => $td,
));