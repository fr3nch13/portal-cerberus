<?php 
// File: app/View/FwInts/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Firewall Path')), array('action' => 'add')),
);

// content
$th = array(
	'FwInt.name' => array('content' => __('Name'), 'options' => array('sort' => 'FwInt.name')),
	'Firewall.name' => array('content' => __('Firewall'), 'options' => array('sort' => 'Firewall.name')),
	'FwInterface.name' => array('content' => __('Interface'), 'options' => array('sort' => 'FwInterface.name')),
	'FwInt.created' => array('content' => __('Created'), 'options' => array('sort' => 'FwInt.created')),
	'FwInt.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FwInt.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fw_ints as $i => $fw_int)
{
	$td[$i] = array(
		$this->Html->link($fw_int['FwInt']['name'], array('action' => 'view', $fw_int['FwInt']['id'])),
		$this->Html->link($fw_int['Firewall']['name'], array('controller' => 'firewalls', 'action' => 'view', $fw_int['Firewall']['id'])),
		$this->Html->link($fw_int['FwInterface']['name'], array('controller' => 'fw_interfaces', 'action' => 'view', $fw_int['FwInterface']['id'])),
		$this->Wrap->niceTime($fw_int['FwInt']['created']),
		$this->Wrap->niceTime($fw_int['FwInt']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $fw_int['FwInt']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $fw_int['FwInt']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fw_int['FwInt']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Firewall Paths'),
	'page_options' => $page_options,
	'search_placeholder' => __('Firewall Paths'),
	'th' => $th,
	'td' => $td,
	));
?>