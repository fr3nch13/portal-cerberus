<?php 

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Select %s', __('Physical Locations')), array('action' => 'edit_locations', $fismaSystem['FismaSystem']['id'], 'saa' => true));
}

$th = array();
$th['PhysicalLocation.name'] = array('content' => __('Location Name'), 'options' => array('sort' => 'PhysicalLocation.name'));
$th['PhysicalLocation.fullname'] = array('content' => __('Full Name'), 'options' => array('sort' => 'PhysicalLocation.fullname'));
$th['FismaSystem.count'] = array('content' => __('# %s', __('FISMA Systems')));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));

$td = array();
foreach ($physicalLocations as $i => $physicalLocation)
{
	$actions = array(
		$this->Html->link(__('View'), array('controller' => 'physical_locations', 'action' => 'view', $physicalLocation['PhysicalLocation']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('controller' => 'physical_locations', 'action' => 'edit', $physicalLocation['PhysicalLocation']['id'], 'admin' => true));
	}
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Remove'), array('action' => 'delete', $physicalLocation['FismaSystemPhysicalLocation']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$td[$i] = array();
	$td[$i]['PhysicalLocation.name'] = $this->Html->link($physicalLocation['PhysicalLocation']['name'], array('controller' => 'physical_locations', 'action' => 'view', $physicalLocation['PhysicalLocation']['id']));
	$td[$i]['PhysicalLocation.fullname'] = $this->Html->link($physicalLocation['PhysicalLocation']['fullname'], array('controller' => 'physical_locations', 'action' => 'view', $physicalLocation['PhysicalLocation']['id']));
	$td[$i]['FismaSystem.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems_physical_locations', 'action' => 'physical_location', $physicalLocation['PhysicalLocation']['id']), 
		'url' => array('controller' => 'physical_locations', 'action' => 'view', $physicalLocation['PhysicalLocation']['id'], 'tab' => 'fisma_systems'),
	));
	$td[$i]['actions'] = array(
		$actions, 
		array('class' => 'actions'),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('Physical Locations')),
	'page_options' => $page_options,
	'search_placeholder' => __('Physical Locations'),
	'th' => $th,
	'td' => $td,
));