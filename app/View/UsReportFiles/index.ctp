<?php 
// File: app/View/UsReportFiles/index.ctp

$page_options = array();

// content
$th = array(
	'UsReport.name' => array('content' => __('US Report'), 'options' => array('sort' => 'UsReport.name')),
	'UsReportFile.filename' => array('content' => __('Filename'), 'options' => array('sort' => 'UsReportFile.filename')),
	'UsReportFile.nicename' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'UsReportFile.nicename')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($us_report_files as $i => $us_report_file)
{
	$actions = array(
		$this->Html->link(__('Download'), array('action' => 'download', $us_report_file['UsReportFile']['id'])),
		$this->Html->link(__('Edit'), array('action' => 'edit', $us_report_file['UsReportFile']['id'], )),
		$this->Html->link(__('Delete'), array('action' => 'delete', $us_report_file['UsReportFile']['id'], ), array('confirm' => 'Are you sure?'))
	);
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($us_report_file['UsReport']['name'], array('action' => 'view', $us_report_file['UsReport']['id'])),
		$this->Html->link($us_report_file['UsReportFile']['filename'], array('action' => 'download', $us_report_file['UsReportFile']['id'])),
		$us_report_file['UsReportFile']['nicename'],
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('%s %s', __('US Report'), __('Files'))),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));