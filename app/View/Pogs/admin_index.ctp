<?php 
// File: app/View/Pogs/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Port Object Group')), array('action' => 'add')),
);

// content
$th = array(
	'Pog.name' => array('content' => __('Name'), 'options' => array('sort' => 'Pog.name')),
	'Pog.slug' => array('content' => __('Slug'), 'options' => array('sort' => 'Pog.slug')),
	'Pog.simple' => array('content' => __('Display on Simple Form'), 'options' => array('sort' => 'Pog.simple', 'title' => __('Show in the Simple New Rule form?'))),
	'Pog.created' => array('content' => __('Created'), 'options' => array('sort' => 'Pog.created')),
	'Pog.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Pog.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($pogs as $i => $pog)
{
	$pogOptions = array(
		'title' => __('Ports for %s', $pog['Pog']['name']),
		'rel' => array('controller' => 'pogs', 'action' => 'tip', $pog['Pog']['id'], 'admin' => false),
	);
	
	$td[$i] = array(
		$this->Html->link($pog['Pog']['name'], array('action' => 'view', $pog['Pog']['id']), $pogOptions),
		$pog['Pog']['slug'],
		array(
			$this->Local->simpleLink($pog['Pog']['simple'], $pog['Pog']['id']),
			array('class' => 'actions'),
		),
		$this->Wrap->niceTime($pog['Pog']['created']),
		$this->Wrap->niceTime($pog['Pog']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $pog['Pog']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $pog['Pog']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $pog['Pog']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Port Object Groups'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>