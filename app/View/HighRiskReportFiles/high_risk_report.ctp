<?php 
// File: app/View/HighRiskReportFiles/high_risk_report.ctp

$page_options = array(
	$this->Html->link(__('Add %s ', __('%s %s', __('High Risk Report'), __('File'))), array('action' => 'add', $high_risk_report['HighRiskReport']['id'])),
);

// content
$th = array(
	'HighRiskReportFile.filename' => array('content' => __('Filename'), 'options' => array('sort' => 'HighRiskReportFile.filename')),
	'HighRiskReportFile.nicename' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'HighRiskReportFile.nicename')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($high_risk_report_files as $i => $high_risk_report_file)
{
	$actions = array(
		$this->Html->link(__('Download'), array('action' => 'download', $high_risk_report_file['HighRiskReportFile']['id'])),
		$this->Html->link(__('Edit'), array('action' => 'edit', $high_risk_report_file['HighRiskReportFile']['id'], )),
		$this->Html->link(__('Delete'), array('action' => 'delete', $high_risk_report_file['HighRiskReportFile']['id'], ), array('confirm' => 'Are you sure?'))
	);
	
	$actions = implode('', $actions);
	
	$td[$i] = array(
		$this->Html->link($high_risk_report_file['HighRiskReportFile']['filename'], array('action' => 'download', $high_risk_report_file['HighRiskReportFile']['id'])),
		$high_risk_report_file['HighRiskReportFile']['nicename'],
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('%s %s', __('High Risk Report'), __('Files'))),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));