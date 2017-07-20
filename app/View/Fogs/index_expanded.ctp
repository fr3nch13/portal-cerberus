<?php 
// File: app/View/Fogs/admin_index.ctp


$page_options = array(
);

// content
$th = array(
	'Fog.name' => array('content' => __('Firewall Object Group')),
	'Fog.ip_address' => array('content' => __('Ip Address')),
);

$td = array();
foreach ($fogs as $i => $fog)
{
	$td[$i] = array(
		$this->Html->link($fog['Fog']['name'], array('action' => 'view', $fog['Fog']['id'])),
		$fog['Fog']['ip_address'],
	);
}
$paging = array(
	'limit' => 0,
);
$this->set(compact('paging'));

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Firewall Object Groups'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
	'use_filter' => true,
));