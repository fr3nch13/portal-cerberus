<?php 
	
$th = array(
	'Import.name' => array('content' => __('Import Name')),
	'Import.filename' => array('content' => __('Import Filename')),
	'Rule.id' => array('content' => __('ID'), 'options' => array('sort' => 'Rule.id')),
	'Fw_Int' => array(
		'contents' => array(
			'FwInt.name' => array('content' => __('Firewall Path'), 'options' => array('sort' => 'FwInt.name')),
			'Firewall.name' => array('content' => __('Firewall'), 'options' => array('sort' => 'Firewall.name')),
		),
		'options' => array('delim' => '/'),
	),
	'Rule.permit' => array('content' => __('Permit'), 'options' => array('sort' => 'Rule.permit')),
	'Protocol.name' => array('content' => __('Protocol'), 'options' => array('sort' => 'Protocol.name')),
	'SrcFogName_RuleSrc_ip' => array(
		'contents' => array(
			array('content' => __('Src F.O.G.'), 'options' => array('sort' => 'SrcFog.name', 'title' => __('Firewall Object Group'))),
			array('content' => __('Src Ip'), 'options' => array('sort' => 'Rule.src_ip')),
		),
		'options' => array('delim' => '/'),
	),
	'SrcOrgs' => array('content' => __('SRC Orgs')),
	'SrcDivisions' => array('content' => __('SRC Divisions')),
	'SrcBranches' => array('content' => __('SRC Branches')),
	'SrcFismaSystems' => array('content' => __('SRC FISMA Systems')),
	'DstFogName_RuleDst_ip' => array(
		'contents' => array(
			array('content' => __('Dst F.O.G.'), 'options' => array('sort' => 'DstFog.name', 'title' => __('Firewall Object Group'))),
			array('content' => __('Dst Ip'), 'options' => array('sort' => 'Rule.dst_ip')),
		),
		'options' => array('delim' => '/'),
	),
	'DstOrgs' => array('content' => __('DST Orgs')),
	'DstDivisions' => array('content' => __('DST Divisions')),
	'DstBranches' => array('content' => __('DST Branches')),
	'DstFismaSystems' => array('content' => __('DST FISMA Systems')),
	'Rule.created' => array('content' => __('Created'), 'options' => array('sort' => 'Rule.created')),
);

$td = array();
foreach ($rules as $i => $rule)
{
	$fwInt = $rule['Firewall']['hostname'];
	if(!$fwInt)
		$fwInt = $rule['Firewall']['name'];
	if($rule['Rule']['use_fw_int'])
	{
		$fwInt = $rule['FwInt']['name'];
	}
	
	$srcFogIp = $rule['Rule']['src_ip'];
	if($rule['Rule']['use_src_fog'])
	{
		$srcFogOptions = array(
			'title' => __('IP Addresses for %s', $rule['SrcFog']['name']),
			'rel' => array('controller' => 'fogs', 'action' => 'tip', $rule['SrcFog']['id'], 'admin' => false),
		);
		$srcFogIp = $this->Html->link($rule['SrcFog']['name'], array('controller' => 'fogs', 'action' => 'view', $rule['SrcFog']['id']), $srcFogOptions);
	}

	$dstFogIp = $rule['Rule']['dst_ip'];
	if($rule['Rule']['use_dst_fog'])
	{
		$dstFogOptions = array(
			'title' => __('IP Addresses for %s', $rule['DstFog']['name']),
			'rel' => array('controller' => 'fogs', 'action' => 'tip', $rule['DstFog']['id'], 'admin' => false),
		);
		$dstFogIp = $this->Html->link($rule['DstFog']['name'], array('controller' => 'fogs', 'action' => 'view', $rule['DstFog']['id']), $dstFogOptions);
	}
	
	$srcOrgs = '';
	$srcDivisions = '';
	$srcBranches = '';
	$srcFismaSystems = '';
	if(preg_match('/^any(\d+)?/i', $srcFogIp))
	{
		$srcOrgs = $srcDivisions = $srcBranches = $srcFismaSystems = __('Any system');
	}
	elseif(isset($rule['SrcFismaSystems']) and count($rule['SrcFismaSystems']))
	{
		$orgs = [];
		$divisions = [];
		$branches = [];
		$systems = [];
		foreach($rule['SrcFismaSystems'] as $srcFismaSystem)
		{
			$systemName = $srcFismaSystem['SrcFismaSystem']['name'];
			$systems[$systemName] = $systemName;
			
			if(isset($srcFismaSystem['OwnerContact']['Sac']['Branch']['id']) 
				and $srcFismaSystem['OwnerContact']['Sac']['Branch']['id'])
			{
				$branchName = $srcFismaSystem['OwnerContact']['Sac']['Branch']['shortname'];
				$branches[$branchName] = $branchName;
			}
			if(isset($srcFismaSystem['OwnerContact']['Sac']['Branch']['Division']['id']) 
				and $srcFismaSystem['OwnerContact']['Sac']['Branch']['Division']['id'])
			{
				$divisionName = $srcFismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname'];
				$divisions[$divisionName] = $divisionName;
			}
			if(isset($srcFismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['id']) 
				and $srcFismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['id'])
			{
				$orgName = $srcFismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname'];
				$orgs[$orgName] = $orgName;
			}
		}
		$srcOrgs = implode(', ', $orgs);
		$srcDivisions = implode(', ', $divisions);
		$srcBranches = implode(', ', $branches);
		$srcFismaSystems = implode(', ', $systems);
	}
	else
	{
		$srcOrgs = $srcDivisions = $srcBranches = $srcFismaSystems = __('Not associated');
	}
	
	$dstOrgs = '';
	$dstDivisions = '';
	$dstBranches = '';
	$dstFismaSystems = '';
	if(preg_match('/^any(\d+)?/i', $dstFogIp))
	{
		$dstOrgs = $dstDivisions = $dstBranches = $dstFismaSystems = __('Any system');
	}
	elseif(isset($rule['DstFismaSystems']) and count($rule['DstFismaSystems']))
	{
		$orgs = [];
		$divisions = [];
		$branches = [];
		$systems = [];
		foreach($rule['DstFismaSystems'] as $dstFismaSystem)
		{
			$systemName = $dstFismaSystem['DstFismaSystem']['name'];
			$systems[$systemName] = $systemName;
			
			if(isset($dstFismaSystem['OwnerContact']['Sac']['Branch']['id']) 
				and $dstFismaSystem['OwnerContact']['Sac']['Branch']['id'])
			{
				$branchName = $dstFismaSystem['OwnerContact']['Sac']['Branch']['shortname'];
				$branches[$branchName] = $branchName;
			}
			if(isset($dstFismaSystem['OwnerContact']['Sac']['Branch']['Division']['id']) 
				and $dstFismaSystem['OwnerContact']['Sac']['Branch']['Division']['id'])
			{
				$divisionName = $dstFismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname'];
				$divisions[$divisionName] = $divisionName;
			}
			if(isset($dstFismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['id']) 
				and $dstFismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['id'])
			{
				$orgName = $dstFismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['shortname'];
				$orgs[$orgName] = $orgName;
			}
		}
		$dstOrgs = implode(', ', $orgs);
		$dstDivisions = implode(', ', $divisions);
		$dstBranches = implode(', ', $branches);
		$dstFismaSystems = implode(', ', $systems);
	}
	else
	{
		$dstOrgs = $dstDivisions = $dstBranches = $dstFismaSystems = __('Not associated');
	}
	
	$td[$i] = array(
		$rule['Import']['name'],
		$rule['Import']['filename'],
		$this->Html->link($rule['Rule']['id'], array('action' => 'view', $rule['Rule']['id']), array('title' => $rule['Rule']['compiled'])),
		$fwInt,
		$this->Local->permitDetail($rule['Rule']['permit']),
		$this->Html->link($rule['Protocol']['name'], array('controller' => 'protocols', 'action' => 'view', $rule['Protocol']['id'])),
		$srcFogIp,
		$srcOrgs,
		$srcDivisions,
		$srcBranches,
		$srcFismaSystems,
		$dstFogIp,
		$dstOrgs,
		$dstDivisions,
		$dstBranches,
		$dstFismaSystems,
		$this->Wrap->niceTime($rule['Rule']['created']),
	);
}

$page_subtitle = (isset($page_subtitle)?$page_subtitle:__('All with %s', __('FISMA Systems')));

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Rules'),
	'page_subtitle' => $page_subtitle,
	'th' => $th,
	'td' => $td,
	'use_filter' => false,
	'use_search' => false,
	'use_pagination' => false,
	'show_refresh_table' => false,
	'use_collapsible_columns' => false,
	'auto_load_ajax' => false,
	'use_float_head' => false,
	'use_jsordering' => false,
	'use_js_search' => false,
));