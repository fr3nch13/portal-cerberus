<?php 


$page_options = array(
	$this->Html->link(__('Add %s', __('POA&M Status')), array('action' => 'add')),
);

// content
$th = array(
	'PoamStatus.name' => array('content' => __('Name'), 'options' => array('sort' => 'PoamStatus.name')),
	'PoamStatus.color_code_hex' => array('content' => __('Color'), 'options' => array('sort' => 'PoamStatus.color_code_hex')),
	'PoamStatus.show' => array('content' => __('Show in Role-based Dashboards?'), 'options' => array('sort' => 'PoamStatus.show')),
	'PoamStatus.details' => array('content' => __('Details')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($poamStatuses as $i => $poamStatus)
{
	$td[$i] = array(
		$poamStatus['PoamStatus']['name'],
		$this->Common->coloredCell($poamStatus['PoamStatus'], array('displayField' => 'color_code_hex', 'colorShow' => true)),
		$this->Html->toggleLink($poamStatus['PoamStatus'], 'show'),
		$poamStatus['PoamStatus']['details'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $poamStatus['PoamStatus']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $poamStatus['PoamStatus']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POA&M Statuses'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));