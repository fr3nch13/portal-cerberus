<?php 
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $high_risk_report['HighRiskReport']['id'], 'admin' => true));
	$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $high_risk_report['HighRiskReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
}

$details = array(
	array('name' => __('Attachment'), 'value' => $this->Html->link($high_risk_report['HighRiskReport']['filename'], array('action' => 'download', $high_risk_report['HighRiskReport']['id']))),
	array('name' => __('Report Date'), 'value' => $this->Wrap->niceDay($high_risk_report['HighRiskReport']['report_date'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($high_risk_report['HighRiskReport']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($high_risk_report['HighRiskReport']['modified'])),
);

$stats = array();
$tabs = array();

$tabs['results'] = $stats['results'] = array(
	'id' => 'results',
	'name' => __('Results'), 
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'high_risk_report', $high_risk_report['HighRiskReport']['id']),
);
$tabs['attachments'] = $stats['attachments'] = array(
	'id' => 'attachments',
	'name' => __('Attachements'), 
	'ajax_url' => array('controller' => 'high_risk_report_files', 'action' => 'high_risk_report', $high_risk_report['HighRiskReport']['id']),
);
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->Wrap->descView($high_risk_report['HighRiskReport']['notes']),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'high_risk_report', $high_risk_report['HighRiskReport']['id']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s', __('High Risk Report'), $high_risk_report['HighRiskReport']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));