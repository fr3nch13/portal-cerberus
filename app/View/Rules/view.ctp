<?php 
// File: app/View/Rule/view.ctp

$page_options = array(
	$this->Html->link(__('Send Email Notification'), array('action' => 'notify', $rule['Rule']['id'])),
	$this->Html->link(__('Edit'), array('action' => 'edit', $rule['Rule']['id'])),
	$this->Html->link(__('Clone'), array('action' => 'add', $rule['Rule']['id'])),
	$this->Html->link(__('Rescan'), array('action' => 'rescan', $rule['Rule']['id'])),
);

if(in_array(AuthComponent::user('role'), array('admin', 'reviewer')))
{
	$review_state = ($rule['ReviewState']['id']?$rule['ReviewState']['name']:'Unknown');
	$review_state = __('%s - Click to change', $review_state);
	$page_options[] = $this->Html->link($review_state, array('action' => 'edit_state', $rule['Rule']['id']));
}

if(in_array(AuthComponent::user('role'), array('admin')))
{
	$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $rule['Rule']['id'], 'admin' => true), array('confirm' => Configure::read('Dialogues.deleterule')));
}

$tmp = array('User' => $rule['RuleAddedUser']);
$RuleAddedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
$RuleModifiedUser = '';
if($rule['RuleModifiedUser']['id'])
{
	$tmp = array('User' => $rule['RuleModifiedUser']);
	$RuleModifiedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
}
$RuleReviewedUser = '';
if($rule['RuleReviewedUser']['id'])
{
	$tmp = array('User' => $rule['RuleReviewedUser']);
	$RuleReviewedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
}

$details_blocks = array();


$details_blocks[1][1] = array(
	'title' => __('Details'),
	'details' => array(
		array('name' => __('ID'), 'value' => $rule['Rule']['id']),
		array('name' => __('Hash'), 'value' => $rule['Rule']['hash']),
		array('name' => __('Review State'), 'value' =>  $rule['ReviewState']['name']),
		array('name' => __('Rule POC Email'), 'value' => $rule['Rule']['poc_email']),
		array('name' => __('Related Tickets'), 'value' => $this->Wrap->descView($rule['Rule']['ticket'])),
		array('name' => __('Import'), 'value' => $rule['Import']['name']),
	),
);
if($rule['Rule']['use_fw_int'])
{
	$details_blocks[1][1]['details'][] = array('name' => __('Firewall Path'), 'value' => $this->Html->link($rule['FwInt']['name'], array('action' => 'fw_ints', $rule['FwInt']['id']), array(
		'title' => __('Details for %s', $rule['FwInt']['name']),
		'rel' => array('controller' => 'fw_ints', 'action' => 'tip', $rule['FwInt']['id']),
	)));
}
else
{
	$details_blocks[1][1]['details'][] = array('name' => __('Firewall'), 'value' => $this->Html->link($rule['Firewall']['name'], array('action' => 'firewall', $rule['Firewall']['id'])));
	$details_blocks[1][1]['details'][] = array('name' => __('Interface'), 'value' => $this->Html->link($rule['FwInterface']['name'], array('action' => 'fw_interface', $rule['FwInterface']['id'])));
}
$details_blocks[1][1]['details'][] = array('name' => __('Permit'), 'value' => $this->Local->permitDetail($rule['Rule']['permit']));
$details_blocks[1][1]['details'][] = array('name' => __('Protocol'), 'value' => $rule['Protocol']['name']);
$details_blocks[1][1]['details'][] = array('name' => __('Logging Settings'), 'value' => $rule['Rule']['logging']);

$details_blocks[1][2] = array(
	'title' => __('Dates &amp; Users'),
	'details' => array(
		array('name' => __('Created'), 'value' => $this->Wrap->niceTime($rule['Rule']['created'])),
		array('name' => __('Created By'), 'value' => $RuleAddedUser),
		array('name' => __('Last Updated'), 'value' => $this->Wrap->niceTime($rule['Rule']['modified'])),
		array('name' => __('Last Updated By'), 'value' => $RuleModifiedUser),
		array('name' => __('Reviewed'), 'value' => $this->Wrap->niceTime($rule['Rule']['reviewed'])),
		array('name' => __('Reviewed By'), 'value' => $RuleReviewedUser),
	),
);

$srcIpAddressTitle = __('Ip Address');
$srcIpAddress = ($rule['Rule']['src_ip']?$this->Local->hostAliasTip($rule['Rule']['src_ip']):'&nbsp;');
$srcPortTitle = __('Port');
$srcPort = ($rule['Rule']['src_port']?$rule['Rule']['src_port']:'&nbsp;');
if($rule['Rule']['use_src_fog'])
{
	$srcIpAddressTitle = __('F.O.G.');
	$srcFogOptions = array(
		'title' => __('IP Addresses for %s', $rule['SrcFog']['name']),
		'rel' => array('controller' => 'fogs', 'action' => 'tip', $rule['SrcFog']['id']),
	);
	$srcIpAddress = $this->Html->link($rule['SrcFog']['name'], array('controller' => 'fogs', 'action' => 'view', $rule['SrcFog']['id']), $srcFogOptions);
}
if($rule['Rule']['use_src_pog'])
{
	$srcPortTitle = __('P.O.G.');
	$srcPogOptions = array(
		'title' => __('Ports for %s', $rule['SrcPog']['name']),
		'rel' => array('controller' => 'pogs', 'action' => 'tip', $rule['SrcPog']['id']),
	);
	$srcPort = $this->Html->link($rule['SrcPog']['name'], array('controller' => 'pogs', 'action' => 'view', $rule['SrcPog']['id']), $srcPogOptions);
}

$details_blocks[2][1] = array(
	'title' => __('Source Details'),
	'details' => array(
		array('name' => __('FISMA System'), 'value' =>  $this->Html->link($rule['SrcFismaSystem']['name'], array('action' => 'fisma_system', $rule['SrcFismaSystem']['id']), array(
			'title' => __('Details for %s', $rule['SrcFismaSystem']['name']),
			'rel' => array('controller' => 'fisma_systems', 'action' => 'tip', $rule['SrcFismaSystem']['id']),
		)). ' &nbsp;'),
		array('name' => __('%s : %s', $srcIpAddressTitle, $srcPortTitle ), 'value' => __('%s : %s', $srcIpAddress, $srcPort )),
		array('name' => __('Description'), 'value' => $rule['Rule']['src_desc']),
	),
);

$dstIpAddressTitle = __('Ip Address');
$dstIpAddress = ($rule['Rule']['dst_ip']?$this->Local->hostAliasTip($rule['Rule']['dst_ip']):'&nbsp;');
$dstPortTitle = __('Port');
$dstPort = ($rule['Rule']['dst_port']?$rule['Rule']['dst_port']:'&nbsp;');
if($rule['Rule']['use_dst_fog'])
{
	$dstIpAddressTitle = __('F.O.G.');
	$dstFogOptions = array(
		'title' => __('IP Addresses for %s', $rule['DstFog']['name']),
		'rel' => array('controller' => 'fogs', 'action' => 'tip', $rule['DstFog']['id']),
	);
	$dstIpAddress = $this->Html->link($rule['DstFog']['name'], array('controller' => 'fogs', 'action' => 'view', $rule['DstFog']['id']), $dstFogOptions);
}
if($rule['Rule']['use_dst_pog'])
{
	$dstPortTitle = __('P.O.G.');
	$dstPogOptions = array(
		'title' => __('Ports for %s', $rule['DstPog']['name']),
		'rel' => array('controller' => 'pogs', 'action' => 'tip', $rule['DstPog']['id']),
	);
	$dstPort = $this->Html->link($rule['DstPog']['name'], array('controller' => 'pogs', 'action' => 'view', $rule['DstPog']['id']), $dstPogOptions);
}

$details_blocks[2][2] = array(
	'title' => __('Destination Details'),
	'details' => array(
		array('name' => __('FISMA System'), 'value' =>  $this->Html->link($rule['DstFismaSystem']['name'], array('action' => 'fisma_system', $rule['DstFismaSystem']['id']), array(
			'title' => __('Details for %s', $rule['DstFismaSystem']['name']),
			'rel' => array('controller' => 'fisma_systems', 'action' => 'tip', $rule['DstFismaSystem']['id']),
		)). ' &nbsp;'),
		array('name' => __('%s : %s', $dstIpAddressTitle, $dstPortTitle ), 'value' => __('%s : %s', $dstIpAddress, $dstPort )),
		array('name' => __('Description'), 'value' => $rule['Rule']['dst_desc']),
	),
);
		
$tabs = array();
$tabs[] = array(
	'key' => 'comments',
	'title' => __('Comments'),
	'content' => $this->Wrap->descView($rule['Rule']['comments']),
);
$tabs[] = array(
	'key' => 'review_logs',
	'title' => __('Review Logs'),
	'url' => array('controller' => 'review_state_logs', 'action' => 'rule', $rule['Rule']['id']),
);
if(trim($rule['Rule']['raw']))
{
	$tabs[] = array(
		'key' => 'original',
		'title' => __('Original Rule'),
		'content' => $this->Wrap->descView($rule['Rule']['raw']),
	);
}


echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('Rule Details'),
	'page_subtitle2' => $rule['Rule']['compiled'],
	'page_options' => $page_options,
	'details_blocks' => $details_blocks,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));