<?php 
// File: app/View/Fogs/view.ctp

$details = array(
	array('name' => __('Slug'), 'value' => $fog['Fog']['slug']),
	array('name' => __('On Simple Form?'), 'value' => $this->Local->simpleLink($fog['Fog']['simple'])),
	array('name' => __('Imported From'), 'value' => $fog['Import']['name']. ' ('. $fog['Import']['filename']. ')'),
	array('name' => __('Description'), 'value' => $fog['Fog']['description']),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fog['Fog']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fog['Fog']['modified'])),
);
		
$page_options = array(
	$this->Html->link(__('Edit'), array('action' => 'edit', $fog['Fog']['id'])),
	$this->Form->postLink(__('Delete'),array('action' => 'delete', $fog['Fog']['id']),array('confirm' => 'Are you sure?')),
);

(int) $cnt_src_rule = (isset($fog['Fog']['counts']['SrcRule.all'])?$fog['Fog']['counts']['SrcRule.all']:0);
(int) $cnt_dst_rule = (isset($fog['Fog']['counts']['DstRule.all'])?$fog['Fog']['counts']['DstRule.all']:0);

$stats = array(
	array(
		'id' => 'trules',
		'name' => __('Total Rules'), 
		'value' => ($cnt_src_rule + $cnt_dst_rule), 
		'tab' => array('tabs', '1'), // the tab to display
	),
	array(
		'id' => 'srules',
		'name' => __('Source Rules'), 
		'value' => $cnt_src_rule, 
		'tab' => array('tabs', '1'), // the tab to display
	),
	array(
		'id' => 'drules',
		'name' => __('Destination Rules'), 
		'value' => $cnt_dst_rule, 
		'tab' => array('tabs', '1'), // the tab to display
	),
	array(
		'id' => 'parents',
		'name' => __('Parents'), 
		'value' => $fog['Fog']['counts']['FogsParent.all'], 
		'tab' => array('tabs', '2'), // the tab to display
	),
	array(
		'id' => 'children',
		'name' => __('Children'), 
		'value' => $fog['Fog']['counts']['FogsChild.all'], 
		'tab' => array('tabs', '3'), // the tab to display
	),
	array(
		'id' => 'changes',
		'name' => __('Changes'), 
		'value' => $fog['Fog']['counts']['FogLog.all'], 
		'tab' => array('tabs', '4'), // the tab to display
	),
);

$tabs = array(
	array(
		'key' => 'ip_addresses',
		'title' => __('Current IP Addresses'),
		'content' => $this->Wrap->descView($fog['Fog']['ip_addresses']),
	),
	array(
		'key' => 'rules',
		'title' => __('Rules'),
		'url' => array('controller' => 'rules', 'action' => 'fog', $fog['Fog']['id']),
	),
	array(
		'key' => 'parents',
		'title' => __('Parents'),
		'url' => array('controller' => 'fogs', 'action' => 'parents', $fog['Fog']['id']),
	),
	array(
		'key' => 'children',
		'title' => __('Children'),
		'url' => array('controller' => 'fogs', 'action' => 'children', $fog['Fog']['id']),
	),
	array(
		'key' => 'changes',
		'title' => __('Change Log'),
		'url' => array('controller' => 'fog_logs', 'action' => 'fog', $fog['Fog']['id']),
	),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s: %s', __('Firewall Object Group'), $fog['Fog']['name']),
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>