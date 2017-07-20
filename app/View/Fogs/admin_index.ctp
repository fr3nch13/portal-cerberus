<?php 
// File: app/View/Fogs/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Firewall Object Group')), array('action' => 'add')),
);

// content
$th = array(
	'Fog.name' => array('content' => __('Name'), 'options' => array('sort' => 'Fog.name')),
	'Fog.slug' => array('content' => __('Slug'), 'options' => array('sort' => 'Fog.slug')),
	'Fog.simple' => array('content' => __('Display on Simple Form'), 'options' => array('sort' => 'Fog.simple', 'title' => __('Show in the Simple New Rule form?'))),
	'Fog.created' => array('content' => __('Created'), 'options' => array('sort' => 'Fog.created')),
	'Fog.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Fog.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fogs as $i => $fog)
{
	$fogOptions = array(
		'title' => __('IP Addresses for %s', $fog['Fog']['name']),
		'rel' => array('controller' => 'fogs', 'action' => 'tip', $fog['Fog']['id'], 'admin' => false),
	);
	
	$td[$i] = array(
		$this->Html->link($fog['Fog']['name'], array('action' => 'view', $fog['Fog']['id']), $fogOptions),
		$fog['Fog']['slug'],
		array(
			$this->Local->simpleLink($fog['Fog']['simple'], $fog['Fog']['id']),
			array('class' => 'actions'),
		),
		$this->Wrap->niceTime($fog['Fog']['created']),
		$this->Wrap->niceTime($fog['Fog']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $fog['Fog']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $fog['Fog']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fog['Fog']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Firewall Object Groups'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>