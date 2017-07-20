<?php 
// File: app/View/FismaSystemFiles/fisma_system.ctp

$page_options = array();

// content
$th = array(
	'FismaSystemFile.filename' => array('content' => __('Filename'), 'options' => array('sort' => 'FismaSystemFile.filename')),
	'FismaSystemFile.nicename' => array('content' => __('Friendly Name'), 'options' => array('sort' => 'FismaSystemFile.nicename')),
	'FismaSystemFileState.name' => array('content' => __('File State'), 'options' => array('sort' => 'FismaSystemFileState.name')),
	'FismaSystemFile.raf' => array('content' => __('RAF'), 'options' => array('sort' => 'FismaSystemFile.raf')),
	'FismaSystem.name' => array('content' => __('Fisma System'), 'options' => array('sort' => 'FismaSystem.name')),
	'FismaSystemFile.expiration_date' => array('content' => __('Expiration Date'), 'options' => array('sort' => 'FismaSystemFile.expiration_date')),
	'FismaSystemFile.created' => array('content' => __('Created'), 'options' => array('sort' => 'FismaSystemFile.created')),
//	'FismaSystemFile.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'FismaSystemFile.modified')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($fisma_system_files as $i => $fisma_system_file)
{
	$actions = array(
		$this->Html->link(__('Download'), array('action' => 'download', $fisma_system_file['FismaSystemFile']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system_file['FismaSystemFile']['id'], 'saa' => true));
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system_file['FismaSystemFile']['id'], 'saa' => true), array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions);
	
	$td[$i] = array(
		$this->Html->link($fisma_system_file['FismaSystemFile']['filename'], array('action' => 'download', $fisma_system_file['FismaSystemFile']['id'])),
		$fisma_system_file['FismaSystemFile']['nicename'],
		$fisma_system_file['FismaSystemFileState']['name'],
		$this->Wrap->yesNo($fisma_system_file['FismaSystemFile']['raf']),
		$this->Html->link($fisma_system_file['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_file['FismaSystem']['id'])),
		$this->Wrap->niceTime($fisma_system_file['FismaSystemFile']['expiration_date']),
		$this->Wrap->niceTime($fisma_system_file['FismaSystemFile']['created']),
//		$this->Wrap->niceTime($fisma_system_file['FismaSystemFile']['modified']),
		array(
			$actions, 
			array('class' => 'actions'),
		),
	);
}

$file_type = __('Files');
if($raf)
	$file_type = __('Risk Acceptance Forms');

echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('FISMA System %s', $file_type)),
	'page_options' => $page_options,
	'search_placeholder' => $file_type,
	'th' => $th,
	'td' => $td,
));