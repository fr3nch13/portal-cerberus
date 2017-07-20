<?php 
// File: app/View/Imports/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Import')), array('action' => 'add')),
);

// content
$th = array(
	'Import.name' => array('content' => __('Name'), 'options' => array('sort' => 'Import.name')),
	'Import.filename' => array('content' => __('File Name'), 'options' => array('sort' => 'Import.filename')),
	'Import.rule_count' => array('content' => __('# Rules')),
	'Import.rescanned' => array('content' => __('Last Scanned'), 'options' => array('sort' => 'Import.rescanned')),
	'Import.created' => array('content' => __('Created'), 'options' => array('sort' => 'Import.created')),
	'Import.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Import.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($imports as $i => $import)
{
	$td[$i] = array(
		$this->Html->link($import['Import']['name'], array('action' => 'view', $import['Import']['id'])),
		$import['Import']['filename'],
		array('.', array(
			'ajax_count_url' => array('controller' => 'rules', 'action' => 'import', $import['Import']['id'], 'admin' => true), 
			'url' => array('controller' => 'rules', 'action' => 'import', $import['Import']['id'], 'admin' => true, 'tab' => 'rules'),
		)),
		$this->Wrap->niceTime($import['Import']['rescanned']),
		$this->Wrap->niceTime($import['Import']['created']),
		$this->Wrap->niceTime($import['Import']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $import['Import']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $import['Import']['id'])).
			$this->Html->link(__('%s/%s', __('Scan'), __('Rescan')), array('action' => 'rescan', $import['Import']['id']), array('confirm' => __('Are you sure you want to rescan the config file?')) ).
			$this->Html->link(__('Delete'), array('action' => 'delete', $import['Import']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Imports'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>