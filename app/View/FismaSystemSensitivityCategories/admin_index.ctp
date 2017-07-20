<?php 
// File: app/View/FismaSystemSensitivityCategories/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemSensitivityCategory.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemSensitivityCategory.name')),
	'FismaSystemSensitivityCategory.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemSensitivityCategory.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_sensitivity_categories as $i => $fisma_system_sensitivity_category)
{
	$td[$i] = array(
		$fisma_system_sensitivity_category['FismaSystemSensitivityCategory']['name'],
		$fisma_system_sensitivity_category['FismaSystemSensitivityCategory']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_sensitivity_category['FismaSystemSensitivityCategory']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_sensitivity_category['FismaSystemSensitivityCategory']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Sensitivity Categories')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));