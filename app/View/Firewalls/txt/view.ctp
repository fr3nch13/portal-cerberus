<?php 
$out = array();

$logsep = '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ';
$mid_comment = '!!!!!-- ';
$short_comment = '!-- ';

$use_comments = (isset($this->request->params['named']['comments'])?$this->request->params['named']['comments']:false);

////////////// PAGE HEADER
//if($use_comments)
if(true) // told to keep these comments
{
	$out[] = $logsep;
	$comments = $this->Common->makeList(array(
		'Exported On' => date('Y-m-d H:i:s'),
		'Cerberus Url' => $this->Html->url($this->Html->urlModify(array('full_base' => true))),
		'Description' => __('This is an export of selected firewall rules and related groups from FO Cerberus'),
	), 80, $mid_comment);
	$out = array_merge($out, $comments);
	$out[] = $logsep;
	$out[] = '';
}

////////////// FIREWALL INFO
//if($use_comments)
if(true) // told to keep these comments
{
	$out[] = __('%s%s', $mid_comment, __('%s Specific Information', __('Firewall')) );
	$comments = $this->Common->makeList(array(
		'Name' => $firewall['Firewall']['name'],
		'Hostname' => $firewall['Firewall']['hostname'],
		'Domain Name' => $firewall['Firewall']['domain_name'],
		'Slug' => $firewall['Firewall']['slug'],
		'Added to Cerberus By' => __('%s (%s)', $firewall['FirewallAddedUser']['name'].' ', $firewall['FirewallAddedUser']['email'].' '),
		'Added to Cerberus On' => $firewall['Firewall']['created'],
		'# Rules in Cerberus' => $firewall['Firewall']['counts']['Rule.all'],
		'Imported From Name' => $firewall['Import']['name'],
		'Imported From File' => $firewall['Import']['filename'],
		'Cerberus URI' => $this->Html->url(array('controller' => 'firewalls', 'action' => 'view', $firewall['Firewall']['id'], 'full_base' => true)),
	), 80, $short_comment);
	$out = array_merge($out, $comments);
}

$firewall_lines = $this->Common->makeList(array(
	'hostname' => $firewall['Firewall']['hostname'],
	'domain-name' => $firewall['Firewall']['domain_name'],
), 1000, false, false, false);
$out = array_merge($out, $firewall_lines);


////////////// ALIASES
if($use_comments)
{
	$out[] = '';
	$out[] = __('%s%s', $mid_comment, __('%s/%s %s', __('Hostname'), __('Ip Address'), __('Aliases')) );
	$out[] = __('%s%s', $mid_comment, $this->Html->url(array('controller' => 'host_aliases', 'action' => 'index', 'full_base' => true)) );
}

$out[] = 'names';
foreach($compiled['aliases'] as $ipaddress => $aliases)
{
	foreach($aliases as $alias)
	{
		$out[] = __("name %s\t%s", $ipaddress, $alias);
	}
}


////////////// FIREWALL OBJECT GROUPS
if($use_comments)
{
	$out[] = '';
	$out[] = __('%s%s', $mid_comment, __('Firewall Object Groups') );
	$out[] = __('%s%s', $mid_comment, $this->Html->url(array('controller' => 'fogs', 'action' => 'index', 'full_base' => true)) );
}

foreach($compiled['fogs'] as $fog)
{
	if($use_comments)
	{
		$out[] = '';
		$comments = $this->Common->makeList(array(
			'Name' => $fog['name'],
			'Slug' => $fog['slug'],
			'Added to Cerberus On' => $fog['created'],
			'Cerberus URI' => $this->Html->url(array('controller' => 'fogs', 'action' => 'view', $fog['id'], 'full_base' => true)),
		), 80, $short_comment);
		$out = array_merge($out, $comments);
	}
	$fog_compiled = explode("\n", $fog['compiled']);
	$out = array_merge($out, $fog_compiled);
}


////////////// PORT OBJECT GROUPS
if($use_comments)
{
	$out[] = '';
	$out[] = __('%s%s', $mid_comment, __('Port Object Groups') );
	$out[] = __('%s%s', $mid_comment, $this->Html->url(array('controller' => 'pogs', 'action' => 'index', 'full_base' => true)) );
}

foreach($compiled['pogs'] as $pog)
{
	if($use_comments)
	{
		$out[] = '';
		$comments = $this->Common->makeList(array(
			'Name' => $pog['name'],
			'Slug' => $pog['slug'],
			'Added to Cerberus On' => $pog['created'],
			'Cerberus URI' => $this->Html->url(array('controller' => 'pogs', 'action' => 'view', $pog['id'], 'full_base' => true)),
		), 80, $short_comment);
		$out = array_merge($out, $comments);
	}
	$pog_compiled = explode("\n", $pog['compiled']);
	$out = array_merge($out, $pog_compiled);
}


////////////// RULES
if($use_comments)
{
	$out[] = '';
	$out[] = __('%s%s', $mid_comment, __('Rules') );
	$out[] = __('%s%s', $mid_comment, $this->Html->url(array('controller' => 'rules', 'action' => 'index', 'full_base' => true)) );
	$out[] = __('%s%s', $mid_comment, __('Please check the order of these rules if the order applies here.') );
}

foreach($compiled['rules'] as $rule)
{
	if($use_comments)
	{
		$out[] = '';
		$listdata = array(
			'POC Email' => $rule['Rule']['poc_email'],
			'Ticket' => $rule['Rule']['ticket'],
			'Cerberus URI' => $this->Html->url(array('controller' => 'rules', 'action' => 'view', $rule['Rule']['id'], 'full_base' => true)),
			'Added to Cerberus By' => __('%s (%s)', $rule['RuleAddedUser']['name'], $rule['RuleAddedUser']['email']),
			'Added to Cerberus On' => $rule['Rule']['created'],
			'Modified in Cerberus By' => ' ',
			'Modified in Cerberus On' => ' ',
			'Reviewed in Cerberus By' => ' ',
			'Reviewed in Cerberus On' => ' ',
		);
		if(isset($rule['RuleModifiedUser']['id']) and $rule['RuleModifiedUser']['id'])
		{
			$listdata['Modified in Cerberus By'] = __('%s (%s)', $rule['RuleModifiedUser']['name'], $rule['RuleModifiedUser']['email']);
			$listdata['Modified in Cerberus On'] = $rule['Rule']['modified'];
		}
		if(isset($rule['RuleReviewedUser']['id']) and $rule['RuleReviewedUser']['id'])
		{
			$listdata['Reviewed in Cerberus By'] = __('%s (%s)', $rule['RuleReviewedUser']['name'], $rule['RuleReviewedUser']['email']);
			$listdata['Reviewed in Cerberus On'] = $rule['Rule']['reviewed'];
		}
		$comments = $this->Common->makeList($listdata, 80, $short_comment);
		$out = array_merge($out, $comments);
	}
	
	if(trim($rule['Rule']['remarks']))
		$out[] = __('access-list inside_access remark %s', $rule['Rule']['remarks']);
	
	if(trim($rule['Rule']['compiled']))
		$out[] = $rule['Rule']['compiled'];
	else
		$out[] = $rule['Rule']['raw'];
}
if($this->request->is('windows'))
{
	echo implode("\r\n", $out);
}
else
{
	echo implode("\n", $out);
}