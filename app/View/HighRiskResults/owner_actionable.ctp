<?php 

$th = array();
$th['HighRiskResult.vulnerability'] = array('content' => __('Vulnerability'), 'options' => array('sort' => 'HighRiskResult.vulnerability'));
$th['HighRiskResult.ip_address'] = array('content' => __('Ip Address'), 'options' => array('sort' => 'HighRiskResult.ip_address'));
$th['HighRiskResult.host_name'] = array('content' => __('Host Name'), 'options' => array('sort' => 'HighRiskResult.host_name'));
$th['HighRiskResult.reported_to_ic_date'] = array('content' => __('Reported to ORG/IC'), 'options' => array('sort' => 'HighRiskResult.reported_to_ic_date'));
$th['HighRiskResult.resolved_by_date'] = array('content' => __('Must be Resolved By'), 'options' => array('sort' => 'HighRiskResult.resolved_by_date'));
$th['HighRiskResult.ticket'] = array('content' => __('Ticket'), 'options' => array('sort' => 'HighRiskResult.ticket'));
$th['HighRiskResult.waiver'] = array('content' => __('Waiver'), 'options' => array('sort' => 'HighRiskResult.waiver'));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($high_risk_results as $i => $high_risk_result)
{
	
	$highlightDueDate = false;
	if(isset($high_risk_result['HighRiskResult']['resolved_by_date']) 
		and isset($high_risk_result['ReportsStatus']['name'])
		and $this->Common->slugify($high_risk_result['ReportsStatus']['name']) == 'open')
	{
		if($high_risk_result['HighRiskResult']['resolved_by_date'] == '0000-00-00 00:00:00')
			$high_risk_result['HighRiskResult']['resolved_by_date'] = false;
		$resolvedByDate = strtotime($high_risk_result['HighRiskResult']['resolved_by_date']);
		if($resolvedByDate)
		{
			if($resolvedByDate <= $thresholdNow)
				$highlightDueDate = 'highlight-red';
			elseif($resolvedByDate <= $thresholdSoon)
				$highlightDueDate = 'highlight-yellow';
		}
	}
	
	$td[$i] = array();
	$td[$i]['HighRiskResult.vulnerability'] = $high_risk_result['HighRiskResult']['vulnerability'];
	$td[$i]['HighRiskResult.ip_address'] = $high_risk_result['HighRiskResult']['ip_address'];
	$td[$i]['HighRiskResult.host_name'] = $high_risk_result['HighRiskResult']['host_name'];
	$td[$i]['HighRiskResult.reported_to_ic_date'] = $this->Wrap->niceDay($high_risk_result['HighRiskResult']['reported_to_ic_date']);
	$td[$i]['HighRiskResult.resolved_by_date'] = array($this->Wrap->niceDay($high_risk_result['HighRiskResult']['resolved_by_date']), array('class' => $highlightDueDate));
	$td[$i]['HighRiskResult.ticket'] = $high_risk_result['HighRiskResult']['ticket'];
	$td[$i]['HighRiskResult.waiver'] = $high_risk_result['HighRiskResult']['waiver'];
}

if(count($high_risk_results))
{
	echo $this->Html->divClear();
	echo $this->Html->tag('h3', __('OPEN High Risk Vulnerability (HRV) Results'));
	echo $this->Html->tag('h4', __('Count: %s', count($high_risk_results)));
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