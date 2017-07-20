<?php 

$th = [];
$th['EolSoftware_name'] = ['content' => __('Software/Vulnerability')];
$th['EolSoftware_tickets'] = ['content' => __('Tickets')];
$th['UsResult_count'] = ['content' => __('# Results')];

$total = 0;
$td = [];
foreach ($results as $result)
{
	$softwareId = 0;
	$softwareName = __('N/A');
	$softwareTickets = '';
	if($result['EolSoftware']['id'])
	{
		$softwareId = $result['EolSoftware']['id'];
		$softwareName = $result['EolSoftware']['name'];
		$softwareTickets = $result['EolSoftware']['tickets'];
	}
	
	// make a new row
	if(!isset($td[$softwareId]))
	{
		$td[$softwareId] = [
			'EolSoftware_name' => $softwareName,
			'EolSoftware_tickets' => $softwareTickets,
			'UsResult_count' => 0,
		];
	}
	$td[$softwareId]['UsResult_count']++;
	$total++;
}
$td[0] = [
	'EolSoftware_name' => __('Total'),
	'EolSoftware_tickets' => '',
	'UsResult_count' => $total,
];
$td = Hash::sort($td, '{n}.UsResult_count', 'desc');

echo $this->element('Utilities.page_index', [
	'page_title' => __('All Results'),
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_filter' => false,
	'use_search' => false,
]);