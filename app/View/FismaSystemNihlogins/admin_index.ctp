<?php 
// File: app/View/FismaSystemNihlogins/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('NIH Login')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemNihlogin.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemNihlogin.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_nihlogins as $i => $fisma_system_nihlogin)
{
	$td[$i] = array(
		$fisma_system_nihlogin['FismaSystemNihlogin']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_nihlogin['FismaSystemNihlogin']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_nihlogin['FismaSystemNihlogin']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('NIH Logins')),
	'page_options' => $page_options,
	'search_placeholder' => __('%s - %s', __('FISMA System'), __('NIH Logins')),
	'th' => $th,
	'td' => $td,
));