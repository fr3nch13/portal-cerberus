<?php

$page_options = array();

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$use_gridedit = true;
	$page_options['transfer_contacts'] = $this->Html->link(__('Transfer Contacts'), array('action' => 'transfer_contacts', 'saa' => true));
}

$th = array();
$th['AdAccount.path'] = array('content' => __('Path'));
$th['AdAccount.username'] = array('content' => __('%s %s', __('AD Account'), __('Username')), 'options' => array('sort' => 'AdAccountFismaSystem.ad_account_id'));
$th['FismaSystem.name'] = array('content' => __('%s %s', __('FISMA System'), __('Name')), 'options' => array('sort' => 'AdAccountFismaSystem.fisma_system_id'));
$th['AdAccountFismaSystem.fisma_contact_type_id'] = array('content' => __('Contact Type'), 'options' => array('sort' => 'FismaContactType.name', 'editable' => array('type' => 'select', 'searchable' => true, 'options' => $fismaContactTypes) ));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));
$th['multiselect'] = true;

$td = array();
foreach ($adAccounts_fismaSystems as $i => $adAccount_fismaSystem)
{
	$actions = array();
	
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $adAccount_fismaSystem['AdAccountFismaSystem']['id'], 'saa' => true), array('confirm' => __('Are you sure?')));
	}
	
	$username = false;
	if(isset($adAccount_fismaSystem['AdAccount']['id']))
	{
		$username = $this->Html->link($adAccount_fismaSystem['AdAccount']['username'], array('controller' => 'ad_accounts', 'action' => 'view', $adAccount_fismaSystem['AdAccount']['id'], 'tab' => 'fisma_contact_systems'));
	}
	
	$td[$i] = array();
	$td[$i]['AdAccount.path'] = $this->Contacts->makePath($adAccount_fismaSystem);
	$td[$i]['AdAccount.username'] = $username;
	$td[$i]['FismaSystem.name'] = $this->Html->link($adAccount_fismaSystem['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $adAccount_fismaSystem['FismaSystem']['id'], 'tab' => 'fisma_contacts'));
	$td[$i]['AdAccountFismaSystem.fisma_contact_type_id'] = array(
		(isset($adAccount_fismaSystem['FismaContactType']['name'])?$adAccount_fismaSystem['FismaContactType']['name']:'&nbsp;'),
		array('value' => $adAccount_fismaSystem['FismaContactType']['id']),
	);
	$td[$i]['actions'] = array(
		implode("", $actions),
		array('class' => 'actions'),
	);
	$td[$i]['edit_id'] = array(
		'AdAccountFismaSystem' => $adAccount_fismaSystem['AdAccountFismaSystem']['id'],
	);
	$td[$i]['multiselect'] = $adAccount_fismaSystem['AdAccountFismaSystem']['id'];
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Contacts'),
	'page_options' => $page_options,
	'search_placeholder' => __('FISMA Contacts'),
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
	'use_multiselect' => true,
	'multiselect_options' => $multiselectOptions,
));