<?php 
// File: app/View/Pogs/admin_index.ctp


$page_options = array(
);

// content
$th = array(
	'Pog.name' => array('content' => __('Firewall Object Group')),
	'Pog.ports' => array('content' => __('Ports')),
);

$td = array();
foreach ($pogs as $i => $pog)
{
	$td[$i] = array(
		$this->Html->link($pog['Pog']['name'], array('action' => 'view', $pog['Pog']['id'])),
		$pog['Pog']['port'],
	);
}
$paging = array(
	'limit' => 0,
);
$this->set(compact('paging'));

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Port Object Groups'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
	'use_filter' => true,
));