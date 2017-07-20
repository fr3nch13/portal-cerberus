<?php 
$page_options = array();
$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $poamResult['PoamResult']['id'], 'admin' => false));

$details_blocks = array();


	
$division = false;
if(isset($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id']))
{
	$division = $this->Html->link($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['shortname'], array('controller' => 'divisions', 'action' => 'view', $poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'], 'tab' => 'poam_results'));
}
$branch = false;
if(isset($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['id']))
{
	$branch = $this->Html->link($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['shortname'], array('controller' => 'divisions', 'action' => 'view', $poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['id'], 'tab' => 'poam_results'));
}

$details_blocks[1][1] = array(
	'title' => __('Location'),
	'details' => array(
		array('name' => __('Division'), 'value' => $division),
		array('name' => __('Branch'), 'value' => $branch),
		array('name' => __('FISMA System'), 'value' => $this->Html->link($poamResult['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $poamResult['FismaSystem']['id'], 'tab' => 'poam_results'))),
	)
);

$details_blocks[1][2] = array(
	'title' => __('Result Details'),
	'details' => array(
		array('name' => __('Auto Closed?'), 'value' => $this->Common->yesNo($poamResult['PoamResult']['auto_closed'])),
		array('name' => __('Tickets'), 'value' => $this->Local->ticketLinks($poamResult['PoamResult']['tickets'])),
		array('name' => __('Waivers'), 'value' => $this->Local->waiverLinks($poamResult['PoamResult']['waiver'])),
		array('name' => __('Status'), 'value' => $poamResult['PoamStatus']['name']),
	)
);

$details_blocks[1][3] = array(
	'title' => __('Dates'),
	'details' => array(
		array('name' => __('Created'), 'value' => $this->Wrap->niceDay($poamResult['PoamResult']['created'])),
		array('name' => __('Modified'), 'value' => $this->Wrap->niceDay($poamResult['PoamResult']['modified'])),
		array('name' => __('Identified'), 'value' => $this->Wrap->niceDay($poamResult['PoamResult']['identified_date'])),
		array('name' => __('Created'), 'value' => $this->Wrap->niceDay($poamResult['PoamResult']['creation_date'])),
		array('name' => __('Scheduled Completion'), 'value' => $this->Wrap->niceDay($poamResult['PoamResult']['scheduled_completion_date'])),
		array('name' => __('Estimated Completion'), 'value' => $this->Wrap->niceDay($poamResult['PoamResult']['estimated_completion_date'])),
		array('name' => __('Actual Completion'), 'value' => $this->Wrap->niceDay($poamResult['PoamResult']['actual_completion_date'])),
	)
);

$stats = array();
$tabs = array();

$tabs['description'] = array(
	'id' => 'description',
	'name' => __('Detailed Description'),
	'content' => $this->Wrap->descView($poamResult['PoamResult']['description']),
);
$tabs['comments'] = array(
	'id' => 'comments',
	'name' => __('Comments'),
	'content' => $this->Wrap->descView("(Please explain why it's False positive, Acceptable Risk or Action(s) taken)\n\n". $poamResult['PoamResult']['comments']),
);
$tabs['poam_reports'] = $stats['poam_reports'] = array(
	'id' => 'poam_reports',
	'name' => __('POA&M Reports'), 
	'ajax_url' => array('controller' => 'poam_reports', 'action' => 'poam_result', $poamResult['PoamResult']['id'], 'admin' => false),
);
/*
$tabs['poam_results'] = $stats['poam_results'] = array(
	'id' => 'poam_results',
	'name' => __('POA&M Results'), 
	'ajax_url' => array('controller' => 'poam_results', 'action' => 'poam_result', $poamResult['PoamResult']['id'], 'admin' => false),
);
*/
$tabs['change_log'] = $stats['change_log'] = array(
	'id' => 'change_log',
	'name' => __('Change Logs'), 
	'ajax_url' => array('controller' => 'poam_result_logs', 'action' => 'poam_result', $poamResult['PoamResult']['id'], 'admin' => false),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'poam_result', $poamResult['PoamResult']['id'], 'admin' => false),
);

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('%s: #%s - %s', __('POA&M Result'), $poamResult['PoamResult']['id'], $poamResult['PoamResult']['weakness_id']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details_blocks' => $details_blocks,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));