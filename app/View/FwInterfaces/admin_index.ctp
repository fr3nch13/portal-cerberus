<?php 
// File: app/View/FwInterfaces/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Interface')), array('action' => 'add')),
);

// content
$th = array(
	'FwInterface.name' => array('content' => __('Name'), 'options' => array('sort' => 'FwInterface.name')),
	'FwInterface.slug' => array('content' => __('Slug'), 'options' => array('sort' => 'FwInterface.slug')),
	'FwInterface.created' => array('content' => __('Created'), 'options' => array('sort' => 'FwInterface.created')),
	'FwInterface.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FwInterface.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fw_interfaces as $i => $fw_interface)
{
	$td[$i] = array(
		$this->Html->link($fw_interface['FwInterface']['name'], array('action' => 'view', $fw_interface['FwInterface']['id'])),
		$fw_interface['FwInterface']['slug'],
		$this->Wrap->niceTime($fw_interface['FwInterface']['created']),
		$this->Wrap->niceTime($fw_interface['FwInterface']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $fw_interface['FwInterface']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $fw_interface['FwInterface']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fw_interface['FwInterface']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Interfaces'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>