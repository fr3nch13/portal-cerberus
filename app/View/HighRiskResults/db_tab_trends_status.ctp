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

$page_title = __('%s by Statuses for the past 30 days. (Daily)', __('High Risk Results'));

$page_options = array();
$page_options['reload'] = $this->Html->link(__('Reload Section'), $this->Html->urlModify(), array('class' => 'section-hijack'));

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
		'page_content' => $page_content,
	));
}
else
{
	$page_title = __('%s by Statuses for the past 3 months. (Daily)', __('High Risk Results'));
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
	echo $this->element('Utilities.page_index', array(
		'page_subtitle2' => $page_title,
		'page_options' => $page_options,
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
		'use_jsordering' => false,
		'use_float_head' => false,
	));
}