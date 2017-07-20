<?php 

$th = array();
/*
$th['PoamResult.eol_software_id'] = array('content' => __('EOL/US Software'), 'options' => array('sort' => 'EolSoftware.name'));
$th['PoamResult.ip_address'] = array('content' => __('Ip Address'), 'options' => array('sort' => 'PoamResult.ip_address'));
$th['PoamResult.host_name'] = array('content' => __('Host Name'), 'options' => array('sort' => 'PoamResult.host_name'));
$th['PoamResult.resolved_by_date'] = array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'PoamResult.resolved_by_date'));
$th['PoamResult.tickets'] = array('content' => __('Tickets'), 'options' => array('sort' => 'PoamResult.tickets'));
*/
$th['PoamResult.waiver'] = array('content' => __('Waiver'), 'options' => array('sort' => 'PoamResult.waiver'));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($poamResults as $i => $poamResult)
{
	
	$highlightDueDate = false;
	if(isset($poamResult['PoamResult']['resolved_by_date']) 
		and isset($poamResult['PoamStatus']['name'])
		and $this->Common->slugify($poamResult['PoamStatus']['name']) == 'open')
	{
		if($poamResult['PoamResult']['resolved_by_date'] == '0000-00-00 00:00:00')
			$poamResult['PoamResult']['resolved_by_date'] = false;
		$resolvedByDate = strtotime($poamResult['PoamResult']['resolved_by_date']);
		if($resolvedByDate)
		{
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
	}
	
	$td[$i] = array();
	$td[$i]['PoamResult.eol_software_id'] = $poamResult['EolSoftware']['name'];
	$td[$i]['PoamResult.ip_address'] = $poamResult['PoamResult']['ip_address'];
	$td[$i]['PoamResult.host_name'] = $poamResult['PoamResult']['host_name'];
	$td[$i]['PoamResult.resolved_by_date'] = array($this->Wrap->niceDay($poamResult['PoamResult']['resolved_by_date']), array('class' => $highlightDueDate));
	$td[$i]['PoamResult.tickets'] = $poamResult['PoamResult']['tickets'];
	$td[$i]['PoamResult.waiver'] = $poamResult['PoamResult']['waiver'];
}

if(count($poamResults))
{
	echo $this->Html->divClear();
	echo $this->Html->tag('h3', __('OPEN POA&M Results'));
	echo $this->Html->tag('h4', __('Count: %s', count($poamResults)));
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