<?php 
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $poamReport['PoamReport']['id'], 'admin' => true));
	$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $poamReport['PoamReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
}

$details = array(
	array('name' => __('Attachment'), 'value' => $this->Html->link($poamReport['PoamReport']['filename'], array('action' => 'download', $poamReport['PoamReport']['id']))),
	array('name' => __('Report Date'), 'value' => $this->Wrap->niceDay($poamReport['PoamReport']['report_date'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($poamReport['PoamReport']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($poamReport['PoamReport']['modified'])),
);

$stats = array();
$tabs = array();

$tabs['results'] = $stats['results'] = array(
	'id' => 'results',
	'name' => __('Results'), 
	'ajax_url' => array('controller' => 'poamResults', 'action' => 'poam_report', $poamReport['PoamReport']['id'], 'admin' => false),
);
$tabs['attachements'] = $stats['attachements'] = array(
	'id' => 'attachements',
	'name' => __('Attachements'), 
	'ajax_url' => array('controller' => 'poam_report_files', 'action' => 'poam_report', $poamReport['PoamReport']['id']),
);
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($poamReport['PoamReport']['notes']),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'poam_report', $poamReport['PoamReport']['id']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s', __('POA&M Report'), $poamReport['PoamReport']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));