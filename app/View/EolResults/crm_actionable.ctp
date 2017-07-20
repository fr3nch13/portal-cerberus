<?php 

$th = array();
$th['EolResult.eol_software_id'] = array('content' => __('Software'), 'options' => array('sort' => 'EolSoftware.name'));
$th['EolResult.ip_address'] = array('content' => __('Ip Address'), 'options' => array('sort' => 'EolResult.ip_address'));
$th['EolResult.host_name'] = array('content' => __('Host Name'), 'options' => array('sort' => 'EolResult.host_name'));
$th['EolResult.resolved_by_date'] = array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'EolResult.resolved_by_date'));
$th['EolResult.tickets'] = array('content' => __('Tickets'), 'options' => array('sort' => 'EolResult.tickets'));
$th['EolResult.waiver'] = array('content' => __('Waiver'), 'options' => array('sort' => 'EolResult.waiver'));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($eol_results as $i => $eol_result)
{
	
	$highlightDueDate = false;
	if(isset($eol_result['EolResult']['resolved_by_date']) 
		and isset($eol_result['ReportsStatus']['name'])
		and $this->Common->slugify($eol_result['ReportsStatus']['name']) == 'open')
	{
		if($eol_result['EolResult']['resolved_by_date'] == '0000-00-00 00:00:00')
			$eol_result['EolResult']['resolved_by_date'] = false;
		$resolvedByDate = strtotime($eol_result['EolResult']['resolved_by_date']);
		if($resolvedByDate)
		{
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
	}
	
	$td[$i] = array();
	$td[$i]['EolResult.eol_software_id'] = $eol_result['EolSoftware']['name'];
	$td[$i]['EolResult.ip_address'] = $eol_result['EolResult']['ip_address'];
	$td[$i]['EolResult.host_name'] = $eol_result['EolResult']['host_name'];
	$td[$i]['EolResult.resolved_by_date'] = array($this->Wrap->niceDay($eol_result['EolResult']['resolved_by_date']), array('class' => $highlightDueDate));
	$td[$i]['EolResult.tickets'] = $eol_result['EolResult']['tickets'];
	$td[$i]['EolResult.waiver'] = $eol_result['EolResult']['waiver'];
}

if(count($eol_results))
{
	echo $this->Html->divClear();
	echo $this->Html->tag('h3', __('OPEN End of Life (EOL) Results'));
	echo $this->Html->tag('h4', __('Count: %s', count($eol_results)));
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