<?php 

$th = array();
$th['PoamResult.id'] = array('content' => __('ID'), 'options' => array('sort' => 'PoamResult.id'));
$th['PoamResult.weakness_id'] = array('content' => __('Weakness ID'), 'options' => array('sort' => 'PoamResult.weakness_id'));
if(!$stripped)$th['PoamResult.Division'] = array('content' => __('Division'));
if(!$stripped)$th['PoamResult.Branch'] = array('content' => __('Branch'));
$th['FismaSystem.name'] = array('content' => __('FISMA System'), 'options' => array('sort' => 'FismaSystem.name'));
$th['PoamResult.description'] = array('content' => __('Description'));
$th['PoamResult.tickets'] = array('content' => __('Tickets'), 'options' => array('sort' => 'PoamResult.tickets'));
$th['PoamResult.waiver'] = array('content' => __('Waivers'), 'options' => array('sort' => 'PoamResult.waiver'));
$th['PoamCriticality.name'] = array('content' => __('Criticality'), 'options' => array('sort' => 'PoamCriticality.name'));
$th['PoamRisk.name'] = array('content' => __('Risk'), 'options' => array('sort' => 'PoamRisk.name'));
$th['PoamSeverity.name'] = array('content' => __('Severity'), 'options' => array('sort' => 'PoamSeverity.name'));
$th['PoamStatus.name'] = array('content' => __('Status'), 'options' => array('sort' => 'PoamStatus.name'));
if(!$stripped)$th['PoamResult.modified'] = array('content' => __('Modified'), 'options' => array('sort' => 'PoamResult.modified' ));
if(!$stripped)$th['PoamResult.created'] = array('content' => __('Created'), 'options' => array('sort' => 'PoamResult.created' ));


$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($poamResults as $i => $poamResult)
{
	$td[$i] = array();
	$division = false;
	if(isset($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id']))
		$division = $poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['shortname'];
	
	$branch = false;
	if(isset($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['id']))
		$branch = $poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['shortname'];

	$td[$i]['PoamResult.id'] = $poamResult['PoamResult']['id'];
	$td[$i]['PoamResult.weakness_id'] = $poamResult['PoamResult']['weakness_id'];
	if(!$stripped)$td[$i]['PoamResult.Division'] = $division;
	if(!$stripped)$td[$i]['PoamResult.Branch'] = $branch;
	$td[$i]['FismaSystem.name'] = $poamResult['FismaSystem']['name'];
	$td[$i]['PoamResult.description'] = $this->Html->tableDesc($poamResult['PoamResult']['description']);
	$td[$i]['PoamResult.tickets'] = $this->Local->ticketLinks($poamResult['PoamResult']['tickets']);
	$td[$i]['PoamResult.waiver'] = $this->Local->waiverLinks($poamResult['PoamResult']['waiver']);
	$td[$i]['PoamCriticality.name'] = $poamResult['PoamCriticality']['name'];
	$td[$i]['PoamRisk.name'] = $poamResult['PoamRisk']['name'];
	$td[$i]['PoamSeverity.name'] = $poamResult['PoamSeverity']['name'];
	$td[$i]['PoamStatus.name'] = $poamResult['PoamStatus']['name'];
	if(!$stripped)$td[$i]['PoamResult.modified'] = $this->Wrap->niceTime($poamResult['PoamResult']['modified']);
	if(!$stripped)$td[$i]['PoamResult.created'] = $this->Wrap->niceTime($poamResult['PoamResult']['created']);
}

if($stripped)
{
	echo $this->element('Utilities.table', array(
		'th' => $th,
		'td' => $td,
//		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
		'table_stripped' => true,
		'table_widget_options' => array(
			'setup' => "
				self.element.find('td.highlight-red').parent().addClass('highlight-red');
				self.element.find('td.highlight-yellow').parent().addClass('highlight-yellow');
			"
		),
	));
}
else{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('All Results'),
		'th' => $th,
		'td' => $td,
//		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
		'table_widget_options' => array(
			'setup' => "
				self.element.find('td.highlight-red').parents('tr').addClass('highlight-red');
				self.element.find('td.highlight-yellow').parents('tr').addClass('highlight-yellow');
			"
		),
	));
}