<?php 
// File: app/View/Pogs/view.ctp

$details = array(
	array('name' => __('Slug'), 'value' => $pog['Pog']['slug']),
	array('name' => __('On Simple Form?'), 'value' => $this->Local->simpleLink($pog['Pog']['simple'])),
	array('name' => __('Imported From'), 'value' => $pog['Import']['name']. ' ('. $pog['Import']['filename']. ')'),
	array('name' => __('Description'), 'value' => $pog['Pog']['description']),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($pog['Pog']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($pog['Pog']['modified'])),
);
		
$page_options = array(
	$this->Html->link(__('Edit'), array('action' => 'edit', $pog['Pog']['id'])),
	$this->Form->postLink(__('Delete'),array('action' => 'delete', $fog['Fog']['id']),array('confirm' => 'Are you sure?')),
);

(int) $cnt_src_rule = (isset($pog['Pog']['counts']['SrcRule.all'])?$pog['Pog']['counts']['SrcRule.all']:0);
(int) $cnt_dst_rule = (isset($pog['Pog']['counts']['DstRule.all'])?$pog['Pog']['counts']['DstRule.all']:0);

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
		'value' => $pog['Pog']['counts']['PogsPog.parents'], 
		'tab' => array('tabs', '2'), // the tab to display
	),
	array(
		'id' => 'children',
		'name' => __('Children'), 
		'value' => $pog['Pog']['counts']['PogsPog.children'], 
		'tab' => array('tabs', '3'), // the tab to display
	),
	array(
		'id' => 'changes',
		'name' => __('Changes'), 
		'value' => $pog['Pog']['counts']['PogLog.all'], 
		'tab' => array('tabs', '4'), // the tab to display
	),
);

$tabs = array(
	array(
		'key' => 'ports',
		'title' => __('Current Ports'),
		'content' => $this->Wrap->descView($pog['Pog']['ports']),
	),
	array(
		'key' => 'rules',
		'title' => __('Rules'),
		'url' => array('controller' => 'rules', 'action' => 'pog', $pog['Pog']['id']),
	),
	array(
		'key' => 'parents',
		'title' => __('Parents'),
		'url' => array('controller' => 'pogs', 'action' => 'parents', $pog['Pog']['id']),
	),
	array(
		'key' => 'children',
		'title' => __('Children'),
		'url' => array('controller' => 'pogs', 'action' => 'children', $pog['Pog']['id']),
	),
	array(
		'key' => 'changes',
		'title' => __('Change Log'),
		'url' => array('controller' => 'pog_logs', 'action' => 'pog', $pog['Pog']['id']),
	),
);
echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s: %s', __('Port Object Group'), $pog['Pog']['name']),
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>