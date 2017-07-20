<?php 
// File: app/View/Imports/index.ctp

// content
$th = array(
	'Import.name' => array('content' => __('Import'), 'options' => array('sort' => 'Import.name')),
//	'Import.created' => array('content' => __('Created'), 'options' => array('sort' => 'Import.created')),
//	'Import.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Import.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($imports as $i => $import)
{
	$td[$i] = array(
		$this->Html->link($import['Import']['name'], array('controller' => 'rules', 'action' => 'import', $import['Import']['id'])),
//		$this->Wrap->niceTime($import['Import']['created']),
//		$this->Wrap->niceTime($import['Import']['modified']),
		array(
			$this->Html->link(__('View %s', __('Rules')), array('controller' => 'rules', 'action' => 'import', $import['Import']['id'])),
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Imports'),
	'th' => $th,
	'td' => $td,
	));
?>