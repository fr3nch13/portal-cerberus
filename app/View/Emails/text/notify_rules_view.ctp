<?php

$this->Html->setFull(true);
$this->Html->asText(true);

$page_options = array(
	$this->Html->link(__("View this %s", __('Rule')), array('controller' => 'rules', 'action' => 'view', $rule['Rule']['id'])),
);

$tmp = array('User' => $rule['RuleAddedUser']);
$RuleAddedUser = $this->Html->link($tmp['User']['name'], array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));  
$RuleModifiedUser = '';
if($rule['RuleModifiedUser']['id'])
{
	$tmp = array('User' => $rule['RuleModifiedUser']);
	$RuleModifiedUser = $this->Html->link($tmp['User']['name'], array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));  
}
$RuleReviewedUser = '';
if($rule['RuleReviewedUser']['id'])
{
	$tmp = array('User' => $rule['RuleReviewedUser']);
	$RuleReviewedUser = $this->Html->link($tmp['User']['name'], array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));  
}

$details_blocks = array();

$details_blocks[1][] = array(
	'title' => __('Details'),
	'details' => array(
		array('name' => __('ID'), 'value' => $rule['Rule']['id']),
		array('name' => __('Review State'), 'value' =>  $rule['ReviewState']['name']),
		array('name' => __('Rule POC Email'), 'value' => $rule['Rule']['poc_email']),
		array('name' => __('Related Tickets'), 'value' => $this->Wrap->descView($rule['Rule']['ticket'])),
		array('name' => __('Firewall'), 'value' => $this->Html->link($rule['Firewall']['name'], array('action' => 'firewall', $rule['Firewall']['id']))),
		array('name' => __('Interface'), 'value' => $rule['FwInterface']['name']),
		array('name' => __('Protocol'), 'value' => $this->Local->protocolMap($rule['Rule']['protocol'])),
	),
);

$details_blocks[1][] = array(
	'title' => __('Dates &amp; Users'),
	'details' => array(
		array('name' => __('Created'), 'value' => $this->Wrap->niceTime($rule['Rule']['created'])),
//		array('name' => __('Created By'), 'value' => $RuleAddedUser),
		array('name' => __('Last Updated'), 'value' => $this->Wrap->niceTime($rule['Rule']['modified'])),
//		array('name' => __('Last Updated By'), 'value' => $RuleModifiedUser),
		array('name' => __('Reviewed'), 'value' => $this->Wrap->niceTime($rule['Rule']['reviewed'])),
//		array('name' => __('Reviewed By'), 'value' => $RuleReviewedUser),
	),
);

$details_blocks[2][] = array(
	'title' => __('Source Details'),
	'details' => array(
		array('name' => __('FISMA System'), 'value' =>  $this->Html->link($rule['SrcFismaSystem']['name'], array('action' => 'fisma_system', $rule['SrcFismaSystem']['id']))),
		array('name' => __('Ip Address : Port'), 'value' => __('%s : %s', $rule['Rule']['src_ip'], $rule['Rule']['src_port'])),
		array('name' => __('Description'), 'value' => $rule['Rule']['src_desc']),
	),
);

$details_blocks[2][] = array(
	'title' => __('Destination Details'),
	'details' => array(
		array('name' => __('FISMA System'), 'value' =>  $this->Html->link($rule['DstFismaSystem']['name'], array('action' => 'fisma_system', $rule['DstFismaSystem']['id']))),
		array('name' => __('Ip Address : Port'), 'value' => __('%s : %s', $rule['Rule']['dst_ip'], $rule['Rule']['dst_port'])),
		array('name' => __('Description'), 'value' => $rule['Rule']['dst_desc']),
	),
);

echo $this->element('Utilities.email_text_view_columns', array(
	'page_title' => __('Rule Notification'),
	'details_blocks' => $details_blocks,
	'page_options' => $page_options,
));
