<?php 
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options['dashboard'] = $this->Html->link(__('View in Dashboard'), array('controller' => 'us_results', 'action' => 'dashboard', $us_report['UsReport']['id'], 'admin' => false));
	$page_options['edit'] = $this->Html->link(__('Edit'), array('action' => 'edit', $us_report['UsReport']['id'], 'admin' => true));
	$page_options['delete'] = $this->Html->link(__('Delete'), array('action' => 'delete', $us_report['UsReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
}

$details = array(
	array('name' => __('Attachment'), 'value' => $this->Html->link($us_report['UsReport']['filename'], array('action' => 'download', $us_report['UsReport']['id']))),
	array('name' => __('Report Date'), 'value' => $this->Wrap->niceDay($us_report['UsReport']['report_date'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($us_report['UsReport']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($us_report['UsReport']['modified'])),
);

$stats = array();
$tabs = array();

$tabs['results'] = $stats['results'] = array(
	'id' => 'results',
	'name' => __('Results'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'us_report', $us_report['UsReport']['id'], 'admin' => false),
);
$tabs['results_added'] = $stats['results_added'] = array(
	'id' => 'results_added',
	'name' => __('Results Added'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'us_report_added', $us_report['UsReport']['id'], 'admin' => false),
);
$tabs['results_removed'] = $stats['results_removed'] = array(
	'id' => 'results_removed',
	'name' => __('Results Removed'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'us_report_removed', $us_report['UsReport']['id'], 'admin' => false),
);
$tabs['attachements'] = $stats['attachements'] = array(
	'id' => 'attachements',
	'name' => __('Attachements'), 
	'ajax_url' => array('controller' => 'us_report_files', 'action' => 'us_report', $us_report['UsReport']['id']),
);
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($us_report['UsReport']['notes']),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'us_report', $us_report['UsReport']['id']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s', __('US Report'), $us_report['UsReport']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));