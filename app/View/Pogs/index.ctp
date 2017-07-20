<?php 
// File: app/View/Pogs/index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Port Object Group')), array('action' => 'add')),
);

// content
$th = array(
	'Pog.name' => array('content' => __('Port Object Group'), 'options' => array('sort' => 'Pog.name')),
	'Protocol.name' => array('content' => __('Protocol'), 'options' => array('sort' => 'Protocol.name')),
	'Pog.simple' => array('content' => __('Display on Simple Form'), 'options' => array('sort' => 'Pog.simple', 'title' => __('Show in the Simple New Rule form?'))),
	'SrcRule.count' => array('content' => __('Src Rule Count')),
	'DstRule.count' => array('content' => __('Dst Rule Count')),
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
		$this->Html->link($pog['Protocol']['name'], array('controller' => 'protocols', 'action' => 'view', $pog['Protocol']['id'])),
		array(
			$this->Local->simpleLink($pog['Pog']['simple'], $pog['Pog']['id']),
			array('class' => 'actions'),
		),
		(isset($pog['Pog']['counts']['SrcRule.all'])?$pog['Pog']['counts']['SrcRule.all']:0),
		(isset($pog['Pog']['counts']['DstRule.all'])?$pog['Pog']['counts']['DstRule.all']:0),
		$this->Wrap->niceTime($pog['Pog']['created']),
		$this->Wrap->niceTime($pog['Pog']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $pog['Pog']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $pog['Pog']['id'])), 
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