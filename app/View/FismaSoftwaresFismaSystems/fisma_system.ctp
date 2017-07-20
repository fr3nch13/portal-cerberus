<?php 
// File: app/View/FismaSoftwaresFismaSystems/fisma_system.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s to this %s', __('Whitelisted Software'), __('FISMA System')), array('action' => 'add_softwares', $fisma_system['FismaSystem']['id'], 'saa' => true));
}

// content
$th = array(
	'FismaSoftware.name' => array('content' => __('Software Name'), 'options' => array('sort' => 'FismaSoftware.name')),
	'FismaSoftware.version' => array('content' => __('Version'), 'options' => array('sort' => 'FismaSoftware.version')),
	'FismaSoftware.FismaSoftwareGroup.name' => array('content' => __('Group')),
	'FismaSoftware.FismaSoftwareSource.name' => array('content' => __('Source')),
	'FismaSoftware.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FismaSoftware.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();	
foreach ($fisma_softwares_fisma_systems as $i => $fisma_software)
{
	$actions = array(
		$this->Html->link(__('View'), array('controller' => 'fisma_softwares', 'action' => 'view', $fisma_software['FismaSoftware']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('controller' => 'fisma_softwares', 'action' => 'edit', $fisma_software['FismaSoftware']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Remove'), array('action' => 'delete', $fisma_software['FismaSoftwareFismaSystem']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($fisma_software['FismaSoftware']['name'], array('controller' => 'fisma_softwares', 'action' => 'view', $fisma_software['FismaSoftware']['id'])),
		$fisma_software['FismaSoftware']['version'],
		(isset($fisma_software['FismaSoftware']['FismaSoftwareGroup']['name'])?$fisma_software['FismaSoftware']['FismaSoftwareGroup']['name']:false),
		(isset($fisma_software['FismaSoftware']['FismaSoftwareSource']['name'])?$fisma_software['FismaSoftware']['FismaSoftwareSource']['name']:false),
		$this->Wrap->niceTime($fisma_software['FismaSoftware']['modified']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('Whitelist Software')),
	'page_options' => $page_options,
	'search_placeholder' => __('Whitelist Software'),
	'th' => $th,
	'td' => $td,
));