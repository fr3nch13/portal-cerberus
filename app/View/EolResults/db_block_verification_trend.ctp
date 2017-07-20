<?php

$line_options = array('colors' => array());
if(isset($snapshotStats['legend']))
{
	foreach($snapshotStats['legend'] as $key => $name)
	{
		$line_options['colors'][] = '#'. substr(md5($name), 0, 6);
	}
}

$content = $this->element('Utilities.object_dashboard_chart_line', array(
	'title' => '',
	'data' => $snapshotStats,
	'options' => $line_options,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => $this->Html->link(__('%s - By %s Trending', __('EOL'), __('Verification')), array('action' => 'dashboard')),
	'content' => $content,
));