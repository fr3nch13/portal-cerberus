<?php 

$page_options = array();

$use_gridedit = false;
if($this->Common->roleCheck('admin'))
{
	$use_gridedit = true;
	$page_options['add'] = $this->Html->link(__('Add %s %s', __('FISMA Contact'), __('Type')), array('action' => 'add', 'admin' => true));
}

// content
$th = array();
$th['FismaContactType.name'] = array('content' => __('Name'), 'options' => array('sort' => 'FismaContactType.name', 'editable' => array('type' => 'text')));
$th['FismaContactType.primary_priority'] = array('content' => __('Primary Priority'), 'options' => array('sort' => 'FismaContactType.primary_priority', 'editable' => array('type' => 'select', 'options' => range(0,10)) ));
if($this->Common->roleCheck('admin'))
{
	$th['FismaContactType.is_daa'] = array('content' => __('DAA'), 'options' => array('sort' => 'FismaContactType.is_daa'));
	$th['FismaContactType.is_isso'] = array('content' => __('ISSO'), 'options' => array('sort' => 'FismaContactType.is_isso'));
	$th['FismaContactType.is_saa'] = array('content' => __('SA&A'), 'options' => array('sort' => 'FismaContactType.is_saa'));
	$th['FismaContactType.is_tech'] = array('content' => __('Tech POC'), 'options' => array('sort' => 'FismaContactType.is_tech'));
}
$th['Contacts.count'] = array('content' => __('# Contacts'));
$th['NoFismaSystem.count'] = array('content' => __('# %s w/o Contact Type', __('FISMA Systems')));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));

$td = array();
foreach ($fisma_contact_types as $i => $fisma_contact_type)
{
	$actions = array();
	$actions['view'] = $this->Html->link(__('View'), array('action' => 'view', $fisma_contact_type['FismaContactType']['id'], 'admin' => false));
	
	if($this->Common->roleCheck('admin'))
	{
		$actions['edit'] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_contact_type['FismaContactType']['id'], 'admin' => true));
		$actions['delete'] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_contact_type['FismaContactType']['id'], 'admin' => true), array('confirm' => __('Are you sure?')));
	}
	
	$td[$i] = array();
	$td[$i]['FismaContactType.name'] = $this->Html->link($fisma_contact_type['FismaContactType']['name'], array('action' => 'view', $fisma_contact_type['FismaContactType']['id'], 'admin' => false));
	
	$td[$i]['FismaContactType.primary_priority'] = array(
		(isset($fisma_contact_type['FismaContactType']['primary_priority'])?($fisma_contact_type['FismaContactType']['primary_priority']?$fisma_contact_type['FismaContactType']['primary_priority']:'&nbsp;'):'&nbsp;'),
		array('value' => $fisma_contact_type['FismaContactType']['primary_priority']),
	);
	if($this->Common->roleCheck('admin'))
	{
		
		$td[$i]['FismaContactType.is_daa'] = $this->Html->defaultLink($fisma_contact_type['FismaContactType'], 'is_daa', 'admin');
		$td[$i]['FismaContactType.is_isso'] = $this->Html->defaultLink($fisma_contact_type['FismaContactType'], 'is_isso', 'admin');
		$td[$i]['FismaContactType.is_saa'] = $this->Html->defaultLink($fisma_contact_type['FismaContactType'], 'is_saa', 'admin');
		$td[$i]['FismaContactType.is_tech'] = $this->Html->defaultLink($fisma_contact_type['FismaContactType'], 'is_tech', 'admin');
	}
	$td[$i]['Contacts.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'ad_accounts_fisma_systems', 'action' => 'fisma_contact_type', $fisma_contact_type['FismaContactType']['id']),
		'url' => array('action' => 'view', $fisma_contact_type['FismaContactType']['id'], 'tab' => 'Contacts'),
	));
	$td[$i]['NoFismaSystem.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems', 'action' => 'no_fisma_contact_type', $fisma_contact_type['FismaContactType']['id']),
		'url' => array('action' => 'view', $fisma_contact_type['FismaContactType']['id'], 'tab' => 'MissingFismaSystems'),
	));
	$td[$i]['actions'] = array(
		implode('', $actions),
		array('class' => 'actions'),
	);
	$td[$i]['edit_id'] = array(
		'FismaContactType' => $fisma_contact_type['FismaContactType']['id'],
	);
}

if($crm)
{
	$i++;
	$td[$i] = array();
	$td[$i]['FismaContactType.name'] = __('CRMs');
	$td[$i]['Contacts.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'ad_accounts_fisma_systems', 'action' => 'fisma_contact_type', $fisma_contact_type['FismaContactType']['id']),
		'url' => array('action' => 'view', $fisma_contact_type['FismaContactType']['id'], 'tab' => 'Contacts'),
	));
}

if($owner)
{
	$i++;
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s %s', __('FISMA Contact'), __('Types')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
));