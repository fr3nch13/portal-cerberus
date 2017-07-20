<?php 

$page_options = array();

if($this->Wrap->roleCheck(array('saa', 'admin')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('Physical Location')), array('action' => 'add', 'saa' => true));
}

// content
$th = array();
$th['PhysicalLocation.name'] = array('content' => __('Location Name'), 'options' => array('sort' => 'PhysicalLocation.name'));
$th['PhysicalLocation.fullname'] = array('content' => __('Full Name'), 'options' => array('sort' => 'PhysicalLocation.fullname'));
$th['FismaSystem.count'] = array('content' => __('# %s', __('FISMA Systems')));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));

$td = array();
foreach ($physicalLocations as $i => $physicalLocation)
{
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $physicalLocation['PhysicalLocation']['id'])),
	);
	
	if($this->Wrap->roleCheck(array('saa', 'admin')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $physicalLocation['PhysicalLocation']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $physicalLocation['PhysicalLocation']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$td[$i] = array();
	$td[$i]['PhysicalLocation.name'] = $this->Html->link($physicalLocation['PhysicalLocation']['name'], array('action' => 'view', $physicalLocation['PhysicalLocation']['id']));
	$td[$i]['PhysicalLocation.fullname'] = $this->Html->link($physicalLocation['PhysicalLocation']['fullname'], array('action' => 'view', $physicalLocation['PhysicalLocation']['id']));
	$td[$i]['FismaSystem.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems_physical_locations', 'action' => 'physical_location', $physicalLocation['PhysicalLocation']['id']), 
		'url' => array('action' => 'view', $physicalLocation['PhysicalLocation']['id'], 'tab' => 'fisma_systems'),
	));
	$td[$i]['actions'] = array(
		$actions, 
		array('class' => 'actions'),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('Physical Location')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));