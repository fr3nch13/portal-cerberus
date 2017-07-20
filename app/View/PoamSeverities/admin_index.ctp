<?php 


$page_options = array(
	$this->Html->link(__('Add %s', __('POA&M Severity')), array('action' => 'add')),
);

// content
$th = array(
	'PoamSeverity.name' => array('content' => __('Name'), 'options' => array('sort' => 'PoamSeverity.name')),
	'PoamSeverity.color_code_hex' => array('content' => __('Color'), 'options' => array('sort' => 'PoamSeverity.color_code_hex')),
	'PoamSeverity.show' => array('content' => __('Show in Role-based Dashboards?'), 'options' => array('sort' => 'PoamSeverity.show')),
	'PoamSeverity.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($poamSeverities as $i => $poamSeverity)
{
	$td[$i] = array(
		$poamSeverity['PoamSeverity']['name'],
		$this->Common->coloredCell($poamSeverity['PoamSeverity'], array('displayField' => 'color_code_hex', 'colorShow' => true)),
		$this->Html->toggleLink($poamSeverity['PoamSeverity'], 'show'),
		$poamSeverity['PoamSeverity']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $poamSeverity['PoamSeverity']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $poamSeverity['PoamSeverity']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POA&M Severities'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));