<?php 


$page_options = array(
	$this->Html->link(__('Add %s', __('POA&M Risk')), array('action' => 'add')),
);

// content
$th = array(
	'PoamRisk.name' => array('content' => __('Name'), 'options' => array('sort' => 'PoamRisk.name')),
	'PoamRisk.color_code_hex' => array('content' => __('Color'), 'options' => array('sort' => 'PoamRisk.color_code_hex')),
	'PoamRisk.show' => array('content' => __('Show in Role-based Dashboards?'), 'options' => array('sort' => 'PoamRisk.show')),
	'PoamRisk.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($poamRisks as $i => $poamRisk)
{
	$td[$i] = array(
		$poamRisk['PoamRisk']['name'],
		$this->Common->coloredCell($poamRisk['PoamRisk'], array('displayField' => 'color_code_hex', 'colorShow' => true)),
		$this->Html->toggleLink($poamRisk['PoamRisk'], 'show'),
		$poamRisk['PoamRisk']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $poamRisk['PoamRisk']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $poamRisk['PoamRisk']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POA&M Risks'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));