<?php

$line_options = ['colors' => []];
if(isset($snapshotStats['legend']))
{
	foreach($snapshotStats['legend'] as $key => $name)
	{
		$line_options['colors'][] = '#'. substr(md5($name), 0, 6);
	}
}

$content = $this->element('Utilities.object_dashboard_chart_line', [
	'title' => '',
	'data' => $snapshotStats,
	'options' => $line_options,
]);

echo $this->element('Utilities.object_dashboard_block', [
	'title' => $this->Html->link(__('%s - By %s Trending', __('FOV'), __('Remediation')), ['action' => 'dashboard']),
	'content' => $content,
]);