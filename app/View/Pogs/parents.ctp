<?php 
// File: app/View/Pogs/parents.ctp


$page_options = array(
//	$this->Html->link(__('Add %s', __('Port Object Group')), array('action' => 'add')),
);

// content
$th = array(
	'Pog.name' => array('content' => __('Port Object Group'), 'options' => array('sort' => 'Pog.name')),
	'Pog.simple' => array('content' => __('Display on Simple Form'), 'options' => array('sort' => 'Pog.simple', 'title' => __('Show in the Simple New Rule form?'))),
	'Pog.created' => array('content' => __('Created'), 'options' => array('sort' => 'Pog.created')),
	'Pog.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Pog.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($pogs as $i => $pog)
{
	$pogOptions = array(
		'title' => __('Ports for %s', $pog['PogParent']['name']),
		'rel' => array('controller' => 'pogs', 'action' => 'tip', $pog['PogParent']['id'], 'admin' => false),
	);
	
	$td[$i] = array(
		$this->Html->link($pog['PogParent']['name'], array('action' => 'view', $pog['PogParent']['id']), $pogOptions),
		array(
			$this->Local->simpleLink($pog['PogParent']['simple'], $pog['PogParent']['id']),
			array('class' => 'actions'),
		),
		$this->Wrap->niceTime($pog['PogParent']['created']),
		$this->Wrap->niceTime($pog['PogParent']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $pog['PogParent']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $pog['PogParent']['id'])), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('Parent'), __('Port Object Groups')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>