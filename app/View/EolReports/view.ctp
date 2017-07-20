<?php 
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $eol_report['EolReport']['id'], 'admin' => true));
	$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $eol_report['EolReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
}

$details = array(
	array('name' => __('Attachment'), 'value' => $this->Html->link($eol_report['EolReport']['filename'], array('action' => 'download', $eol_report['EolReport']['id']))),
	array('name' => __('Report Date'), 'value' => $this->Wrap->niceDay($eol_report['EolReport']['report_date'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($eol_report['EolReport']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($eol_report['EolReport']['modified'])),
);

$stats = array();
$tabs = array();

$tabs['results'] = $stats['results'] = array(
	'id' => 'results',
	'name' => __('Results'), 
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'eol_report', $eol_report['EolReport']['id']),
);
$tabs['attachements'] = $stats['attachements'] = array(
	'id' => 'attachements',
	'name' => __('Attachements'), 
	'ajax_url' => array('controller' => 'eol_report_files', 'action' => 'eol_report', $eol_report['EolReport']['id']),
);
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($eol_report['EolReport']['notes']),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'eol_report', $eol_report['EolReport']['id']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s', __('EOL Report'), $eol_report['EolReport']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));