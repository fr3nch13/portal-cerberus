<?php 
// File: app/View/FismaSoftwares/index.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('Whitelisted Software')), array('action' => 'add', 'saa' => true));
}

// content
$th = array(
	'FismaSoftware.name' => array('content' => __('Software Name'), 'options' => array('sort' => 'FismaSoftware.name')),
	'FismaSoftware.version' => array('content' => __('Version'), 'options' => array('sort' => 'FismaSoftware.version')),
	'FismaSoftwareGroup.name' => array('content' => __('Group'), 'options' => array('sort' => 'FismaSoftwareGroup.name')),
	'FismaSoftwareSource.name' => array('content' => __('Source'), 'options' => array('sort' => 'FismaSoftwareSource.name')),
	'FismaSoftware.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FismaSoftware.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_softwares as $i => $fisma_software)
{
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $fisma_software['FismaSoftware']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_software['FismaSoftware']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_software['FismaSoftware']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($fisma_software['FismaSoftware']['name'], array('action' => 'view', $fisma_software['FismaSoftware']['id'])),
		$fisma_software['FismaSoftware']['version'],
		$fisma_software['FismaSoftwareGroup']['name'],
		$fisma_software['FismaSoftwareSource']['name'],
		$this->Wrap->niceTime($fisma_software['FismaSoftware']['modified']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('Whitelisted Software')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));