<?php 
// File: app/View/Protocols/admin_view.ctp

$details = array(
	array('name' => __('On Simple Form?'), 'value' => $this->Local->simpleLink($protocol['Protocol']['simple'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($protocol['Protocol']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($protocol['Protocol']['modified'])),
	
);

$page_options = array(
//	$this->Html->link(__('Edit'), array('action' => 'edit', $protocol['Protocol']['id'])),
//	$this->Form->postLink(__('Delete'),array('action' => 'delete', $protocol['Protocol']['id']),array('confirm' => 'Are you sure?')),
);


$stats = array(
	array(
		'id' => 'rules',
		'name' => __('Rules'), 
		'value' => $protocol['Protocol']['counts']['Rule.all'], 
		'tab' => array('tabs', '1'), // the tab to display
	),
	array(
		'id' => 'pogs',
		'name' => __('Port Object Groups'), 
		'value' => $protocol['Protocol']['counts']['Pog.all'], 
		'tab' => array('tabs', '2'), // the tab to display
	),
);


$tabs = array(
	array(
		'key' => 'protocols',
		'title' => __('Defined Protocols'),
		'content' => $this->Wrap->descView($protocol['Protocol']['protocols']),
	),
	array(
		'key' => 'rules',
		'title' => __('Rules'),
		'url' => array('controller' => 'rules', 'action' => 'protocol', $protocol['Protocol']['id']),
	),
	array(
		'key' => 'pogs',
		'title' => __('Port Object Groups'),
		'url' => array('controller' => 'pogs', 'action' => 'protocol', $protocol['Protocol']['id']),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Protocol'). ': '. $protocol['Protocol']['name'],
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>