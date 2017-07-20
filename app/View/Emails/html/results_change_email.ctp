<?php

$this->Html->setFull(true);

$page_options = [];

$parts = [];
if($countEol)
{
	$title = $this->Html->tag('h3', __('%s: %s', __('EOL Results'), $countEol));
	$eolResults = $this->requestAction(['controller' => 'eol_results', 'action' => 'db_tab_change', $timeAgoWord, $modelKey], ['return']);
	$parts[] = $this->Html->tag('div', $title.$eolResults). $this->Html->tag('hr');
}
if($countPt)
{
	$title = $this->Html->tag('h3', __('%s: %s', __('Pen Test Results'), $countPt));
	$ptResults = $this->requestAction(['controller' => 'pen_test_results', 'action' => 'db_tab_change', $timeAgoWord, $modelKey], ['return']);
	$parts[] = $this->Html->tag('div', $title.$ptResults). $this->Html->tag('hr');
}
if($countHr)
{
	$title = $this->Html->tag('h3', __('%s: %s', __('High Risk Results'), $countHr));
	$hrResults = $this->requestAction(['controller' => 'high_risk_results', 'action' => 'db_tab_change', $timeAgoWord, $modelKey], ['return']);
	$parts[] = $this->Html->tag('div', $title.$hrResults). $this->Html->tag('hr');
}

echo $this->element('Utilities.email_html_generic', [
	'page_subtitle' => __('List of EOL/PT/HR Results with their %s changed since %s', $modelKey, $this->Wrap->niceTime($timeAgo)),
	'page_subtitle2' => $subject,
	'page_content' => implode("\n", $parts),
]);