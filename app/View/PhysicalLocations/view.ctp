<?php 
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $physicalLocation['PhysicalLocation']['id'], 'admin' => true));
}

$details = array(
	array('name' => __('Full Name'), 'value' => $physicalLocation['PhysicalLocation']['fullname']),
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($physicalLocation['PhysicalLocation']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($physicalLocation['PhysicalLocation']['modified'])),
);

$stats = array();
$tabs = array();

$stats['fisma_systems'] = $tabs['fisma_systems'] = array(
	'id' => 'fisma_systems',
	'name' => __('Associated %s', __('FISMA Systems')), 
	'ajax_url' => array('controller' => 'fisma_systems_physical_locations', 'action' => 'physical_location', $physicalLocation['PhysicalLocation']['id']),
);
$tabs['details'] = array(
	'id' => 'details',
	'name' => __('Details'),
	'content' => $this->Wrap->descView($physicalLocation['PhysicalLocation']['details']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s - %s', __('Physical Location'), $physicalLocation['PhysicalLocation']['name'], $physicalLocation['PhysicalLocation']['fullname']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));