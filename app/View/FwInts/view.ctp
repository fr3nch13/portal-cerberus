<?php 
// File: app/View/FwInts/admin_view.ctp

$details = array(
	array('name' => __('Firewall'), 'value' => $this->Html->link($fw_int['Firewall']['name'], array('controller' => 'firewalls', 'action' => 'view', $fw_int['Firewall']['id']))),
	array('name' => __('Interface'), 'value' => $this->Html->link($fw_int['FwInterface']['name'], array('controller' => 'fw_interfaces', 'action' => 'view', $fw_int['FwInterface']['id']))),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fw_int['FwInt']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fw_int['FwInt']['modified'])),
	
);

$page_options = array(
);


$stats = array(
	array(
		'id' => 'rules',
		'name' => __('Rules'), 
		'value' => $fw_int['FwInt']['counts']['Rule.all'], 
		'tab' => array('tabs', '1'), // the tab to display
	),
);


$tabs = array(
	array(
		'key' => 'rules',
		'title' => __('Rules'),
		'url' => array('controller' => 'rules', 'action' => 'fw_int', $fw_int['FwInt']['id']),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Firewall Path'). ': '. $fw_int['FwInt']['name'],
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>