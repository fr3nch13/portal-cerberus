<?php 
// File: app/View/EolReports/index.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('EOL Report')), array('action' => 'add', 'admin' => true));
}

// content
$th = array(
	'EolReport.name' => array('content' => __('Name'), 'options' => array('sort' => 'EolReport.name', 'editable' => array('type' => 'text'))),
	'EolReport.result_count' => array('content' => __('# %s', __('EOL Results'))),
	'EolReport.report_date' => array('content' => __('Report Date'), 'options' => array('sort' => 'EolReport.report_date', 'editable' => array('type' => 'date'))),
	'EolReport.created' => array('content' => __('Created'), 'options' => array('sort' => 'EolReport.created')),
	'EolReport.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'EolReport.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($eol_reports as $i => $eol_report)
{
	$edit_id = array(
		'EolReport' => $eol_report['EolReport']['id'],
	);
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $eol_report['EolReport']['id'], 'admin' => false)),
	);
	if($this->Wrap->roleCheck(array('admin')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $eol_report['EolReport']['id'], 'admin' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $eol_report['EolReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$report_date_value = false;
	if(strtotime($eol_report['EolReport']['report_date']))
	{
		$report_date_value = date('Y-m-d 00:00:00', strtotime($eol_report['EolReport']['report_date']));
	}
	if(!$report_date_value)
	{
		$report_name = trim($eol_report['EolReport']['name']);
		$matches = array();
		if(preg_match('/^(\d+)\-(\d+)\-(\d+)$/', $report_name, $matches))
		{
			$report_date_value = __('%s-%s-%s 00:00:00', $matches[3], $matches[1], $matches[2]);
		}
	}
	
	$td[$i] = array(
		$this->Html->link($eol_report['EolReport']['name'], array('action' => 'view', $eol_report['EolReport']['id'])),
		array('.', array(
			'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'eol_report', $eol_report['EolReport']['id']),
			'url' => array('action' => 'view', $eol_report['EolReport']['id'], 'tab' => 'EolResults'),
		)),
		array(
			$this->Wrap->niceDay($eol_report['EolReport']['report_date']),
			array('value' => $report_date_value),
		),
		$this->Wrap->niceTime($eol_report['EolReport']['created']),
		$this->Wrap->niceTime($eol_report['EolReport']['modified']),
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
	'page_title' => __('EOL Reports'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
));