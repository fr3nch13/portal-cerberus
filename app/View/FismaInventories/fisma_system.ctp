<?php 
// File: app/View/FismaInventories/fisma_system.ctp

$page_title = __('%s for: %s', __('FISMA Inventory'), $fisma_system['FismaSystem']['name']);

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options['add'] = $this->Html->link(__('Add %s Item', __('FISMA Inventory')), array('action' => 'add', $fisma_system['FismaSystem']['id'], 'saa' => true));
	$page_options['add_many'] = false;
}

$page_options['nsat_export_csv'] = $this->Html->link(__('Export to NSAT Format - CSV'), array($fisma_system['FismaSystem']['id'], 'nsat', 'ext' => 'csv'));

$this->set('page_title', $page_title);
$this->set('page_options', $page_options);

$this->extend('index');