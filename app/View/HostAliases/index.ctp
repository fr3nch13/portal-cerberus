<?php 
// File: app/View/HostAliases/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('Host Alias')), array('action' => 'add')),
);

// content
$th = array(
	'HostAlias.ip_address' => array('content' => __('IP Address'), 'options' => array('sort' => 'HostAlias.ip_address')),
	'HostAlias.alias' => array('content' => __('Alias'), 'options' => array('sort' => 'HostAlias.alias')),
	'HostAlias.created' => array('content' => __('Created'), 'options' => array('sort' => 'HostAlias.created')),
	'HostAlias.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'HostAlias.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($host_aliases as $i => $host_alias)
{
	$td[$i] = array(
		$host_alias['HostAlias']['ip_address'],
		$host_alias['HostAlias']['alias'],
		$this->Wrap->niceTime($host_alias['HostAlias']['created']),
		$this->Wrap->niceTime($host_alias['HostAlias']['modified']),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Host Aliases'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>