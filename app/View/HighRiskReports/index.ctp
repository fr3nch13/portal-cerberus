<?php 
// File: app/View/HighRiskReports/index.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('High Risk Report')), array('action' => 'add', 'admin' => true));
}

// content
$th = array(
	'HighRiskReport.name' => array('content' => __('Name'), 'options' => array('sort' => 'HighRiskReport.name', 'editable' => array('type' => 'text'))),
	'HighRiskReport.result_count' => array('content' => __('# %s', __('High Risk Results'))),
	'HighRiskReport.report_date' => array('content' => __('Report Date'), 'options' => array('sort' => 'HighRiskReport.report_date', 'editable' => array('type' => 'date'))),
	'HighRiskReport.created' => array('content' => __('Created'), 'options' => array('sort' => 'HighRiskReport.created')),
	'HighRiskReport.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'HighRiskReport.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($high_risk_reports as $i => $high_risk_report)
{
	$edit_id = array(
		'HighRiskReport' => $high_risk_report['HighRiskReport']['id'],
	);
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $high_risk_report['HighRiskReport']['id'], 'admin' => false)),
	);
	if($this->Wrap->roleCheck(array('admin')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $high_risk_report['HighRiskReport']['id'], 'admin' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $high_risk_report['HighRiskReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$report_date_value = false;
	if(strtotime($high_risk_report['HighRiskReport']['report_date']))
	{
		$report_date_value = date('Y-m-d 00:00:00', strtotime($high_risk_report['HighRiskReport']['report_date']));
	}
	if(!$report_date_value)
	{
		$report_name = trim($high_risk_report['HighRiskReport']['name']);
		$matches = array();
		if(preg_match('/^(\d+)\-(\d+)\-(\d+)$/', $report_name, $matches))
		{
			$report_date_value = __('%s-%s-%s 00:00:00', $matches[3], $matches[1], $matches[2]);
		}
	}
	
	$td[$i] = array(
		$this->Html->link($high_risk_report['HighRiskReport']['name'], array('action' => 'view', $high_risk_report['HighRiskReport']['id'])),
		array('.', array(
			'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'high_risk_report', $high_risk_report['HighRiskReport']['id']),
			'url' => array('action' => 'view', $high_risk_report['HighRiskReport']['id'], 'tab' => 'results'),
		)),
		array(
			$this->Wrap->niceDay($high_risk_report['HighRiskReport']['report_date']),
			array('value' => $report_date_value),
		),
		$this->Wrap->niceTime($high_risk_report['HighRiskReport']['created']),
		$this->Wrap->niceTime($high_risk_report['HighRiskReport']['modified']),
		array(
			$actions,
			array('class' => 'actions'),
		),
		'edit_id' => $edit_id,
	);
}

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin')))
	$use_gridedit = true;

echo $this->element('Utilities.page_index', array(
	'page_title' => __('High Risk Reports'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
));