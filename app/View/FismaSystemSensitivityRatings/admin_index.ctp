<?php 
// File: app/View/FismaSystemSensitivityRatings/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Sensitivity Rating')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemSensitivityRating.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemSensitivityRating.name')),
	'FismaSystemSensitivityRating.rating' => array('content' => __('Rating'), 'options' => array('sort' => 'FismaSystemSensitivityRating.rating')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_sensitivity_ratings as $i => $fisma_system_sensitivity_rating)
{
	$td[$i] = array(
		$fisma_system_sensitivity_rating['FismaSystemSensitivityRating']['name'],
		$fisma_system_sensitivity_rating['FismaSystemSensitivityRating']['rating'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_sensitivity_rating['FismaSystemSensitivityRating']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_sensitivity_rating['FismaSystemSensitivityRating']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Sensitivity Ratings')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));