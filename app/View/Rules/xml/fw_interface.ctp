<?php
// File: app/View/Rules/xml/fw_interface.ctp
$this->Html->setFull(true);

$data = array();
foreach ($rules as $i => $rule)
{
	$RuleModifiedUserName = false;
	$RuleModifiedUserUri = false;
	if(isset($rule['RuleModifiedUser']['name']))
	{
		$tmp = array('User' => $rule['RuleModifiedUser']);
		$RuleModifiedUserName = $tmp['User']['name'];
		$RuleModifiedUserUri = $this->Html->url(array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));
	}
	
	$RuleReviewedUserName = false;
	$RuleReviewedUserUri = false;
	if(isset($rule['RuleReviewedUser']['name']))
	{
		$tmp = array('User' => $rule['RuleReviewedUser']);
		$RuleReviewedUserName = $tmp['User']['name'];
		$RuleReviewedUserUri = $this->Html->url(array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));
	}
	
	$RuleAddedUserName = false;
	$RuleAddedUserUri = false;
	if(isset($rule['RuleAddedUser']['name']))
	{
		$tmp = array('User' => $rule['RuleAddedUser']);
		$RuleAddedUserName = $tmp['User']['name'];
		$RuleAddedUserUri = $this->Html->url(array('controller' => 'users', 'action' => 'view', $tmp['User']['id']));
	}
	
    $data[] = array(
		'Rule.id' => $rule['Rule']['id'],
		'FwInt.name' => $rule['FwInt']['name'],
		'Firewall.name' => $rule['Firewall']['name'],
		'FwInterface.name' => $rule['FwInterface']['name'],
		'Rule.permit' => $this->Local->permit($rule['Rule']['permit']),
		'Protocol.name' => $rule['Protocol']['name'],
		'SrcFismaSystem.name' => $rule['SrcFismaSystem']['name'],
		'SrcFog.name' => $rule['SrcFog']['name'],
		'SrcFog.ip_addresses' => $rule['SrcFog']['ip_addresses'],
		'SrcPog.name' => $rule['SrcPog']['name'],
		'SrcPog.ports' => $rule['SrcPog']['ports'],
		'Rule.use_src_fog' => $rule['Rule']['use_src_fog'],
		'Rule.use_src_pog' => $rule['Rule']['use_src_pog'],
		'Rule.src_ip' => $rule['Rule']['src_ip'],
		'Rule.src_port' => $rule['Rule']['src_port'],
		'Rule.src_desc' => $rule['Rule']['src_desc'],
		'DstFismaSystem.name' => $rule['DstFismaSystem']['name'],
		'DstFog.name' => $rule['DstFog']['name'],
		'DstFog.ip_addresses' => $rule['DstFog']['ip_addresses'],
		'DstPog.name' => $rule['DstPog']['name'],
		'DstPog.ports' => $rule['DstPog']['ports'],
		'Rule.use_dst_fog' => $rule['Rule']['use_src_fog'],
		'Rule.use_dst_pog' => $rule['Rule']['use_dst_pog'],
		'Rule.dst_ip' => $rule['Rule']['dst_ip'],
		'Rule.dst_port' => $rule['Rule']['dst_port'],
		'Rule.dst_desc' => $rule['Rule']['dst_desc'],
		'Rule.logging' => $rule['Rule']['logging'],
		'ReviewState.name' => $rule['ReviewState']['name'],
		'Rule.reviewed' => $rule['Rule']['reviewed'],
		'RuleReviewedUser.name' => $RuleReviewedUserName,
		'Rule.created' => $rule['Rule']['created'],
		'RuleAddedUser.name' => $RuleAddedUserName,
		'Rule.modified' => $rule['Rule']['modified'],
		'RuleModifiedUser.name' => $RuleModifiedUserName,
		'Rule.uri' => $this->Html->url(array('controller' => 'rules', 'action' => 'view', $rule['Rule']['id'])),
		'FwInt.uri' => $this->Html->url(array('controller' => 'fw_ints', 'action' => 'view', $rule['FwInt']['id'])),
		'Firewall.uri' => $this->Html->url(array('controller' => 'firewalls', 'action' => 'view', $rule['Firewall']['id'])),
		'SrcFismaSystem.uri' => $this->Html->url(array('controller' => 'fisma_systems', 'action' => 'view', $rule['SrcFismaSystem']['id'])),
		'SrcFog.uri' => $this->Html->url(array('controller' => 'fogs', 'action' => 'view', $rule['SrcFog']['id'])),
		'SrcPog.uri' => $this->Html->url(array('controller' => 'pogs', 'action' => 'view', $rule['SrcPog']['id'])),
		'DstFismaSystem.uri' => $this->Html->url(array('controller' => 'fisma_systems', 'action' => 'view', $rule['DstFismaSystem']['id'])),
		'DstFog.uri' => $this->Html->url(array('controller' => 'fogs', 'action' => 'view', $rule['DstFog']['id'])),
		'DstPog.uri' => $this->Html->url(array('controller' => 'pogs', 'action' => 'view', $rule['DstPog']['id'])),
		'RuleReviewedUser.uri' => $RuleReviewedUserUri,
		'RuleAddedUser.uri' => $RuleAddedUserUri,
		'RuleModifiedUser.uri' => $RuleModifiedUserUri,
    );
}

echo $this->Exporter->view($data, array('count' => count($data), 'fw_interface' => $fw_interface), $this->request->params['ext'], Inflector::camelize(Inflector::singularize($this->request->params['controller'])));
