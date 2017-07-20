<?php 
// File: app/View/Firewalls/admin_index.ctp


$page_options = array(
//	$this->Html->link(__('Add %s', __('Firewall')), array('action' => 'add')),
);

// content
$th = array(
	'Firewall.name' => array('content' => __('Firewall'), 'options' => array('sort' => 'Firewall.name')),
	'Firewall.hostname' => array('content' => __('Hostname'), 'options' => array('sort' => 'Firewall.hostname')),
	'Firewall.domain_name' => array('content' => __('Domain Name'), 'options' => array('sort' => 'Firewall.domain_name')),
	'Rule.count' => array('content' => __('Rule Count')),
	'Firewall.created' => array('content' => __('Created'), 'options' => array('sort' => 'Firewall.created')),
	'Firewall.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'Firewall.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);
$td = array();
foreach ($firewalls as $i => $firewall)
{
	
	$td[$i] = array(
		$this->Html->link($firewall['Firewall']['name'], array('action' => 'view', $firewall['Firewall']['id'])),
		$firewall['Firewall']['hostname'],
		$firewall['Firewall']['domain_name'],
		(isset($firewall['Firewall']['counts']['Rule.all'])?$firewall['Firewall']['counts']['Rule.all']:0),
		$this->Wrap->niceTime($firewall['Firewall']['created']),
		$this->Wrap->niceTime($firewall['Firewall']['modified']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $firewall['Firewall']['id'])),
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Firewalls'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>