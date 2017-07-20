<?php 
// File: app/View/Emails/html/review_state_emails.ctp

$this->Html->setFull(true);
$this->Html->asText(true);

$page_options = array(
	$this->Html->link('View these Rules', array('controller' => 'rules', 'action' => 'review_state', $review_state['ReviewState']['id'])),
);

// content
$th = array(
	'Rule.id' => array('content' => __('ID'), 'options' => array('sort' => 'Rule.id')),
	'Firewall.name' => array('content' => __('Firewall'), 'options' => array('sort' => 'Firewall.name')),
	'FwInterface.name' => array('content' => __('Int'), 'options' => array('sort' => 'FwInterface.name')),
	'Protocol.name' => array('content' => __('Proto'), 'options' => array('sort' => 'Protocol.name')),
//	'SrcFismaSystem.name' => array('content' => __('Src FISMA Sys'), 'options' => array('sort' => 'SrcFismaSystem.name')),
	'Rule.src_ip' => array('content' => __('Source Ip'), 'options' => array('sort' => 'Rule.src_ip')),
	'Rule.src_port' => array('content' => __('Source Port'), 'options' => array('sort' => 'Rule.src_port')),
//	'DstFismaSystem.name' => array('content' => __('Dst FISMA Sys'), 'options' => array('sort' => 'DstFismaSystem.name')),
	'Rule.dst_ip' => array('content' => __('Destination Ip'), 'options' => array('sort' => 'Rule.dst_ip')),
	'Rule.dst_port' => array('content' => __('Destination Port'), 'options' => array('sort' => 'Rule.dst_port')),
//	'Rule.poc_email' => array('content' => __('Rule POC Email'), 'options' => array('sort' => 'Rule.poc_email')),
	'ReviewState.name' => array('content' => __('Review State'), 'options' => array('sort' => 'ReviewState.name')),
//	'RuleAddedUser.name' => array('content' => __('Created'), 'options' => array('sort' => 'RuleAddedUser.name')),
//	'RuleModifiedUser.name' => array('content' => __('Last Updated'), 'options' => array('sort' => 'RuleModifiedUser.name')),
	'RuleReviewedUser.name' => array('content' => __('Last Reviewed'), 'options' => array('sort' => 'RuleReviewedUser.name')),
	'Rule.created' => array('content' => __('Created'), 'options' => array('sort' => 'Rule.created')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($rules as $i => $rule)
{
/*
	$tmp = array('User' => $rule['RuleAddedUser']);
	$RuleAddedUser = $this->Html->link($tmp['User']['name'], array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));  
	
	$RuleModifiedUser = '&nbsp;';
	if(isset($rule['RuleModifiedUser']['name']))
	{
		$tmp = array('User' => $rule['RuleModifiedUser']);
		$RuleModifiedUser = $this->Html->link($tmp['User']['name'], array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));  
	}
*/
	$RuleReviewedUser = '&nbsp;';
	if(isset($rule['RuleReviewedUser']['name']))
	{
		$tmp = array('User' => $rule['RuleReviewedUser']);
		$RuleReviewedUser = $this->Html->link($tmp['User']['name'], array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));  
	}
	
	$td[$i] = array(
		$this->Html->link($rule['Rule']['id'], array('action' => 'view', $rule['Rule']['id'])),
		$this->Html->link($rule['Firewall']['name'], array('controller' => 'rules', 'action' => 'firewall', $rule['Firewall']['id'])),
		$rule['FwInterface']['name'],
		$rule['Protocol']['name'],
//		$this->Html->link($rule['SrcFismaSystem']['name'], array('controller' => 'rules', 'action' => 'fisma_system', $rule['SrcFismaSystem']['id'])),
		$rule['Rule']['src_ip'],
		$rule['Rule']['src_port'],
//		$this->Html->link($rule['DstFismaSystem']['name'], array('controller' => 'rules', 'action' => 'fisma_system', $rule['DstFismaSystem']['id'])),
		$rule['Rule']['dst_ip'],
		$rule['Rule']['dst_port'],
//		$rule['Rule']['poc_email'],
		$rule['ReviewState']['name'],
//		$RuleAddedUser,
//		$RuleModifiedUser,
		$RuleReviewedUser,
		$this->Wrap->niceTime($rule['Rule']['created']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $rule['Rule']['id'])). ' '. 
			$this->Html->link(__('Edit'), array('action' => 'edit', $rule['Rule']['id'])). ' '. 
			$this->Html->link(__('Clone'), array('action' => 'add', $rule['Rule']['id'])),
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.email_text_index', array(
	'instructions' => $review_state['ReviewState']['instructions'],
	'page_title' => __('%s %s', $review_state['ReviewState']['name'], __('Rules')),
//	'page_description' => $review_state['ReviewState']['instructions'],
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));