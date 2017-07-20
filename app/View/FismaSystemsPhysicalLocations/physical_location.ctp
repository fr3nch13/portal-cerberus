<?php 

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Select %s', __('FISMA Systems')), array('action' => 'edit_systems', $physicalLocation['PhysicalLocation']['id'], 'saa' => true));
}

$th = array();
$th['FismaSystem.name'] = array('content' => __('FISMA System'), 'options' => array('sort' => 'FismaSystem.name'));
$th['FismaSystem.fullname'] = array('content' => __('Full System'), 'options' => array('sort' => 'FismaSystem.fullname'));
$th['PhysicalLocation.count'] = array('content' => __('# %s', __('Locations')));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));

$td = array();
foreach ($fismaSystems as $i => $fismaSystem)
{
	$actions = array(
		$this->Html->link(__('View'), array('controller' => 'fisma_systems', 'action' => 'view', $fismaSystem['FismaSystem']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('controller' => 'fisma_systems', 'action' => 'edit', $fismaSystem['FismaSystem']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Remove'), array('action' => 'delete', $fismaSystem['FismaSystemPhysicalLocation']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$td[$i] = array();
	$td[$i]['FismaSystem.name'] = $this->Html->link($fismaSystem['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fismaSystem['FismaSystem']['id']));
	$td[$i]['FismaSystem.fullname'] = $this->Html->link($fismaSystem['FismaSystem']['fullname'], array('controller' => 'fisma_systems', 'action' => 'view', $fismaSystem['FismaSystem']['id']));
	$td[$i]['PhysicalLocation.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems_physical_locations', 'action' => 'fisma_system', $fismaSystem['FismaSystem']['id']), 
		'url' => array('controller' => 'fisma_systems', 'action' => 'view', $fismaSystem['FismaSystem']['id'], 'tab' => 'locations'),
	));
	$td[$i]['actions'] = array(
		$actions, 
		array('class' => 'actions'),
	);
	
	
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Systems'),
	'page_options' => $page_options,
	'search_placeholder' => __('FISMA Systems'),
	'th' => $th,
	'td' => $td,
));