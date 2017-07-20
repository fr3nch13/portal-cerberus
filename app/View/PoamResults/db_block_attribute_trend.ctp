<?php

$line_options = array('colors' => array());
if(isset($snapshotStats['legend']))
{
	foreach($snapshotStats['legend'] as $key => $name)
	{
		$snapshotStats['legend'][$key] = $name;
		$color = '#'. substr(md5($name), 0, 6);
		if(strpos($key, '-'))
		{
			$parts = explode('-', $key);
			$key_id = array_pop($parts);
			if(isset($poamAttributes[$key_id]))
				$color = $poamAttributes[$key_id];
			$line_options['colors'][] = $color;
		}
	}
}

$content = $this->element('Utilities.object_dashboard_chart_line', array(
	'title' => '',
	'data' => $snapshotStats,
	'options' => $line_options,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => $this->Html->link(__('%s - By %s Trending', __('POA&M'), $attrName), array('action' => 'dashboard')),
	'content' => $content,
));