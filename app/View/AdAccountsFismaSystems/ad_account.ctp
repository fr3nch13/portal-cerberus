<?php 
// File: app/View/FismaSystems/index.ctp

$page_options = array();

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s to this %s', __('FISMA Systems'), __('FISMA Contact')), array('action' => 'add_systems', $adAccount['AdAccount']['id'], 'saa' => true));
	$use_gridedit = true;
}

$th = array();
$th['FismaSystem.name'] = array('content' => __('Name'));
$th['AdAccountFismaSystem.fisma_contact_type_id'] = array('content' => __('Contact Type'), 'options' => array('sort' => 'FismaContactType.name', 'editable' => array('type' => 'select', 'searchable' => true, 'options' => $fismaContactTypes) ));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));
$th['multiselect'] = true;


$td = array();
foreach ($adAccounts_fismaSystems as $i => $fismaSystem)
{
	$actions = array();
	
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fismaSystem['AdAccountFismaSystem']['id'], 'saa' => true), array('confirm' => __('Are you sure?')));
	}
	
	$td[$i] = array();
	$td[$i]['FismaSystem.name'] = $this->Html->link($fismaSystem['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fismaSystem['FismaSystem']['id']));
	$td[$i]['AdAccountFismaSystem.fisma_contact_type_id'] = array(
		(isset($fismaSystem['FismaContactType']['name'])?$fismaSystem['FismaContactType']['name']:'&nbsp;'),
		array('value' => $fismaSystem['FismaContactType']['id']),
	);
	$td[$i]['actions'] = array(
		implode("", $actions),
		array('class' => 'actions'),
	);
	$td[$i]['edit_id'] = array(
		'AdAccountFismaSystem' => $fismaSystem['AdAccountFismaSystem']['id'],
	);
	$td[$i]['multiselect'] = $fismaSystem['AdAccountFismaSystem']['id'];
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Systems'),
	'page_options' => $page_options,
	'search_placeholder' => __('FISMA Systems'),
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
	'use_jsordering' => true,
	'use_pagination' => false,
	'use_search' => false,
	'use_multiselect' => true,
	'multiselect_options' => $multiselectOptions,
));