<?php 

$page_options = array();

if($this->Common->roleCheck(array('admin', 'saa')))
{
//	$page_options['add'] = $this->Html->link(__('Add %s', __('%s %s', __('EOL/US'), __('Software')) ), array('action' => 'add', 'saa' => true));
}

// content
$th = array(
	'EolSoftwareAlias.key' => array('content' => __('Key'), 'options' => array('sort' => 'EolSoftwareAlias.key', 'editable' => array('type' => 'text'))),
	'EolSoftwareAlias.name' => array('content' => __('Name'), 'options' => array('sort' => 'EolSoftwareAlias.name', 'editable' => array('type' => 'text'))),
	'EolSoftwareAlias.created' => array('content' => __('Created'), 'options' => array('sort' => 'EolSoftwareAlias.created')),
);

$td = array();
foreach ($eolSoftwareAliases as $i => $eolSoftwareAlias)
{	
	$edit_id = array(
		'EolSoftwareAlias' => $eolSoftwareAlias['EolSoftwareAlias']['id'],
	);
		
	$td[$i] = array(
		$eolSoftwareAlias['EolSoftwareAlias']['key'],
		$eolSoftwareAlias['EolSoftwareAlias']['name'],
		$this->Wrap->niceTime($eolSoftwareAlias['EolSoftwareAlias']['created']),
		'edit_id' => $edit_id,
	);
}

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$use_gridedit = true;
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Aliases'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'use_gridedit' => $use_gridedit,
));