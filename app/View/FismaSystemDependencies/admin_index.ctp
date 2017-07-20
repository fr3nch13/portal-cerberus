<?php 
// File: app/View/FismaSystemDependencies/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Dependency')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemDependency.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemDependency.name')),
	'FismaSystemDependency.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemDependency.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_dependencies as $i => $fisma_system_dependency)
{
	$td[$i] = array(
		$fisma_system_dependency['FismaSystemDependency']['name'],
		$fisma_system_dependency['FismaSystemDependency']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_dependency['FismaSystemDependency']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_dependency['FismaSystemDependency']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Dependencies')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));