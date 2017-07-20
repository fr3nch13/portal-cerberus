<?php

// app/View/Helper/WrapHelper.php
App::uses('AppHelper', 'View/Helper');

/*
 * A helper used specifically for this app
 */
class LocalHelper extends AppHelper 
{
	public $helpers = array('Html', 'Utilities.Wrap', 'Upload.Avatar', 'ReportResults');
	
	public function emailOptions($option = false)
	{
		$options = Configure::read('Options.review_state_email');
		if($option === false)
		{
			return $options;
		}
		if(!isset($options[$option]))
		{
			return false;
		}
		return $options[$option];
	}
	
	public function reviewTimes($selected = false)
	{
		if($selected === null) return ' '; // not even midnight is selected
		if($selected !== false)
		{
			$selected = (int)$selected;
		}
		$review_times = range(0, 23);
		$formated_times = array();
		foreach($review_times as $hour)
		{
			$nice = $hour. ' am';
			if($hour > 12)
			{
				$nice = ($hour - 12). ' pm';
			}
			if($hour == 12) $nice = 'Noon';
			if($hour == 0) $nice = 'Midnight';
			$formated_times[$hour] = $nice;
 		}
 		if(is_int($selected)) return $formated_times[$selected];
 		return $formated_times;
	}
	
	public function permit($permit = 0)
	{
		return ($permit?__('permit'):__('deny'));
	}
	
	public function hostAliasTip($host = false)
	{
		$options = array(
			'title' => __('Alias for %s', $host),
			'rel' => $this->Html->url(array('controller' => 'host_aliases', 'action' => 'tip', base64_encode($host), 'admin' => false)),
		);
		
		return $this->Html->tag('span', $host, $options);
	}
	
	public function simpleLink($simple = false, $id = false, $controller = false)
	{
		$simple = $this->Wrap->yesNo($simple);
		
		if(!$controller) $controller = $this->request->params['controller'];
		
		return $this->Html->link($simple, array('controller' => $controller, 'action' => 'toggle', 'simple', $id), array('confirm' => 'Are you sure?'));
	}
	
	public function permitDetail($key = 0)
	{
		$permit_map = Configure::read('Options.rule_permit_map');
		if(isset($permit_map[$key])) return $permit_map[$key];
		
		return $permit_map;
	}
	
	public function permitMap($key = false)
	{
		$permit_map = Configure::read('Options.rule_permit_map');
		if($key !== false)
		{
			if(isset($permit_map[$key])) return $permit_map[$key];
		}
		
		return $permit_map;
	}
	
	public function protocolMap($key = false)
	{
		$protocol_map = Configure::read('Options.rule_protocol_map');
		if($key !== false)
		{
			if(isset($protocol_map[$key])) return $protocol_map[$key];
		}
		
		return $protocol_map;
	}
	
	public function notificationMap($key = 0)
	{
		$notification_map = Configure::read('Options.rule_notification_map');
		if($key)
		{
			if(isset($notification_map[$key])) return $notification_map[$key];
		}
		
		return $notification_map;
	}
	
	public function diffListsView($new = null, $old = null)
	{
		$diffs = $this->diffLists($new, $old);
		
		$out = $this->_View->element('Utilities.block', array('title' => __('Added'), 'items' => $diffs['added']));
		$out .= $this->_View->element('Utilities.block', array('title' => __('Removed'), 'items' => $diffs['removed']));
		return $out;
	}
	
	public function diffLists($new = null, $old = null)
	{
		if(!is_array($new))
			$new = $this->strToArray($new);
		sort($new);
		
		if(!is_array($old))
			$old = $this->strToArray($old);
		sort($old);
		
		$added = array_diff($new, $old);
		$removed = array_diff($old, $new);
		
		return array('added' => $added, 'removed' => $removed);
	}
	
	public function strToArray($string = false, $regex_split = '/(\n+|,)/')
	{
		$string = preg_split($regex_split, $string);
		foreach($string as $i => $val)
		{
			$val = trim($val);
			if(!$val) unset($string[$i]);
			else $string[$i] = $val;
		}
		$string = array_flip($string);
		$string = array_flip($string);
		return $string;
	}
	
	public function mapRulesToTable($rules = array(), $variables = array())
	{
		foreach($variables as $name => $val)
		{
			${$name} = $val;
		}
	
$th = array(
	'Rule.id' => array('content' => __('ID'), 'options' => array('sort' => 'Rule.id')),
	'Fw_Int' => array(
		'contents' => array(
			'FwInt.name' => array('content' => __('Firewall Path'), 'options' => array('sort' => 'FwInt.name')),
			'Firewall.name' => array('content' => __('Firewall'), 'options' => array('sort' => 'Firewall.name')),
			'FwInterface.name' => array('content' => __('Interface'), 'options' => array('sort' => 'FwInterface.name')),
		),
		'options' => array('delim' => '/'),
	),
	'Rule.permit' => array('content' => __('Permit'), 'options' => array('sort' => 'Rule.permit')),
	'Protocol.name' => array('content' => __('Protocol'), 'options' => array('sort' => 'Protocol.name')),
//	'SrcFismaSystem.name' => array('content' => __('Src FISMA Sys'), 'options' => array('sort' => 'SrcFismaSystem.name')),
	
	'SrcFogName_RuleSrc_ip' => array(
		'contents' => array(
			array('content' => __('Src F.O.G.'), 'options' => array('sort' => 'SrcFog.name', 'title' => __('Firewall Object Group'))),
			array('content' => __('Src Ip'), 'options' => array('sort' => 'Rule.src_ip')),
		),
		'options' => array('delim' => '/'),
	),
	'SrcpogName_RuleSrc_port' => array(
		'contents' => array(
			array('content' => __('Src P.O.G.'), 'options' => array('sort' => 'SrcPog.name', 'title' => __('Port Object Group'))),
			array('content' => __('Src Port'), 'options' => array('sort' => 'Rule.src_port')),
		),
		'options' => array('delim' => '/'),
	),
//	'DstFismaSystem.name' => array('content' => __('Dst FISMA Sys'), 'options' => array('sort' => 'DstFismaSystem.name')),
	'DstFogName_RuleDst_ip' => array(
		'contents' => array(
			array('content' => __('Dst F.O.G.'), 'options' => array('sort' => 'DstFog.name', 'title' => __('Firewall Object Group'))),
			array('content' => __('Dst Ip'), 'options' => array('sort' => 'Rule.dst_ip')),
		),
		'options' => array('delim' => '/'),
	),
	'DstpogName_RuleDst_port' => array(
		'contents' => array(
			array('content' => __('Dst P.O.G.'), 'options' => array('sort' => 'DstPog.name', 'title' => __('Port Object Group'))),
			array('content' => __('Dst Port'), 'options' => array('sort' => 'Rule.dst_port')),
		),
		'options' => array('delim' => '/'),
	),
//	'Rule.poc_email' => array('content' => __('Rule POC Email'), 'options' => array('sort' => 'Rule.poc_email')),
	'ReviewState.name' => array('content' => __('Review State'), 'options' => array('sort' => 'ReviewState.name')),
//	'RuleAddedUser.name' => array('content' => __('Created'), 'options' => array('sort' => 'RuleAddedUser.name')),
//	'RuleModifiedUser.name' => array('content' => __('Last Updated'), 'options' => array('sort' => 'RuleModifiedUser.name')),
	'RuleReviewedUser.name' => array('content' => __('Last Reviewed'), 'options' => array('sort' => 'RuleReviewedUser.name')),
	'Rule.created' => array('content' => __('Created'), 'options' => array('sort' => 'Rule.created')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
	'multiselect' => $use_multiselect,
);

$td = array();
foreach ($rules as $i => $rule)
{
/*
		$tmp = array('User' => $rule['RuleAddedUser']);
	$RuleAddedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
	
	$RuleModifiedUser = '&nbsp;';
	if(isset($rule['RuleModifiedUser']['name']))
	{
		$tmp = array('User' => $rule['RuleModifiedUser']);
		$RuleModifiedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
	}
*/
	$RuleReviewedUser = '&nbsp;';
	if(isset($rule['RuleReviewedUser']['name']))
	{
		$tmp = array('User' => $rule['RuleReviewedUser']);
		$RuleReviewedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
	}
	
	$edit_state_link = false;
	if($reviewer_admin)
	{
		$edit_state_link = $this->Html->link(__('Change State'), array('action' => 'edit_state', $rule['Rule']['id']));
	}
	
	$fwInt = $this->Html->link($rule['Firewall']['name'], array('controller' => 'firewalls', 'action' => 'view', $rule['Firewall']['id']), array('title' => __('Firewall')));
	$fwInt .= ' &amp; ';
	$fwInt .= $this->Html->link($rule['FwInterface']['name'], array('controller' => 'fw_interfaces', 'action' => 'view', $rule['FwInterface']['id']), array('title' => __('Interface')));
	if($rule['Rule']['use_fw_int'])
	{
		$fwInt = $this->Html->link($rule['FwInt']['name'], array('controller' => 'fw_ints', 'action' => 'view', $rule['FwInt']['id']), array(
			'title' => __('Details for %s', $rule['FwInt']['name']),
			'rel' => array('controller' => 'fw_ints', 'action' => 'tip', $rule['FwInt']['id']),
		));
	}
	
	$srcFogIp = $this->hostAliasTip($rule['Rule']['src_ip']);
	if($rule['Rule']['use_src_fog'])
	{
		$srcFogOptions = array(
			'title' => __('IP Addresses for %s', $rule['SrcFog']['name']),
			'rel' => array('controller' => 'fogs', 'action' => 'tip', $rule['SrcFog']['id'], 'admin' => false),
		);
		$srcFogIp = $this->Html->link($rule['SrcFog']['name'], array('controller' => 'fogs', 'action' => 'view', $rule['SrcFog']['id']), $srcFogOptions);
	}
	
	$srcPogPort = $rule['Rule']['src_port'];
	if($rule['Rule']['use_src_pog'])
	{
		$srcPogOptions = array(
			'title' => __('Ports for %s', $rule['SrcPog']['name']),
			'rel' => array('controller' => 'pogs', 'action' => 'tip', $rule['SrcPog']['id'], 'admin' => false),
		);
		$srcPogPort = $this->Html->link($rule['SrcPog']['name'], array('controller' => 'pogs', 'action' => 'view', $rule['SrcPog']['id']), $srcPogOptions);
	}

	$dstFogIp = $this->hostAliasTip($rule['Rule']['dst_ip']);
	if($rule['Rule']['use_dst_fog'])
	{
		$dstFogOptions = array(
			'title' => __('IP Addresses for %s', $rule['DstFog']['name']),
			'rel' => array('controller' => 'fogs', 'action' => 'tip', $rule['DstFog']['id']),
		);
		$dstFogIp = $this->Html->link($rule['DstFog']['name'], array('controller' => 'fogs', 'action' => 'view', $rule['DstFog']['id']), $dstFogOptions);
	}
	
	$dstPogPort = $rule['Rule']['dst_port'];
	if($rule['Rule']['use_dst_pog'])
	{
		$dstPogOptions = array(
			'title' => __('Ports for %s', $rule['DstPog']['name']),
			'rel' => array('controller' => 'pogs', 'action' => 'tip', $rule['DstPog']['id']),
		);
		$dstPogPort = $this->Html->link($rule['DstPog']['name'], array('controller' => 'pogs', 'action' => 'view', $rule['DstPog']['id']), $dstPogOptions);
	}
	
	$td[$i] = array(
		$this->Html->link($rule['Rule']['id'], array('action' => 'view', $rule['Rule']['id']), array('title' => $rule['Rule']['compiled'])),
		$fwInt,
		$this->permitDetail($rule['Rule']['permit']),
		$this->Html->link($rule['Protocol']['name'], array('controller' => 'protocols', 'action' => 'view', $rule['Protocol']['id'])),
/*
		$this->Html->link($rule['SrcFismaSystem']['name'], array('controller' => 'rules', 'action' => 'fisma_system', $rule['SrcFismaSystem']['id'])array(
			'title' => __('Details for %s', $rule['SrcFismaSystem']['name']),
			'rel' => array('controller' => 'fisma_systems', 'action' => 'tip', $rule['SrcFismaSystem']['id']),
		)),
*/
		$srcFogIp,
		$srcPogPort,
/*
		$this->Html->link($rule['DstFismaSystem']['name'], array('controller' => 'rules', 'action' => 'fisma_system', $rule['DstFismaSystem']['id'])array(
			'title' => __('Details for %s', $rule['DstFismaSystem']['name']),
			'rel' => array('controller' => 'fisma_systems', 'action' => 'tip', $rule['DstFismaSystem']['id']),
		)),
*/
		$dstFogIp,
		$dstPogPort,
//		$rule['Rule']['poc_email'],
		$rule['ReviewState']['name'],
//		$RuleAddedUser,
//		$RuleModifiedUser,
		$RuleReviewedUser,
		$this->Wrap->niceTime($rule['Rule']['created']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $rule['Rule']['id'], 'admin' => false)). 
			$this->Html->link(__('Edit'), array('action' => 'edit', $rule['Rule']['id'], 'admin' => false)). 
			$this->Html->link(__('Clone'), array('action' => 'add', $rule['Rule']['id'], 'admin' => false)).
			$edit_state_link,
			array('class' => 'actions'),
		),
		'multiselect' => $rule['Rule']['id'],
	);
}
	return array($th, $td);
	}
	
	public function createFismaSystemsList($fisma_systems = array(), $threshold = 5)
	{
		if(count($fisma_systems) > $threshold)
		{
			return count($fisma_systems);
		}
		
		$links = array();
		foreach($fisma_systems as $fisma_system)
		{
			$links[] = $this->Html->link($fisma_system['name'], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system['id'], 'admin' => false, 'saa' => false, 'plugin' => false));
		}
		return implode(', ', $links);
	}
	
	public function ticketLinks($tickets = false)
	{
		return $this->ReportResults->ticketLinks($tickets);
	}
	
	public function waiverLinks($tickets = false)
	{
		return $this->ReportResults->waiverLinks($tickets);
	}
	
	public function crLinks($tickets = false)
	{
		return $this->ReportResults->crLinks($tickets);
	}
}