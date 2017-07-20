<?php 

$page_options = [
	'add' => $this->Html->link(__('Add %s', __('FOV Hosts')), ['action' => 'add', (isset($passedArgs[0])?$passedArgs[0]:false)]),
];

$th = [
	'FovHost.id' => ['content' => __('ID'), 'options' => ['sort' => 'FovHost.id']],
	'FovHost.host_description' => ['content' => __('Description'), 'options' => ['sort' => 'FovHost.host_description', 'editable' => ['type' => 'text'] ]],
	'FovHost.host_name' => ['content' => __('Hostname'), 'options' => ['sort' => 'FovHost.host_name', 'editable' => ['type' => 'text'] ]],
	'FovHost.ip_address' => ['content' => __('IP Address'), 'options' => ['sort' => 'FovHost.ip_address', 'editable' => ['type' => 'text'] ]],
	'FovHost.mac_address' => ['content' => __('MAC Address'), 'options' => ['sort' => 'FovHost.mac_address', 'editable' => ['type' => 'text'] ]],
	'FovHost.asset_tag' => ['content' => __('Asset Tag'), 'options' => ['sort' => 'FovHost.asset_tag', 'editable' => ['type' => 'text'] ]],
	'FovHost.modified' => ['content' => __('Modified'), 'options' => ['sort' => 'FovHost.modified']],
	'FovHost.created' => ['content' => __('Created'), 'options' => ['sort' => 'FovHost.created']],
	'actions' => ['content' => __('Actions'), 'options' => ['class' => 'actions']],
	'multiselect' => true,
]; 

$td = [];
foreach ($fovHosts as $i => $fovHost)
{
	$actions = [];
	$actions[] = $this->Html->link(__('View'), ['action' => 'view', $fovHost['FovHost']['id'], 'admin' => false]);
	if($this->Wrap->roleCheck(['admin', 'reviewer', 'saa']))
		$actions[] = $this->Html->link(__('Edit'), ['action' => 'edit', $fovHost['FovHost']['id'], 'admin' => false]);
	if($this->Wrap->roleCheck(['admin']))
		$actions[] = $this->Html->link(__('Delete'), ['action' => 'delete', $fovHost['FovHost']['id'], 'admin' => true], ['confirm' => __('Are you sure?')]);
	
	$actions = implode("", $actions);
	
	$edit_id = [
		'FovHost' => $fovHost['FovHost']['id'],
	];
	
	$td[$i] = [
		$this->Html->link($fovHost['FovHost']['id'], ['action' => 'view', $fovHost['FovHost']['id']]),
		$fovHost['FovHost']['host_description'],
		$fovHost['FovHost']['host_name'],
		$fovHost['FovHost']['ip_address'],
		$fovHost['FovHost']['mac_address'],
		$fovHost['FovHost']['asset_tag'],
		[$this->Wrap->niceTime($fovHost['FovHost']['modified']), ['class' => 'nowrap']],
		[$this->Wrap->niceTime($fovHost['FovHost']['created']), ['class' => 'nowrap']],
		[
			$actions,
			['class' => 'actions'],
		],
		'edit_id' => $edit_id,
	];
}

$use_gridedit = false;
$use_griddelete = $user_gridadd = false;
if($this->Wrap->roleCheck(['admin', 'reviewer', 'saa']))
	$use_gridedit = true;
if($this->Wrap->roleCheck(['admin']))
	$use_griddelete = true;

echo $this->element('Utilities.page_index', [
	'page_title' => __('Focused Ops Vulnerability Hosts'),
	'page_subtitle' => (isset($page_subtitle)?$page_subtitle:false),
	'page_description' => $page_description,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	// grid/inline edit options
	'use_gridedit' => $use_gridedit,
	'use_griddelete' => $use_griddelete,
]);