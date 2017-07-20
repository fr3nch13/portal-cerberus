<?php 
// File: app/View/FogLogs/view.ctp

$details = array(
	array('name' => __('Firewall Object Group'), 'value' => $this->Html->link($fog_log['Fog']['name'], array('controller' => 'fogs', 'action' => 'view', $fog_log['Fog']['id']))),
	array('name' => __('Changed By'), 'value' => $this->Html->link($fog_log['User']['name'], array('controller' => 'users', 'action' => 'view', $fog_log['User']['id']))),
	array('name' => __('Comments'), 'value' => $this->Wrap->descView($fog_log['FogLog']['comments'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fog_log['FogLog']['created'])),
);

$tabs = array(
	array(
		'key' => 'newipadresses',
		'title' => __('Current IP Addresses'),
		'content' => $this->Wrap->descView($fog_log['FogLog']['ip_addresses']),
	),
	array(
		'key' => 'oldipaddresses',
		'title' => __('Old IP Addresses'),
		'content' => $this->Wrap->descView($fog_log['FogLog']['old_ip_addresses']),
	),
	array(
		'key' => 'diffipaddresses',
		'title' => __('Differences in Ip Addresses'),
		'content' => $this->Local->diffListsView($fog_log['FogLog']['ip_addresses'], $fog_log['FogLog']['old_ip_addresses']),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Firewall Object Group Log'),
//	'page_options' => $page_options,
	'details' => $details,
//	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>