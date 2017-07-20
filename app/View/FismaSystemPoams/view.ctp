<?php 
// File: app/View/FismaSystemPoamPoams/view.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_poam['FismaSystemPoam']['id'], 'saa' => true));
}

$details_blocks = array(
);

$details_blocks[1][1] = array(
	'title' => __('Details'),
	'details' => array(
		array('name' => __('FISMA System'), 'value' => $this->Html->link($fisma_system_poam['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_poam['FismaSystem']['id']))),
		array('name' => __('Weakness ID'), 'value' => $fisma_system_poam['FismaSystemPoam']['weakness_id']),
		array('name' => __('Controls'), 'value' => $fisma_system_poam['FismaSystemPoam']['controls']),
		array('name' => __('Completion Status'), 'value' => $fisma_system_poam['FismaSystemPoamCompletionStatus']['name']),
		array('name' => __('Closed?'), 'value' => $this->Wrap->yesNo($fisma_system_poam['FismaSystemPoam']['closed'])),
	),
);

$details_blocks[1][2] = array(
	'title' => __('Contacts'),
	'details' => array(
		array('name' => __('Scheduled Completion'), 'value' => $this->Wrap->niceTime($fisma_system_poam['FismaSystemPoam']['scheduled_completion'])),
		array('name' => __('Created By'), 'value' => $this->Html->link($fisma_system_poam['AddedUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_system_poam['AddedUser']['id']))),
		array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fisma_system_poam['FismaSystemPoam']['created'])),
		array('name' => __('Modified By'), 'value' => $this->Html->link($fisma_system_poam['ModifiedUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_system_poam['ModifiedUser']['id']))),
		array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fisma_system_poam['FismaSystemPoam']['modified'])),
	),
);

$details_blocks[2][1] = array(
	'title' => $this->Html->tag('h3', __('Weakness')),
	'content' => $this->Wrap->descView($fisma_system_poam['FismaSystemPoam']['weakness'], false),
);

$details_blocks[2][2] = array(
	'title' => $this->Html->tag('h3', __('Solution')),
	'content' => $this->Wrap->descView($fisma_system_poam['FismaSystemPoam']['solution'], false),
);

$stats = array();
$tabs = array();

$stats[] = array(
	'id' => 'fisma_system_poams_status_logs',
	'name' => __('Status Logs'), 
	'ajax_count_url' => array('controller' => 'fisma_system_poam_status_logs', 'action' => 'fisma_system_poam', $fisma_system_poam['FismaSystemPoam']['id']),
	'tab' => array('tabs', (count($tabs) + 1)), // the tab to display
);

$tabs[] = array(
	'key' => 'fisma_system_poams_status_logs',
	'title' => __('Status Logs'), 
	'url' => array('controller' => 'fisma_system_poam_status_logs', 'action' => 'fisma_system_poam', $fisma_system_poam['FismaSystemPoam']['id']),
);	

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('%s: %s', __('FISMA System POAM'), $fisma_system_poam['FismaSystemPoam']['weakness_id']),
	'page_options' => $page_options,
	'stats' => $stats,
	'details_blocks' => $details_blocks,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));