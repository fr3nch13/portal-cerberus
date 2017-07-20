<?php

$stats = [
	'total' => ['name' => __('Total'), 'value' => 0, 'color' => 'FFFFFF'],
];

foreach($fismaSystems as $fismaSystem)
{
	$id = $fismaSystem['FismaSystem']['id'];
	$stats['FismaSystem.'.$id] = [
		'name' => $fismaSystem['FismaSystem']['name'],
		'value' => count($fismaSystem['FovResults']),
		'color' => substr(md5($fismaSystem['FismaSystem']['name']), 0, 6),
	];
	
	$stats['total']['value'] = ($stats['total']['value'] + count($fismaSystem['FovResults']));
}

$stats = Hash::sort($stats, '{s}.value', 'desc');
$pie_data = [[__('GSS Parent'), __('num %s', __('FOV Results')) ]];
$pie_options = ['slices' => []];
foreach($stats as $i => $stat)
{
	if($i == 'total')
	{
		$stats[$i]['pie_exclude'] = true;
		$stats[$i]['color'] = 'FFFFFF';
		continue;
	}
	if(!$stat['value'])
	{
		unset($stats[$i]);
		continue;
	}
	$pie_data[] = [$stat['name'], $stat['value'], $i];
	$pie_options['slices'][] = ['color' => '#'. $stat['color']];
}

$content = $this->element('Utilities.object_dashboard_chart_pie', [
	'title' => '',
	'data' => $pie_data,
	'options' => $pie_options,
]);

$content .= $this->element('Utilities.object_dashboard_stats', [
	'title' => '',
	'details' => $stats,
]);

echo $this->element('Utilities.object_dashboard_block', [
	'title' => __('%s by %s', __('FOV Results'), __('GSS Parent')),
	'description' => __('Excluding items that have a 0 count.'),
	'content' => $content,
]);