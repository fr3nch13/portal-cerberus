<?php 
// File: app/View/FismaSystemFipsRatings/admin_index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('%s - %s', __('FISMA System'), __('Fips Rating')) ), array('action' => 'add')),
);

// content
$th = array(
	'FismaSystemFipsRating.name' => array('content' => __('Name'), 'options' => array('sort' => 'FismaSystemFipsRating.name')),
	'FismaSystemFipsRating.color_code_hex' => array('content' => __('Color'), 'options' => array('sort' => 'FismaSystemFipsRating.color_code_hex')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_fips_ratings as $i => $fisma_system_fips_rating)
{
	$td[$i] = array(
		$fisma_system_fips_rating['FismaSystemFipsRating']['name'],
		$this->Common->coloredCell($fisma_system_fips_rating['FismaSystemFipsRating'], array('displayField' => 'color_code_hex', 'colorShow' => true)),
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_fips_rating['FismaSystemFipsRating']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_fips_rating['FismaSystemFipsRating']['id']), array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s - %s', __('FISMA System'), __('Fips Ratings')) ,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));