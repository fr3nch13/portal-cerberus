<?php 

$page_options = array(
	$this->Html->link(__('Add %s ', __('%s %s', __('POA&M Report'), __('File'))), array('action' => 'add', $poamReport['PoamReport']['id'])),
);

// content
$th = array(
	'PoamReportFile.filename' => array('content' => __('Filename'), 'options' => array('sort' => 'PoamReportFile.filename')),
	'PoamReportFile.nicename' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'PoamReportFile.nicename')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($poamReportFiles as $i => $poamReportFile)
{
	$actions = array(
		$this->Html->link(__('Download'), array('action' => 'download', $poamReportFile['PoamReportFile']['id'])),
		$this->Html->link(__('Edit'), array('action' => 'edit', $poamReportFile['PoamReportFile']['id'], )),
		$this->Html->link(__('Delete'), array('action' => 'delete', $poamReportFile['PoamReportFile']['id'], ), array('confirm' => 'Are you sure?'))
	);
	
	$actions = implode('', $actions);
	
	$td[$i] = array(
		$this->Html->link($poamReportFile['PoamReportFile']['filename'], array('action' => 'download', $poamReportFile['PoamReportFile']['id'])),
		$poamReportFile['PoamReportFile']['nicename'],
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('%s %s', __('POA&M Report'), __('Files'))),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));