<?php 
// File: app/View/Protocols/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Protocol')), array('action' => 'add')),
);

// content
$th = array(
	'Protocol.name' => array('content' => __('Name'), 'options' => array('sort' => 'Protocol.name')),
	'Protocol.slug' => array('content' => __('Slug'), 'options' => array('sort' => 'Protocol.slug')),
	'Protocol.simple' => array('content' => __('Display on Simple Form'), 'options' => array('sort' => 'Protocol.simple', 'title' => __('Show in the Simple New Rule form?'))),
	'Protocol.created' => array('content' => __('Created'), 'options' => array('sort' => 'Protocol.created')),
	'Protocol.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Protocol.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($protocols as $i => $protocol)
{
	$td[$i] = array(
		$this->Html->link($protocol['Protocol']['name'], array('action' => 'view', $protocol['Protocol']['id'])),
		$protocol['Protocol']['slug'],
		array(
			$this->Local->simpleLink($protocol['Protocol']['simple'], $protocol['Protocol']['id']),
			array('class' => 'actions'),
		),
		$this->Wrap->niceTime($protocol['Protocol']['created']),
		$this->Wrap->niceTime($protocol['Protocol']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $protocol['Protocol']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $protocol['Protocol']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $protocol['Protocol']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Protocols'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>