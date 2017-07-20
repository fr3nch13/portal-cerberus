<?php

$stats = array(
	'total' => array('name' => __('Total'), 'value' => 0, 'color' => 'FFFFFF'),
);

foreach($fismaSystems as $fismaSystem)
{
	$id = $fismaSystem['FismaSystem']['id'];
	$stats['FismaSystem.'.$id] = array(
		'name' => $fismaSystem['FismaSystem']['name'],
		'value' => count($fismaSystem['PoamResults']),
		'color' => substr(md5($fismaSystem['FismaSystem']['name']), 0, 6),
	);
	
	$stats['total']['value'] = ($stats['total']['value'] + count($fismaSystem['PoamResults']));
}

$stats = Hash::sort($stats, '{s}.value', 'desc');
$pie_data = array(array(__('GSS Parent'), __('num %s', __('POA&M Results')) ));
$pie_options = array('slices' => array());
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
	$pie_data[] = array($stat['name'], $stat['value'], $i);
	$pie_options['slices'][] = array('color' => '#'. $stat['color']);
}

$content = $this->element('Utilities.object_dashboard_chart_pie', array(
	'title' => '',
	'data' => $pie_data,
	'options' => $pie_options,
));

$content .= $this->element('Utilities.object_dashboard_stats', array(
	'title' => '',
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => __('%s by %s', __('POA&M Results'), __('GSS Parent')),
	'description' => __('Excluding items that have a 0 count.'),
	'content' => $content,
));