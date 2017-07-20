<?php 


$page_options = array(
	$this->Html->link(__('Add %s', __('POA&M Criticality')), array('action' => 'add')),
);

// content
$th = array(
	'PoamCriticality.name' => array('content' => __('Name'), 'options' => array('sort' => 'PoamCriticality.name')),
	'PoamCriticality.color_code_hex' => array('content' => __('Color'), 'options' => array('sort' => 'PoamCriticality.color_code_hex')),
	'PoamCriticality.show' => array('content' => __('Show in Role-based Dashboards?'), 'options' => array('sort' => 'PoamCriticality.show')),
	'PoamCriticality.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($poamCriticalities as $i => $poamCriticality)
{
	$td[$i] = array(
		$poamCriticality['PoamCriticality']['name'],
		$this->Common->coloredCell($poamCriticality['PoamCriticality'], array('displayField' => 'color_code_hex', 'colorShow' => true)),
		$this->Html->toggleLink($poamCriticality['PoamCriticality'], 'show'),
		$poamCriticality['PoamCriticality']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $poamCriticality['PoamCriticality']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $poamCriticality['PoamCriticality']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POA&M Criticalities'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));