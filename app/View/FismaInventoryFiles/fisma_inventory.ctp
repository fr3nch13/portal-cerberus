<?php 
// File: app/View/FismaInventoryFiles/fisma_inventory.ctp

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s ', __('FISMA Inventory %s', __('File'))), array('action' => 'add', $fisma_inventory_id, 'saa' => true));
}

// content
$th = array(
	'FismaInventoryFile.filename' => array('content' => __('Filename'), 'options' => array('sort' => 'FismaInventoryFile.filename')),
	'FismaInventoryFile.nicename' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'FismaInventoryFile.nicename')),
//	'FismaInventory.created' => array('content' => __('Created'), 'options' => array('sort' => 'FismaInventory.created')),
//	'FismaInventory.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FismaInventory.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_inventory_files as $i => $fisma_inventory_file)
{
	$actions = array(
		$this->Html->link(__('Download'), array('action' => 'download', $fisma_inventory_file['FismaInventoryFile']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_inventory_file['FismaInventoryFile']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_inventory_file['FismaInventoryFile']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode(' ', $actions);
	
	$td[$i] = array(
		$this->Html->link($fisma_inventory_file['FismaInventoryFile']['filename'], array('action' => 'download', $fisma_inventory_file['FismaInventoryFile']['id'])),
		$fisma_inventory_file['FismaInventoryFile']['nicename'],
//		$this->Wrap->niceTime($fisma_inventory_file['FismaInventoryFile']['created']),
//		$this->Wrap->niceTime($fisma_inventory_file['FismaInventoryFile']['modified']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('FISMA Inventory %s', __('Files'))),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));