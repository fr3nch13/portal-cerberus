<?php 
// File: app/View/UsReports/index.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('US Report')), array('action' => 'add', 'admin' => true));
}

// content
$th = array(
	'UsReport.name' => array('content' => __('Name'), 'options' => array('sort' => 'UsReport.name', 'editable' => array('type' => 'text'))),
	'UsReport.result_count' => array('content' => __('# %s', __('US Results'))),
	'UsReport.report_date' => array('content' => __('Report Date'), 'options' => array('sort' => 'UsReport.report_date', 'editable' => array('type' => 'date'))),
	'UsReport.created' => array('content' => __('Created'), 'options' => array('sort' => 'UsReport.created')),
	'UsReport.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'UsReport.modified')),
	'UsReport.queued_task_id' => array('content' => __('Queue'), 'options' => array('sort' => 'UsReport.queued_task_id')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($us_reports as $i => $us_report)
{
	$edit_id = array(
		'UsReport' => $us_report['UsReport']['id'],
	);
	$actions = array(
		$this->Html->link(__('DB'), array('controller' => 'us_results', 'action' => 'dashboard', $us_report['UsReport']['id'], 'admin' => false)),
		$this->Html->link(__('View'), array('action' => 'view', $us_report['UsReport']['id'], 'admin' => false)),
	);
	if($this->Wrap->roleCheck(array('admin')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $us_report['UsReport']['id'], 'admin' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $us_report['UsReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$report_date_value = false;
	if(strtotime($us_report['UsReport']['report_date']))
	{
		$report_date_value = date('Y-m-d 00:00:00', strtotime($us_report['UsReport']['report_date']));
	}
	if(!$report_date_value)
	{
		$report_name = trim($us_report['UsReport']['name']);
		$matches = array();
		if(preg_match('/^(\d+)\-(\d+)\-(\d+)$/', $report_name, $matches))
		{
			$report_date_value = __('%s-%s-%s 00:00:00', $matches[3], $matches[1], $matches[2]);
		}
	}
	
	$td[$i] = array(
		$this->Html->link($us_report['UsReport']['name'], array('action' => 'view', $us_report['UsReport']['id'])),
		array('.', array(
			'ajax_count_url' => array('controller' => 'us_results', 'action' => 'us_report', $us_report['UsReport']['id']),
			'url' => array('action' => 'view', $us_report['UsReport']['id'], 'tab' => 'results'),
		)),
		array(
			$this->Wrap->niceDay($us_report['UsReport']['report_date']),
			array('value' => $report_date_value),
		),
		$this->Wrap->niceTime($us_report['UsReport']['created']),
		$this->Wrap->niceTime($us_report['UsReport']['modified']),
		$this->Queue->progressBar($us_report['UsReport']['queued_task_id']),
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
	'page_title' => __('US Reports'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
//	'auto_load_ajax' => (isset($auto_load_ajax)?$auto_load_ajax:false),
));