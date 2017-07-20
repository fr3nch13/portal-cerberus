<?php 
// File: app/View/PogLogs/admin_view.ctp

$details = array(
	array('name' => __('Port Object Group'), 'value' => $this->Html->link($pog_log['Pog']['name'], array('controller' => 'pogs', 'action' => 'view', $pog_log['Pog']['id']))),
	array('name' => __('Changed By'), 'value' => $this->Html->link($pog_log['User']['name'], array('controller' => 'users', 'action' => 'view', $pog_log['User']['id']))),
	array('name' => __('Comments'), 'value' => $this->Wrap->descView($pog_log['PogLog']['comments'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($pog_log['PogLog']['created'])),
);

$tabs = array(
	array(
		'key' => 'newports',
		'title' => __('Current Ports'),
		'content' => $this->Wrap->descView($pog_log['PogLog']['ports']),
	),
	array(
		'key' => 'oldports',
		'title' => __('Old Ports'),
		'content' => $this->Wrap->descView($pog_log['PogLog']['old_ports']),
	),
	array(
		'key' => 'diffports',
		'title' => __('Differences in Ports'),
		'content' => $this->Local->diffListsView($pog_log['PogLog']['ports'], $pog_log['PogLog']['old_ports']),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Port Object Group Log'),
//	'page_options' => $page_options,
	'details' => $details,
//	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>