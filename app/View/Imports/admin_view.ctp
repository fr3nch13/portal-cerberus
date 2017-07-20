<?php 
// File: app/View/Imports/admin_view.ctp

$details = array(
	array('name' => __('File Name'), 'value' => $import['Import']['filename']),
	array('name' => __('Added By'), 'value' => $this->Html->link($import['ImportAddedUser']['name'], array('controller' => 'users', 'action' => 'view', $import['ImportAddedUser']['id']))),
	array('name' => __('Last Scanned'), 'value' => $this->Wrap->niceTime($import['Import']['rescanned'])),
	array('name' => __('Last Scanned By'), 'value' => $this->Html->link($import['ImportRescannedUser']['name'], array('controller' => 'users', 'action' => 'view', $import['ImportRescannedUser']['id']))),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($import['Import']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($import['Import']['modified'])),
	
);

$page_options = array(
	$this->Html->link(__('Edit'), array('action' => 'edit', $import['Import']['id'])),
	$this->Html->link(__('%s/%s', __('Scan'), __('Rescan')), array('action' => 'rescan', $import['Import']['id']), array('confirm' => __('Are you sure you want to rescan the config file?')) ),
	$this->Form->postLink(__('Delete'),array('action' => 'delete', $import['Import']['id']),array('confirm' => 'Are you sure?')),
);


$stats = array(
	array(
		'id' => 'rules',
		'name' => __('Rules'), 
		'value' => $import['Import']['counts']['Rule.all'], 
		'tab' => array('tabs', '1'), // the tab to display
	),
);

$tabs = array(
	array(
		'key' => 'rules',
		'title' => __('Rules'),
		'url' => array('controller' => 'rules', 'action' => 'import', $import['Import']['id'], 'admin' => true),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Import'). ': '. $import['Import']['name'],
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));