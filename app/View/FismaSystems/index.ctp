<?php 

$page_subtitle = (isset($page_subtitle)?$page_subtitle:false);

// try to build the breadscrumb
if(!$page_subtitle and isset($object))
{
	$page_subtitle = __('For: %s', $this->Contacts->makePath($object));
}

$page_options = array();
$page_options[] = $this->Html->link(__('View All %s', __('FISMA Inventory')), array('controller' => 'fisma_inventories', 'action' => 'index', 'admin' => false));

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Add %s', __('FISMA System')), array('action' => 'add', 'saa' => true));
	$page_options[] = $this->Html->link(__('Import from NSAT file'), array('action' => 'batcher_step1', 'saa' => true));
}

// content
$th = array();
$th['FismaSystem.uuid'] = array('content' => __('UUID'), 'options' => array('sort' => 'FismaSystem.uuid'));
$th['FismaSystem.name'] = array('content' => __('Short Name'), 'options' => array('sort' => 'FismaSystem.name'));
$th['FismaSystemParent.name'] = array('content' => __('Parent'), 'options' => array('sort' => 'FismaSystemParent.name'));
$th['FismaSystem.owner_contact_id'] = array('content' => __('System Owner'), 'options' => array('sort' => 'FismaSystem.owner_contact_id'));
//$th['FismaSystem.crm'] = array('content' => __('%s/%s %s', __('Division'), __('Branch'), __('CRM')));
$th['FismaSystemFipsRating.name'] = array('content' => __('FIPS Rating'), 'options' => array('sort' => 'FismaSystemFipsRating.name'));
$th['FismaSystem.fisma_system_life_safety_id'] = array('content' => __('Life Safety'), 'options' => array('sort' => 'FismaSystemLifeSafety.name', 'editable' => array('type' => 'select', 'options' => $fismaSystemLifeSafeties) ));
$th['FismaSystem.fisma_system_criticality_id'] = array('content' => __('Criticality'), 'options' => array('sort' => 'FismaSystemCriticality.name', 'editable' => array('type' => 'select', 'options' => $fismaSystemCriticalities) ));
$th['FismaSystem.fisma_system_affected_party_id'] = array('content' => __('Affected Party'), 'options' => array('sort' => 'FismaSystemAffectedParty.name', 'editable' => array('type' => 'select', 'options' => $fismaSystemAffectedParties) ));
$th['FismaSystemRiskAssessment.name'] = array('content' => __('FO Risk Assessment'), 'options' => array('sort' => 'FismaSystemRiskAssessment.name'));
$th['FismaSystemThreatAssessment.name'] = array('content' => __('FO Threat Assessment'), 'options' => array('sort' => 'FismaSystemThreatAssessment.name'));
$th['FismaSystemHosting.name'] = array('content' => __('AHE Hosting'), 'options' => array('sort' => 'FismaSystemHosting.name'));
$th['FismaSystemInterconnection.name'] = array('content' => __('Interconnection'), 'options' => array('sort' => 'FismaSystemInterconnection.name'));
$th['FismaSystemGssStatus.name'] = array('content' => __('GSS Status'), 'options' => array('sort' => 'FismaSystemGssStatus.name'));
$th['FismaSystem.pii_count'] = array('content' => __('PII Count'), 'options' => array('sort' => 'FismaSystem.pii_count', 'editable' => array('type' => 'number')));
$th['FismaSystem.is_rogue'] = array('content' => __('Rogue?'), 'options' => array('sort' => 'FismaSystem.is_rogue', 'editable' => array('type' => 'boolean')));
$th['FismaSystem.fisma_reportable'] = array('content' => __('Reportable'), 'options' => array('sort' => 'FismaSystem.fisma_reportable', 'editable' => array('type' => 'boolean')));
$th['FismaSystem.ongoing_auth'] = array('content' => __('Under OA'), 'options' => array('sort' => 'FismaSystem.ongoing_auth', 'editable' => array('type' => 'boolean')));
$th['FismaSystem.fisma_system_nihlogin_id'] = array('content' => __('NIH Login'), 'options' => array('sort' => 'FismaSystemNihlogin.name', 'editable' => array('type' => 'select', 'options' => $fismaSystemNihlogins) ));
$th['FismaSystem.fisma_system_nist_id'] = array('content' => __('NIST'), 'options' => array('sort' => 'FismaSystemNist.name', 'editable' => array('type' => 'select', 'options' => $fismaSystemNists) ));
$th['FismaSystem.ato_expiration'] = array('content' => __('ATO Expiration'), 'options' => array('sort' => 'FismaSystem.ato_expiration', 'editable' => array('type' => 'date') ));
$th['FismaSystem.description'] = array('content' => __('Description'), 'options' => array('sort' => 'FismaSystem.description', 'editable' => array('type' => 'textarea')));
$th['FismaSystem.impact'] = array('content' => __('Impact Details'), 'options' => array('sort' => 'FismaSystem.impact', 'editable' => array('type' => 'textarea')));
$th['FismaInventory.count'] = array('content' => __('# Inventory'));
$th['FismaSoftwareFismaSystem.count'] = array('content' => __('# Software'));
$th['FismaSystemPhysicalLocation.count'] = array('content' => __('# Locations'));
$th['SrcRule.count'] = array('content' => __('# Rules'));
$th['PoamResult.count'] = array('content' => __('# All POA&M'));
$th['UsResult.count'] = array('content' => __('# All US'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['UsResult.ReportsStatus.count_'. $reportsStatus_id] = array('content' => __('# US %s', $reportsStatus['ReportsStatus']['name']));
}
$th['EolResult.count'] = array('content' => __('# All EOL'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['EolResult.ReportsStatus.count_'. $reportsStatus_id] = array('content' => __('# EOL %s', $reportsStatus['ReportsStatus']['name']));
}
$th['PenTestResult.count'] = array('content' => __('# All PT'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['PenTestResult.ReportsStatus.count_'. $reportsStatus_id] = array('content' => __('# PT %s', $reportsStatus['ReportsStatus']['name']));
}
$th['HighRiskResult.count'] = array('content' => __('# All HR'));
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	$th['HighRiskResult.ReportsStatus.count_'. $reportsStatus_id] = array('content' => __('# HR %s', $reportsStatus['ReportsStatus']['name']));
}

$th['FismaSystem.created'] = array('content' => __('Created'), 'options' => array('sort' => 'FismaSystem.created'));
$th['FismaSystem.modified'] = array('content' => __('Modified'), 'options' => array('sort' => 'FismaSystem.modified'));
$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));

$td = array();
foreach ($fisma_systems as $i => $fisma_system)
{
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $fisma_system['FismaSystem']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system['FismaSystem']['id'], 'saa' => true));
		if($this->Wrap->roleCheck(array('admin')))
			$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_system['FismaSystem']['id'], 'admin' => true),array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions); 
	
	$edit_id = array(
		'FismaSystem' => $fisma_system['FismaSystem']['id'],
	);
	
	$systemOwner['AdAccount'] = (isset($fisma_system['OwnerContact'])?$fisma_system['OwnerContact']:array());
	
	$systemOwnerStuff = array();
	if(isset($systemOwner['AdAccount']['id']) and $systemOwner['AdAccount']['id'])
	{
		$systemOwnerStuff['link'] = $this->Html->link($systemOwner['AdAccount']['name'], array('controller' => 'ad_accounts', 'action' => 'view', $systemOwner['AdAccount']['id']));
		$systemOwnerStuff['path'] = $this->Contacts->makePath($systemOwner);
	}
	
/*
	$systemCrmStuff = array();
	$closestCrm = $this->Contacts->getClosestCrm($fisma_system);
	$systemCrmStuff['link'] = false;
	$systemCrmStuff['path'] = false;
*/
	
	$td[$i] = array();
	$td[$i]['FismaSystem.uuid'] = $this->Html->link($fisma_system['FismaSystem']['uuid'], array('action' => 'view', $fisma_system['FismaSystem']['id']));
	$td[$i]['FismaSystem.name'] = $this->Html->link($fisma_system['FismaSystem']['name'], array('action' => 'view', $fisma_system['FismaSystem']['id']));
	$td[$i]['FismaSystemParent.name'] = $this->Html->link($fisma_system['FismaSystemParent']['name'], array('action' => 'view', $fisma_system['FismaSystemParent']['id']));
	$td[$i]['FismaSystem.owner_contact_id'] = ($systemOwnerStuff?implode('<br/>', $systemOwnerStuff):'');
//	$td[$i]['FismaSystem.crm'] = ($systemCrmStuff?implode('<br/>', $systemCrmStuff):'');
	$td[$i]['FismaSystemFipsRating.name'] = $fisma_system['FismaSystemFipsRating']['name'];
	$td[$i]['FismaSystem.fisma_system_life_safety_id'] = array(
		$fisma_system['FismaSystemLifeSafety']['name']. '&nbsp;',
		array('value' => $fisma_system['FismaSystemLifeSafety']['id'])
	);
	$td[$i]['FismaSystem.fisma_system_criticality_id'] = array(
		$fisma_system['FismaSystemCriticality']['name']. '&nbsp;',
		array('value' => $fisma_system['FismaSystemCriticality']['id'])
	);
	$td[$i]['FismaSystem.fisma_system_affected_party_id'] = array(
		$fisma_system['FismaSystemAffectedParty']['name']. '&nbsp;',
		array('value' => $fisma_system['FismaSystemAffectedParty']['id'])
	);
	$td[$i]['FismaSystemRiskAssessment.name'] =  $fisma_system['FismaSystemRiskAssessment']['name'];
	$td[$i]['FismaSystemThreatAssessment.name'] = $fisma_system['FismaSystemThreatAssessment']['name'];
	$td[$i]['FismaSystemHosting.name'] = $fisma_system['FismaSystemHosting']['name'];
	$td[$i]['FismaSystemInterconnection.name'] = $fisma_system['FismaSystemInterconnection']['name'];
	$td[$i]['FismaSystemGssStatus.name'] = $fisma_system['FismaSystemGssStatus']['name'];
	$td[$i]['FismaSystem.pii_count'] = array(
		($fisma_system['FismaSystem']['pii_count']?$fisma_system['FismaSystem']['pii_count']:'0'),
		array('value' => ($fisma_system['FismaSystem']['pii_count']?$fisma_system['FismaSystem']['pii_count']:0))
	);
	$td[$i]['FismaSystem.is_rogue'] = array(
		$this->Wrap->yesNoUnknown($fisma_system['FismaSystem']['is_rogue']),
		array('value' => $fisma_system['FismaSystem']['is_rogue'])
	);
	$td[$i]['FismaSystem.fisma_reportable'] = array(
		$this->Wrap->yesNoUnknown($fisma_system['FismaSystem']['fisma_reportable']),
		array('value' => $fisma_system['FismaSystem']['fisma_reportable'])
	);
	$td[$i]['FismaSystem.ongoing_auth'] = array(
		$this->Wrap->yesNoUnknown($fisma_system['FismaSystem']['ongoing_auth']),
		array('value' => $fisma_system['FismaSystem']['ongoing_auth'])
	);
	$td[$i]['FismaSystem.fisma_system_nihlogin_id'] = array(
		$fisma_system['FismaSystemNihlogin']['name']. '&nbsp;',
		array('value' => $fisma_system['FismaSystemNihlogin']['id'])
	);
	$td[$i]['FismaSystem.fisma_system_nist_id'] = array(
		$fisma_system['FismaSystemNist']['name']. '&nbsp;',
		array('value' => $fisma_system['FismaSystemNist']['id'])
	);
	$td[$i]['FismaSystem.ato_expiration'] = array(
		$this->Wrap->niceDay($fisma_system['FismaSystem']['ato_expiration']),
		array('value' => ($fisma_system['FismaSystem']['ato_expiration']?$fisma_system['FismaSystem']['ato_expiration']:false))
	);
	$td[$i]['FismaSystem.description'] = $this->Html->tableDesc($fisma_system['FismaSystem']['description']);
	$td[$i]['FismaSystem.impact'] = $this->Html->tableDesc($fisma_system['FismaSystem']['impact']);
	$td[$i]['FismaInventory.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_inventories', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'fisma_inventories'),
	));
	$td[$i]['FismaSoftwareFismaSystem.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_softwares_fisma_systems', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'software'),
	));
	$td[$i]['FismaSystemPhysicalLocation.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems_physical_locations', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'locations'),
	));
	$td[$i]['SrcRule.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'rules', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'rules'),
	));
	$td[$i]['PoamResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'poam_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'poam_results'),
	));
	$td[$i]['UsResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'us_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'us_results'),
	));
	foreach($reportsStatuses as $reportsStatus)
	{
		$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
		$td[$i]['UsResult.ReportsStatus.count_'. $reportsStatus_id] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
			'displayValue' => '.',
			'ajax_count_url' => array('controller' => 'us_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id), 
			'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'us_results'),
		));
	}
	$td[$i]['EolResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'eol_results'),
	));
	foreach($reportsStatuses as $reportsStatus)
	{
		$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
		$td[$i]['EolResult.ReportsStatus.count_'. $reportsStatus_id] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
			'displayValue' => '.',
			'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id), 
			'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'eol_results'),
		));
	}
	$td[$i]['PenTestResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'pen_test_results'),
	));
	foreach($reportsStatuses as $reportsStatus)
	{
		$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
		$td[$i]['PenTestResult.ReportsStatus.count_'. $reportsStatus_id] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
			'displayValue' => '.',
			'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id), 
			'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'pen_test_results'),
		));
	}
	$td[$i]['HighRiskResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']), 
		'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'high_risk_results'),
	));
	foreach($reportsStatuses as $reportsStatus)
	{
		$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
		$td[$i]['HighRiskResult.ReportsStatus.count_'. $reportsStatus_id] = $this->Common->coloredCell($reportsStatus['ReportsStatus'], array(
			'displayValue' => '.',
			'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id), 
			'url' => array('action' => 'view', $fisma_system['FismaSystem']['id'], 'tab' => 'high_risk_results'),
		));
	}
	$td[$i]['FismaSystem.created'] =  $this->Wrap->niceTime($fisma_system['FismaSystem']['created']);
	$td[$i]['FismaSystem.modified'] =  $this->Wrap->niceTime($fisma_system['FismaSystem']['modified']);
	$td[$i]['actions'] = array(
		$actions, 
		array('class' => 'actions'),
	);
	$td[$i]['edit_id'] = $edit_id;
}

$use_gridedit = $use_griddelete = $user_gridadd = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
	$use_gridedit = $use_griddelete = $user_gridadd = true;

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Systems'),
	'page_subtitle' => $page_subtitle,
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	// grid/inline edit options
	'use_gridedit' => $use_gridedit,
//	'use_gridadd' => $user_gridadd,
//	'use_griddelete' => $use_griddelete,
	'auto_load_ajax' => (isset($auto_load_ajax)?$auto_load_ajax:false),
));