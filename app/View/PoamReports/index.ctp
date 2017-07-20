<?php 

$page_options = array();

if($this->Wrap->roleCheck(array('saa', 'admin')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('POA&M Report')), array('action' => 'add', 'saa' => true));
}

// content
$th = array(
	'PoamReport.name' => array('content' => __('Name'), 'options' => array('sort' => 'PoamReport.name', 'editable' => array('type' => 'text'))),
	'PoamReport.result_count' => array('content' => __('# %s', __('POA&M Results'))),
	'PoamReport.report_date' => array('content' => __('Report Date'), 'options' => array('sort' => 'PoamReport.report_date', 'editable' => array('type' => 'date'))),
	'PoamReport.created' => array('content' => __('Created'), 'options' => array('sort' => 'PoamReport.created')),
	'PoamReport.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'PoamReport.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
); 

$td = array();
foreach ($poamReports as $i => $poamReport)
{
	$edit_id = array(
		'PoamReport' => $poamReport['PoamReport']['id'],
	);
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $poamReport['PoamReport']['id'], 'admin' => false)),
	);
	if($this->Wrap->roleCheck(array('saa', 'admin')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $poamReport['PoamReport']['id'], 'saa' => true));
	}
	if($this->Wrap->roleCheck(array('admin')))
	{
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $poamReport['PoamReport']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$report_date_value = false;
	if(strtotime($poamReport['PoamReport']['report_date']))
	{
		$report_date_value = date('Y-m-d 00:00:00', strtotime($poamReport['PoamReport']['report_date']));
	}
	if(!$report_date_value)
	{
		$report_name = trim($poamReport['PoamReport']['name']);
		$matches = array();
		if(preg_match('/^(\d+)\-(\d+)\-(\d+)$/', $report_name, $matches))
		{
			$report_date_value = __('%s-%s-%s 00:00:00', $matches[3], $matches[1], $matches[2]);
		}
	}
	
	$td[$i] = array(
		$this->Html->link($poamReport['PoamReport']['name'], array('action' => 'view', $poamReport['PoamReport']['id'])),
		array('.', array(
			'ajax_count_url' => array('controller' => 'poamResults', 'action' => 'poam_report', $poamReport['PoamReport']['id']),
			'url' => array('action' => 'view', $poamReport['PoamReport']['id'], 'tab' => 'results'),
		)),
		array(
			$this->Wrap->niceDay($poamReport['PoamReport']['report_date']),
			array('value' => $report_date_value),
		),
		$this->Wrap->niceTime($poamReport['PoamReport']['created']),
		$this->Wrap->niceTime($poamReport['PoamReport']['modified']),
		array(
			$actions,
			array('class' => 'actions'),
		),
		'edit_id' => $edit_id,
	);
}

$use_gridedit = false;
if($this->Wrap->roleCheck(array('saa', 'admin')))
	$use_gridedit = true;

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POA&M Reports'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'search_placeholder' => __('POA&M Reports'),
	'use_gridedit' => $use_gridedit,
));