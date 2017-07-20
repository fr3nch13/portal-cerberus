<?php
$page_options = array();

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s to this %s', __('FISMA Contacts'), __('FISMA System')), array('action' => 'add_ad_accounts', $fismaSystem['FismaSystem']['id'], 'saa' => true));
	$use_gridedit = true;
}

$th = array();
// $th['AdAccount.path'] = array('content' => __('Path'));
$th['AdAccountFismaSystem.ad_account_id'] = array('content' => __('AD Account'), 'options' => array('sort' => 'AdAccountFismaSystem.ad_account_id', 'editable' => array('type' => 'select', 'searchable' => true, 'options' => $adAccounts) ));
$th['AdAccountFismaSystem.fisma_contact_type_id'] = array('content' => __('Contact Type'), 'options' => array('editable' => array('type' => 'select', 'searchable' => true, 'options' => $fismaContactTypes) ));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));
$th['multiselect'] = true;

$td = array();
foreach ($adAccounts_fismaSystems as $i => $adAccount)
{
	$actions = array();
	
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $adAccount['AdAccountFismaSystem']['id'], 'saa' => true), array('confirm' => __('Are you sure?')));
	}
	
	$td[$i] = array();
//	$td[$i]['AdAccount.path'] = $this->Contacts->makePath($adAccount);
	$td[$i]['AdAccountFismaSystem.ad_account_id'] = array(
		$this->Html->link($adAccount['AdAccount']['name_username'], array('controller' => 'ad_accounts', 'action' => 'view', $adAccount['AdAccount']['id'])),
		array('value' => $adAccount['AdAccount']['id']),
	);
	$td[$i]['AdAccountFismaSystem.fisma_contact_type_id'] = array(
		(isset($adAccount['FismaContactType']['name'])?$adAccount['FismaContactType']['name']:'&nbsp;'),
		array('value' => $adAccount['FismaContactType']['id']),
	);
	$td[$i]['actions'] = array(
		implode("", $actions),
		array('class' => 'actions'),
	);
	$td[$i]['edit_id'] = array(
		'AdAccountFismaSystem' => $adAccount['AdAccountFismaSystem']['id'],
	);
	$td[$i]['multiselect'] = $adAccount['AdAccountFismaSystem']['id'];
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Contacts'),
	'page_options' => $page_options,
	'search_placeholder' => __('FISMA Contacts'),
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
	'use_jsordering' => true,
	'use_pagination' => false,
	'use_search' => false,
	'use_multiselect' => true,
	'multiselect_options' => $multiselectOptions,
));