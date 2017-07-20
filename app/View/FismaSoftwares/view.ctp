<?php 
// File: app/View/FismaSoftwares/view.ctp
$page_options = array(
	
);

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_software['FismaSoftware']['id'], 'saa' => true));
}

$details = array(
	array('name' => __('Version'), 'value' => $fisma_software['FismaSoftware']['version']),
	array('name' => __('Attachment'), 'value' => $this->Html->link($fisma_software['FismaSoftware']['filename'], array('action' => 'download', $fisma_software['FismaSoftware']['id']))),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fisma_software['FismaSoftware']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fisma_software['FismaSoftware']['modified'])),
);

$stats = array();
$tabs = array();

$stats[] = array(
	'id' => 'item_state_all',
	'name' => __('Associated %s', __('Systems')), 
	'ajax_count_url' => array('controller' => 'fisma_softwares_fisma_systems', 'action' => 'fisma_software', $fisma_software['FismaSoftware']['id']),
	'tab' => array('tabs', (count($tabs) + 1)), // the tab to display
);

$tabs[] = array(
	'key' => 'ManageItems',
	'title' => __('Associated %s', __('Systems')), 
	'url' => array('controller' => 'fisma_softwares_fisma_systems', 'action' => 'fisma_software', $fisma_software['FismaSoftware']['id']),
);

$stats[] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'fisma_software', $fisma_software['FismaSoftware']['id']),
	'tab' => array('tabs', (count($tabs) + 1)), // the tab to display
);

$tabs[] = array(
	'key' => 'pen_test_results',
	'title' => __('Pen Test Results'), 
	'url' => array('controller' => 'pen_test_results', 'action' => 'fisma_software', $fisma_software['FismaSoftware']['id']),
);

$tabs[] = array(
	'key' => 'notes',
	'title' => __('Notes'),
	'content' => $this->Wrap->descView($fisma_software['FismaSoftware']['notes']),
);

$stats[] = array(
	'id' => 'tagsReport',
	'name' => __('Tags'), 
	'ajax_count_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'fisma_software', $fisma_software['FismaSoftware']['id']),
	'tab' => array('tabs', (count($tabs) + 1)), // the tab to display
);	
$tabs[] = array(
	'key' => 'tags',
	'title' => __('Tags'),
	'url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'fisma_software', $fisma_software['FismaSoftware']['id']),
);


echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s', __('Whitelisted Software'), $fisma_software['FismaSoftware']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));