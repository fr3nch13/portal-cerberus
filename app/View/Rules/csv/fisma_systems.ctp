<?php 
$this->Html->setFull(true);

$data = [];
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
		$srcFogIp = $rule['SrcFog']['name'];

	$dstFogIp = $rule['Rule']['dst_ip'];
	if($rule['Rule']['use_dst_fog'])
	{
		$dstFogIp = $rule['DstFog']['name'];
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
	
    $data[] = [
		'Import.name' => $rule['Import']['name'],
		'Import.filename' => $rule['Import']['filename'],
		'Rule.id' => $rule['Rule']['id'],
		'Firewall.name' => $fwInt,
		'Rule.permit' => $this->Local->permit($rule['Rule']['permit']),
		'Protocol.name' => $rule['Protocol']['name'],
		'Src.ip_address' => $srcFogIp,
		'Src.Orgs' => $srcOrgs,
		'Src.Divisions' => $srcDivisions,
		'Src.Branches' => $srcBranches,
		'Src.FismaSystems' => $srcFismaSystems,
		'Dst.ip_address' => $dstFogIp,
		'Dst.Orgs' => $dstOrgs,
		'Dst.Divisions' => $dstDivisions,
		'Dst.Branches' => $dstBranches,
		'Dst.FismaSystems' => $dstFismaSystems,
    ];
}

echo $this->Exporter->view($data, ['count' => count($data)], $this->request->params['ext'], Inflector::camelize(Inflector::singularize($this->request->params['controller'])));