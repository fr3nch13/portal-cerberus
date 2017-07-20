<?php 
// File: app/View/EolReportFiles/eol_report.ctp

$page_options = array(
	$this->Html->link(__('Add %s ', __('%s %s', __('EOL Report'), __('File'))), array('action' => 'add', $eol_report['EolReport']['id'])),
);

// content
$th = array(
	'EolReportFile.filename' => array('content' => __('Filename'), 'options' => array('sort' => 'EolReportFile.filename')),
	'EolReportFile.nicename' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'EolReportFile.nicename')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($eol_report_files as $i => $eol_report_file)
{
	$actions = array(
		$this->Html->link(__('Download'), array('action' => 'download', $eol_report_file['EolReportFile']['id'])),
		$this->Html->link(__('Edit'), array('action' => 'edit', $eol_report_file['EolReportFile']['id'], )),
		$this->Html->link(__('Delete'), array('action' => 'delete', $eol_report_file['EolReportFile']['id'], ), array('confirm' => 'Are you sure?'))
	);
	
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($eol_report_file['EolReportFile']['filename'], array('action' => 'download', $eol_report_file['EolReportFile']['id'])),
		$eol_report_file['EolReportFile']['nicename'],
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('%s %s', __('EOL Report'), __('Files'))),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));