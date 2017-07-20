<?php 
// File: app/View/FismaSystems/index.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s to this %s', __('FISMA Systems'), __('Whitelisted Software')), array('action' => 'add_systems', $fisma_software['FismaSoftware']['id'], 'saa' => true));
}

// content
$th = array(
	'FismaSystem.name' => array('content' => __('Short Name'), 'options' => array('sort' => 'FismaSystem.name')),
	'FismaSystem.owner_name' => array('content' => __('Owner'), 'options' => array('sort' => 'FismaSystem.owner_name')),
	'FismaSystem.tech_name' => array('content' => __('Tech Contact'), 'options' => array('sort' => 'FismaSystem.tech_name')),
	'FismaSystem.created' => array('content' => __('Created'), 'options' => array('sort' => 'FismaSystem.created')),
	'FismaSystem.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FismaSystem.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_softwares_fisma_systems as $i => $fisma_system)
{
	$actions = array(
		$this->Html->link(__('View Inventory'), array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system['FismaSystem']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('controller' => 'fisma_systems', 'action' => 'edit', $fisma_system['FismaSystem']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Remove'), array('action' => 'delete', $fisma_system['FismaSoftwareFismaSystem']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($fisma_system['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system['FismaSystem']['id'])),
		$this->Html->link($fisma_system['FismaSystem']['owner_name'], 'mailto:'. $fisma_system['FismaSystem']['owner_email']),
		$this->Html->link($fisma_system['FismaSystem']['tech_name'], 'mailto:'. $fisma_system['FismaSystem']['tech_email']),
		$this->Wrap->niceTime($fisma_system['FismaSystem']['created']),
		$this->Wrap->niceTime($fisma_system['FismaSystem']['modified']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Systems'),
	'page_options' => $page_options,
	'search_placeholder' => __('FISMA Systems'),
	'th' => $th,
	'td' => $td,
	));
?>