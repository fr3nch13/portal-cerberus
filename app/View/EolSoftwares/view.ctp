<?php 

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options['edit'] = $this->Html->link(__('Edit'), array('action' => 'edit', $eol_software['EolSoftware']['id'], 'saa' => true));
	$page_options['makealias'] = $this->Html->link(__('Make Alias'), array('action' => 'makealias', $eol_software['EolSoftware']['id'], 'saa' => true));
}
if($this->Wrap->roleCheck(array('admin')))
{
	$page_options['delete'] = $this->Html->link(__('Delete'), array('action' => 'delete', $eol_software['EolSoftware']['id'], 'admin' => true), array('confirm' => 'Are you sure?'));
}

$details = array(
	array('name' => __('Tickets'), 'value' => $this->Local->ticketLinks($eol_software['EolSoftware']['tickets'])),
	array('name' => __('Waivers'), 'value' => $this->Local->waiverLinks($eol_software['EolSoftware']['waiver'])),
	array('name' => __('CR IDs'), 'value' => $this->Local->crLinks($eol_software['EolSoftware']['changerequest'])),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($eol_software['EolSoftware']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($eol_software['EolSoftware']['modified'])),
);

$stats = array();
$tabs = array();

$tabs['aliases'] = $stats['aliases'] = array(
	'id' => 'aliases',
	'name' => __('Aliases'), 
	'ajax_url' => array('controller' => 'eol_software_aliases', 'action' => 'eol_software', $eol_software['EolSoftware']['id']),
);
$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => array('controller' => 'us_results', 'action' => 'eol_software', $eol_software['EolSoftware']['id']),
);
$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => array('controller' => 'eol_results', 'action' => 'eol_software', $eol_software['EolSoftware']['id']),
);
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('controller' => 'pen_test_results', 'action' => 'eol_software', $eol_software['EolSoftware']['id']),
);
$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => array('controller' => 'high_risk_results', 'action' => 'eol_software', $eol_software['EolSoftware']['id']),
);
$tabs['action_recommended'] = array(
	'id' => 'action_recommended',
	'name' => __('Recommented Action'),
	'content' => $this->Wrap->descView($eol_software['EolSoftware']['action_recommended']),
);
$tabs['tags'] = $stats['tags'] = array(
	'id' => 'tags',
	'name' => __('Tags'), 
	'ajax_url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'eol_software', $eol_software['EolSoftware']['id']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s', __('Software/Vulnerability'), $eol_software['EolSoftware']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));