<?php 

$page_options = array();

// content
$th = array(
	'PoamReport.name' => array('content' => __('POA&M Report'), 'options' => array('sort' => 'PoamReport.name')),
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
		$this->Html->link($poamReportFile['PoamReport']['name'], array('action' => 'view', $poamReportFile['PoamReport']['id'])),
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
	'search_placeholder' => __('POA&M Report Files'),
));