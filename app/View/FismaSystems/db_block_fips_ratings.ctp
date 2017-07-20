<?php

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($fismaSystems), 'color' => 'FFFFFF'),
);


foreach($fismaSystemFipsRatings as $fismaSystemFipsRating)
{
	$id = $fismaSystemFipsRating['FismaSystemFipsRating']['id'];
	$stats['FismaSystemFipsRating.'.$id] = array(
		'name' => $fismaSystemFipsRating['FismaSystemFipsRating']['name'],
		'value' => 0,
		'color' => $fismaSystemFipsRating['FismaSystemFipsRating']['color_code_hex'],
	);
}

foreach($fismaSystems as $fismaSystem)
{
	if($fismaSystem['FismaSystemFipsRating']['id'])
	{
		$fisma_system_fips_rating_id = $fismaSystem['FismaSystemFipsRating']['id'];
		if(!isset($stats['FismaSystemFipsRating.'.$fisma_system_fips_rating_id]))
		{
			$stats['FismaSystemFipsRating.'.$fisma_system_fips_rating_id] = array(
				'name' => $fismaSystem['FismaSystemFipsRating']['name'],
				'value' => 0,
				'color' => $fismaSystem['FismaSystemFipsRating']['color_code_hex'],
				
			);
		}
		$stats['FismaSystemFipsRating.'.$fisma_system_fips_rating_id]['value']++;
	}	
}

$stats = Hash::sort($stats, '{s}.value', 'desc');
$pie_data = array(array(__('FIPS Rating'), __('num %s', __('FISMA Systems')) ));
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
	$pie_data[] = [$stat['name'], $stat['value'], $i];
	$pie_options['slices'][] = ['color' => $stat['color']];
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
	'title' => __('%s by %s', __('FISMA Systems'), __('FIPS Rating')),
	'description' => __('Excluding items that have a 0 count.'),
	'content' => $content,
));