<?php 
// File: app/View/Fogs/parents.ctp


$page_options = array(
//	$this->Html->link(__('Add %s', __('Firewall Object Group')), array('action' => 'add')),
);

// content
$th = array(
	'Fog.name' => array('content' => __('Firewall Object Group'), 'options' => array('sort' => 'Fog.name')),
	'Fog.simple' => array('content' => __('Display on Simple Form'), 'options' => array('sort' => 'Fog.simple', 'title' => __('Show in the Simple New Rule form?'))),
	'Fog.created' => array('content' => __('Created'), 'options' => array('sort' => 'Fog.created')),
	'Fog.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Fog.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fogs as $i => $fog)
{
	$fogOptions = array(
		'title' => __('IP Addresses for %s', $fog['FogParent']['name']),
		'rel' => array('controller' => 'fogs', 'action' => 'tip', $fog['FogParent']['id'], 'admin' => false),
	);
	
	$td[$i] = array(
		$this->Html->link($fog['FogParent']['name'], array('action' => 'view', $fog['FogParent']['id']), $fogOptions),
		array(
			$this->Local->simpleLink($fog['FogParent']['simple'], $fog['FogParent']['id']),
			array('class' => 'actions'),
		),
		$this->Wrap->niceTime($fog['FogParent']['created']),
		$this->Wrap->niceTime($fog['FogParent']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $fog['FogParent']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $fog['FogParent']['id'])), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('Parent'), __('Firewall Object Groups')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>