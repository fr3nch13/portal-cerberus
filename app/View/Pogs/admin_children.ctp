<?php 
// File: app/View/Pogs/children.ctp


$page_options = array(
//	$this->Html->link(__('Add %s', __('Port Object Group')), array('action' => 'add')),
);

// content
$th = array(
	'Pog.name' => array('content' => __('Port Object Group'), 'options' => array('sort' => 'Pog.name')),
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
		'title' => __('Ports for %s', $pog['PogChild']['name']),
		'rel' => array('controller' => 'pogs', 'action' => 'tip', $pog['PogChild']['id'], 'admin' => false),
	);
	
	$td[$i] = array(
		$this->Html->link($pog['PogChild']['name'], array('action' => 'view', $pog['PogChild']['id']), $pogOptions),
		$pog['PogChild']['slug'],
		array(
			$this->Local->simpleLink($pog['PogChild']['simple'], $pog['PogChild']['id']),
			array('class' => 'actions'),
		),
		$this->Wrap->niceTime($pog['PogChild']['created']),
		$this->Wrap->niceTime($pog['PogChild']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $pog['PogChild']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $pog['PogChild']['id'])), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('Children'), __('Port Object Groups')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>