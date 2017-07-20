<?php 
// File: app/View/FwInterfaces/admin_view.ctp

$details = array(
	array('name' => __('Slug'), 'value' => $fw_interface['FwInterface']['slug']),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fw_interface['FwInterface']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fw_interface['FwInterface']['modified'])),
	
);

$page_options = array(
	$this->Html->link(__('Edit'), array('action' => 'edit', $fw_interface['FwInterface']['id'])),
	$this->Form->postLink(__('Delete'),array('action' => 'delete', $fw_interface['FwInterface']['id']),array('confirm' => 'Are you sure?')),
);


$stats = array(
	array(
		'id' => 'rules',
		'name' => __('Rules'), 
		'value' => $fw_interface['FwInterface']['counts']['Rule.all'], 
		'tab' => array('tabs', '1'), // the tab to display
	),
);


$tabs = array(
	array(
		'key' => 'rules',
		'title' => __('Rules'),
		'url' => array('controller' => 'rules', 'action' => 'fw_interface', $fw_interface['FwInterface']['id'], 'admin' => true),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Interface'). ': '. $fw_interface['FwInterface']['name'],
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>