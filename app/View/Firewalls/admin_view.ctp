<?php 
// File: app/View/Firewalls/admin_view.ctp

$details = array(
	array('name' => __('Slug'), 'value' => $firewall['Firewall']['slug']),
	array('name' => __('Hostname'), 'value' => $firewall['Firewall']['hostname']),
	array('name' => __('Domain Name'), 'value' => $firewall['Firewall']['domain_name']),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($firewall['Firewall']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($firewall['Firewall']['modified'])),
	
);

$page_options = array(
	$this->Html->link(__('Edit'), array('action' => 'edit', $firewall['Firewall']['id'])),
	$this->Form->postLink(__('Delete'),array('action' => 'delete', $firewall['Firewall']['id']),array('confirm' => 'Are you sure?')),
);


$stats = array(
	array(
		'id' => 'rules',
		'name' => __('Rules'), 
		'value' => $firewall['Firewall']['counts']['Rule.all'], 
		'tab' => array('tabs', '1'), // the tab to display
	),
);


$tabs = array(
	array(
		'key' => 'rules',
		'title' => __('Rules'),
		'url' => array('controller' => 'rules', 'action' => 'firewall', $firewall['Firewall']['id'], 'admin' => true),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Firewall'). ': '. $firewall['Firewall']['name'],
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>