<?php 

$th = array();
$th['UsResult.eol_software_id'] = array('content' => __('EOL/US Software'), 'options' => array('sort' => 'EolSoftware.name'));
$th['UsResult.ip_address'] = array('content' => __('Ip Address'), 'options' => array('sort' => 'UsResult.ip_address'));
$th['UsResult.host_name'] = array('content' => __('Host Name'), 'options' => array('sort' => 'UsResult.host_name'));
$th['UsResult.resolved_by_date'] = array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'UsResult.resolved_by_date'));
$th['UsResult.tickets'] = array('content' => __('Tickets'), 'options' => array('sort' => 'UsResult.tickets'));
$th['UsResult.waiver'] = array('content' => __('Waiver'), 'options' => array('sort' => 'UsResult.waiver'));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($us_results as $i => $us_result)
{
	
	$highlightDueDate = false;
	if(isset($us_result['UsResult']['resolved_by_date']) 
		and isset($us_result['ReportsStatus']['name'])
		and $this->Common->slugify($us_result['ReportsStatus']['name']) == 'open')
	{
		if($us_result['UsResult']['resolved_by_date'] == '0000-00-00 00:00:00')
			$us_result['UsResult']['resolved_by_date'] = false;
		$resolvedByDate = strtotime($us_result['UsResult']['resolved_by_date']);
		if($resolvedByDate)
		{
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
	}
	
	$td[$i] = array();
	$td[$i]['UsResult.eol_software_id'] = $us_result['EolSoftware']['name'];
	$td[$i]['UsResult.ip_address'] = $us_result['UsResult']['ip_address'];
	$td[$i]['UsResult.host_name'] = $us_result['UsResult']['host_name'];
	$td[$i]['UsResult.resolved_by_date'] = array($this->Wrap->niceDay($us_result['UsResult']['resolved_by_date']), array('class' => $highlightDueDate));
	$td[$i]['UsResult.tickets'] = $us_result['UsResult']['tickets'];
	$td[$i]['UsResult.waiver'] = $us_result['UsResult']['waiver'];
}

if(count($us_results))
{
	echo $this->Html->divClear();
	echo $this->Html->tag('h3', __('OPEN Unsupported Software (US) Results'));
	echo $this->Html->tag('h4', __('Count: %s', count($us_results)));
	echo $this->element('Utilities.table', array(
		'th' => $th,
		'td' => $td,
		'table_stripped' => true,
		'table_widget_options' => array(
			'setup' => "
				self.element.find('td.highlight-red').parent().addClass('highlight-red');
				self.element.find('td.highlight-yellow').parent().addClass('highlight-yellow');
			"
		),
	));
	echo $this->Html->divClear();
}