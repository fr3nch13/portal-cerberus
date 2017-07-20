<?php

$line_options = array('colors' => array(), 'orientation' => 'horizontal', 'showToggle' => true, 'chartArea' => array('height' => '80%', 'width' => '82%', 'top' => 5, 'left' => 30));
foreach($snapshotStats['legend'] as $key => $name)
{
	if($name != 'Day')
		$snapshotStats['legend'][$key] = __('With Status: %s', $name);
	$color = '#'. substr(md5($name), 0, 6);
	if(strpos($key, '-'))
	{
		$parts = explode('-', $key);
		$key_id = array_pop($parts);
		if(isset($reportsStatuses[$key_id]))
			$color = $reportsStatuses[$key_id];
		$line_options['colors'][] = $color;
	}
}

$dowName = date('l', strtotime("Sunday +{$dow} days"));
$page_title = __('%s by Statuses for the past 3 months. (Weekly every %s)', __('High Risk Results'), $dowName);
$page_options = array();
$page_options['reload'] = $this->Html->link(__('Reload Section'), $this->Html->urlModify(), array('class' => 'section-hijack'));

$page_options2 = array();
foreach(range(0, 6) as $dowOption)
{
	
	$dowNameOption = date('l', strtotime("Sunday +{$dowOption} days"));
	$page_options2['dow_'. $dowOption] = $this->Html->link(__('Show %ss', $dowNameOption), $this->Html->urlModify(array(0 => $dowOption)), array('class' => 'section-hijack'));
}

if(!$asTable)
{
	$page_content = $this->element('Utilities.object_chart_line', array(
		'title' => '',
		'data' => $snapshotStats,
		'options' => $line_options,
	));

	echo $this->element('Utilities.page_generic', array(
		'page_subtitle2' => $page_title,
		'page_options' => $page_options,
		'page_options_title2' => __('Change the Day of the Week'),
		'page_options2' => $page_options2,
		'page_content' => $page_content,
	));
}
else
{
	$th = array();
	foreach($snapshotStats['legend'] as $key => $name)
	{
		$th[$key] = $name;
	}
	$td = array();
	foreach($snapshotStats['data'] as $date => $dateData)
	{
		$td[$date] = array();
		foreach($dateData as $dataKey => $dataVal)
		{
			if(!$dataVal) $dataVal = '0 ';
			$td[$date][$dataKey] = $dataVal;
		}
	}
	$td = array_reverse($td);
	echo $this->element('Utilities.page_index', array(
		'page_subtitle2' => $page_title,
		'page_options' => $page_options,
		'page_options_title2' => __('Change the Day of the Week'),
		'page_options2' => $page_options2,
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
		'use_jsordering' => false,
		'use_float_head' => false,
	));
}