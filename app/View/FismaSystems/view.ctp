<?php 

$page_options = array();

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_system['FismaSystem']['id'], 'saa' => true));
	$page_options[] = $this->Html->link(__('Export to txt'), array('action' => 'view', $fisma_system['FismaSystem']['id'], 'ext' => 'txt'));
//	$page_options[] = $this->Form->postLink(__('Delete'),array('action' => 'delete', $fisma_system['FismaSystem']['id']),array('confirm' => 'Are you sure?'));
}

$details_blocks = array();

$details_blocks[1][1] = array(
	'title' => __('Details'),
	'details' => array(
		array('name' => __('Parent'), 'value' => ($fisma_system['FismaSystemParent']['id']?$this->Html->link($fisma_system['FismaSystemParent']['name'], array('action' => 'view', $fisma_system['FismaSystemParent']['id'])):__('None'))),
		array('name' => __('UUID'), 'value' => $fisma_system['FismaSystem']['uuid']),
		array('name' => __('Type'), 'value' => $fisma_system['FismaSystemType']['name']),
		array('name' => __('AHE Hosting'), 'value' => $fisma_system['FismaSystemHosting']['name']),
		array('name' => __('NIH Login'), 'value' => $fisma_system['FismaSystemNihlogin']['name']),
		array('name' => __('Interconnection'), 'value' => $fisma_system['FismaSystemInterconnection']['name']),
		array('name' => __('GSS Status'), 'value' => $fisma_system['FismaSystemGssStatus']['name']),
		array('name' => __('PII Records'), 'value' => (($fisma_system['FismaSystem']['pii_count'] > 0)?$fisma_system['FismaSystem']['pii_count']:' 0&nbsp;')),
		array('name' => __('Rogue?'), 'value' => $this->Wrap->yesNoUnknown($fisma_system['FismaSystem']['is_rogue'])),
		array('name' => __('FISMA Reportable'), 'value' => $this->Wrap->yesNoUnknown($fisma_system['FismaSystem']['fisma_reportable'])),
		array('name' => __('Under Ongoing Authorization'), 'value' => $this->Wrap->yesNoUnknown($fisma_system['FismaSystem']['ongoing_auth'])),
		array('name' => __('NIST'), 'value' => $fisma_system['FismaSystemNist']['name']),
		array('name' => __('ATO Expiration'), 'value' => $this->Wrap->niceTime($fisma_system['FismaSystem']['ato_expiration'])),
		array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fisma_system['FismaSystem']['created'])),
		array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fisma_system['FismaSystem']['modified'])),
	),
);

$details_blocks[1][2] = array(
	'title' => __('Assessments'),
	'details' => array(
		array('name' => __('FIPS Rating'), 'value' => $fisma_system['FismaSystemFipsRating']['name']),
		array('name' => __('Life Safety'), 'value' => $fisma_system['FismaSystemLifeSafety']['name']),
		array('name' => __('Criticality'), 'value' => $fisma_system['FismaSystemCriticality']['name']),
		array('name' => __('Affected Party'), 'value' => $fisma_system['FismaSystemAffectedParty']['name']),
		array('name' => __('FO Risk Assessment'), 'value' => $fisma_system['FismaSystemRiskAssessment']['name']),
		array('name' => __('FO Threat Assessment'), 'value' => $fisma_system['FismaSystemThreatAssessment']['name']),
		array('name' => __('Amount'), 'value' => $fisma_system['FismaSystemAmount']['name']),
		array('name' => __('Communications Total'), 'value' => $fisma_system['FismaSystemComTotal']['name']),
		array('name' => __('Dependency'), 'value' => $fisma_system['FismaSystemDependency']['name']),
		array('name' => __('Impact'), 'value' => $fisma_system['FismaSystemImpact']['name']),
		array('name' => __('Uniqueness'), 'value' => $fisma_system['FismaSystemUniqueness']['name']),
		array('name' => __('Sensitivity Category'), 'value' => $fisma_system['FismaSystemSensitivityCategory']['name']),
		array('name' => __('Sensitivity Rating'), 'value' => $fisma_system['FismaSystemSensitivityRating']['name']),
	),
);

$systemOwner['AdAccount'] = (isset($fisma_system['OwnerContact'])?$fisma_system['OwnerContact']:array());
$systemOwnerLink = (isset($systemOwner['AdAccount']['id'])?$this->Html->link($systemOwner['AdAccount']['name'], array('controller' => 'ad_accounts', 'action' => 'view', $systemOwner['AdAccount']['id'])):'');
$systemOwnerPath = $this->Contacts->makePath($systemOwner);

$details_blocks[1][3] = array(
	'title' => __('Top 10 %s', __('Primary Contacts')),
	'details' => array(
		array('name' => __('System Owner'), 'value' => __('%s - %s', $systemOwnerLink, $systemOwnerPath)),
//		array('name' => ' ', 'value' => $systemOwnerPath),
	)
);
if(isset($fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgDirector']['id']) 
and $fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgDirector']['id'])
{
	$detailsValue = $this->Html->link($fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgDirector']['name'], array(
		'controller' => 'ad_accounts',
		'action' => 'view',
		$fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgDirector']['id']
	));
	$details_blocks[1][3]['details'][] = array('name' => __('%s Director', __('ORG/IC')), 'value' => $detailsValue);
}
if(isset($fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgCrm']['id']) 
and $fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgCrm']['id'])
{
	$detailsValue = $this->Html->link($fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgCrm']['name'], array(
		'controller' => 'ad_accounts',
		'action' => 'view',
		$fisma_system['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgCrm']['id']
	));
	$details_blocks[1][3]['details'][] = array('name' => __('%s CRM', __('ORG/IC')), 'value' => $detailsValue);
}
if(isset($fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionDirector']['id']) 
and $fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionDirector']['id'])
{
	$detailsValue = $this->Html->link($fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionDirector']['name'], array(
		'controller' => 'ad_accounts',
		'action' => 'view',
		$fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionDirector']['id']
	));
	$details_blocks[1][3]['details'][] = array('name' => __('%s Director', __('Division')), 'value' => $detailsValue);
}
if(isset($fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionCrm']['id']) 
and $fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionCrm']['id'])
{
	$detailsValue = $this->Html->link($fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionCrm']['name'], array(
		'controller' => 'ad_accounts',
		'action' => 'view',
		$fisma_system['OwnerContact']['Sac']['Branch']['Division']['DivisionCrm']['id']
	));
	$details_blocks[1][3]['details'][] = array('name' => __('%s CRM', __('Division')), 'value' => $detailsValue);
}
if(isset($fisma_system['OwnerContact']['Sac']['Branch']['BranchDirector']['id']) 
and $fisma_system['OwnerContact']['Sac']['Branch']['BranchDirector']['id'])
{
	$detailsValue = $this->Html->link($fisma_system['OwnerContact']['Sac']['Branch']['BranchDirector']['name'], array(
		'controller' => 'ad_accounts',
		'action' => 'view',
		$fisma_system['OwnerContact']['Sac']['Branch']['BranchDirector']['id']
	));
	$details_blocks[1][3]['details'][] = array('name' => __('%s Director', __('Branch')), 'value' => $detailsValue);
}
if(isset($fisma_system['OwnerContact']['Sac']['Branch']['BranchCrm']['id']) 
and $fisma_system['OwnerContact']['Sac']['Branch']['BranchCrm']['id'])
{
	$detailsValue = $this->Html->link($fisma_system['OwnerContact']['Sac']['Branch']['BranchCrm']['name'], array(
		'controller' => 'ad_accounts',
		'action' => 'view',
		$fisma_system['OwnerContact']['Sac']['Branch']['BranchCrm']['id']
	));
	$details_blocks[1][3]['details'][] = array('name' => __('%s CRM', __('Branch')), 'value' => $detailsValue);
}


if(isset($fisma_system['primaryContacts']) and $fisma_system['primaryContacts'])
{
	foreach($fisma_system['primaryContacts'] as $i => $primaryContact)
	{
		$primaryContactKey = $primaryContact['FismaContactType']['name'];
		$primaryContactValue = (isset($primaryContact['AdAccount']['id'])?$this->Html->link($primaryContact['AdAccount']['name'], array('controller' => 'ad_accounts', 'action' => 'view', $primaryContact['AdAccount']['id'])):'');
		$primaryContactPath = $this->Contacts->makePath($primaryContact);
		
		$details_blocks[1][3]['details'][] = array('name' => $primaryContactKey, 'value' => __('%s - %s', $primaryContactValue, $primaryContactPath));
//		$details_blocks[1][3]['details'][] = array('name' => ' ', 'value' => );
	}
}

$stats = array();
$tabs = array();
$tabs['fisma_inventories'] = $stats['fisma_inventories'] = array(
	'id' => 'fisma_inventories',
	'name' => __('Direct Inventory'), 
	'ajax_url' => array('controller' => 'fisma_inventories', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
);

// this system is a parent
if(!$fisma_system['FismaSystemParent']['id'])
{
	$tabs['fisma_inventories_all'] = $stats['fisma_inventories_all'] = array(
		'id' => 'fisma_inventories_all',
		'name' => __('All Inventory'), 
		'ajax_url' => array('controller' => 'fisma_inventories', 'action' => 'fisma_system_all', $fisma_system['FismaSystem']['id']),
	);
	$tabs['fisma_inventories_children'] = $stats['fisma_inventories_children'] = array(
		'id' => 'fisma_inventories_children',
		'name' => __('Children Inventory'), 
		'ajax_url' => array('controller' => 'fisma_inventories', 'action' => 'fisma_system_children', $fisma_system['FismaSystem']['id']),
	);
	$tabs['my_children'] = $stats['my_children'] = array(
		'id' => 'my_children',
		'name' => __('Children'), 
		'ajax_url' => array('controller' => 'fisma_systems', 'action' => 'my_children', $fisma_system['FismaSystem']['id']),
	);
}

$tabs['fisma_system_files'] = $stats['fisma_system_files'] = array(
	'id' => 'fisma_system_files',
	'name' => __('Files'), 
	'ajax_url' => array('controller' => 'fisma_system_files', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
);
$tabs['raf'] = $stats['raf'] = array(
	'id' => 'raf',
	'name' => __('RAF'), 
	'ajax_url' => array('controller' => 'fisma_system_files', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], true),
	'tab' => array('tabs', (count($tabs) + 1)), // the tab to display
);
$tabs['rules'] = $stats['rules'] = array(
	'id' => 'rules',
	'name' => __('Rules'), 
	'ajax_url' => array('controller' => 'rules', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
);
$tabs['software'] = $stats['software'] = array(
	'id' => 'software',
	'name' => __('Whitelisted Software'), 
	'ajax_url' => array('controller' => 'fisma_softwares_fisma_systems', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
);
$tabs['locations'] = $stats['locations'] = array(
	'id' => 'locations',
	'name' => __('Physical Locations'), 
	'ajax_url' => array('controller' => 'fisma_systems_physical_locations', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
);
$tabs['fisma_contacts'] = $stats['fisma_contacts'] = array(
	'id' => 'fisma_contacts',
	'name' => __('FISMA Contacts'), 
	'ajax_url' => array('controller' => 'ad_accounts_fisma_systems', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
);

$tabs['poam_results'] = $stats['poam_results'] = array(
	'id' => 'poam_results',
	'name' => __('POA&M Results'), 
	'ajax_url' => array('controller' => 'poam_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
);
$ajax_count_urls = array(
	'all' => array(
		'url' => array('controller' => 'fov_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
		'options' => array(
			'title' => __('All'),
		),
	),
);
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	
	$reportsOptions = $this->Common->setColorOptions($reportsStatus['ReportsStatus']);
	$reportsOptions['title'] = __('With Status: %s', $reportsStatus['ReportsStatus']['name']);
	$ajax_count_urls['reportsStatus_'. $reportsStatus_id] = array(
		'url' => array('controller' => 'fov_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id),
		'options' => $reportsOptions,
	);
}
$tabs['fov_results'] = $stats['fov_results'] = array(
	'id' => 'fov_results',
	'name' => __('FOV Results'), 
	'ajax_urls' => $ajax_count_urls,
);
$ajax_count_urls = array(
	'all' => array(
		'url' => array('controller' => 'us_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
		'options' => array(
			'title' => __('All'),
		),
	),
);
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	
	$reportsOptions = $this->Common->setColorOptions($reportsStatus['ReportsStatus']);
	$reportsOptions['title'] = __('With Status: %s', $reportsStatus['ReportsStatus']['name']);
	$ajax_count_urls['reportsStatus_'. $reportsStatus_id] = array(
		'url' => array('controller' => 'us_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id),
		'options' => $reportsOptions,
	);
}
$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_urls' => $ajax_count_urls,
);

$ajax_count_urls = array(
	'all' => array(
		'url' => array('controller' => 'eol_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
		'options' => array(
			'title' => __('All'),
		),
	),
);
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	
	$reportsOptions = $this->Common->setColorOptions($reportsStatus['ReportsStatus']);
	$reportsOptions['title'] = __('With Status: %s', $reportsStatus['ReportsStatus']['name']);
	$ajax_count_urls['reportsStatus_'. $reportsStatus_id] = array(
		'url' => array('controller' => 'eol_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id),
		'options' => $reportsOptions,
	);
}
$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_urls' => $ajax_count_urls,
);

$ajax_count_urls = array(
	'all' => array(
		'url' => array('controller' => 'pen_test_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
		'options' => array(
			'title' => __('All'),
		),
	),
);
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	
	$reportsOptions = $this->Common->setColorOptions($reportsStatus['ReportsStatus']);
	$reportsOptions['title'] = __('With Status: %s', $reportsStatus['ReportsStatus']['name']);
	$ajax_count_urls['reportsStatus_'. $reportsStatus_id] = array(
		'url' => array('controller' => 'pen_test_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id),
		'options' => $reportsOptions,
	);
}
$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_urls' => $ajax_count_urls,
);

$ajax_count_urls = array(
	'all' => array(
		'url' => array('controller' => 'high_risk_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
		'options' => array(
			'title' => __('All'),
		),
	),
);
foreach($reportsStatuses as $reportsStatus)
{
	$reportsStatus_id = $reportsStatus['ReportsStatus']['id'];
	
	$reportsOptions = $this->Common->setColorOptions($reportsStatus['ReportsStatus']);
	$reportsOptions['title'] = __('With Status: %s', $reportsStatus['ReportsStatus']['name']);
	$ajax_count_urls['reportsStatus_'. $reportsStatus_id] = array(
		'url' => array('controller' => 'high_risk_results', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id'], $reportsStatus_id),
		'options' => $reportsOptions,
	);
}
$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_urls' => $ajax_count_urls,
);

if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$tabs['poams'] = $stats['poams'] = array(
		'id' => 'poams',
		'name' => __('POAMs'), 
		'ajax_url' => array('controller' => 'fisma_system_poams', 'action' => 'fisma_system', $fisma_system['FismaSystem']['id']),
	);
}

$note_options = array(); 
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$note_options['edit'] = $this->Html->link(__('Edit Description'), array('action' => 'edit_notes', $fisma_system['FismaSystem']['id'], 'description', 'saa' => false, 'admin' => false));
}
$tabs['description'] = array(
	'id' => 'description',
	'name' => __('Description'),
	'content' => $this->element('Utilities.page_generic', array(
		'page_options' => $note_options,
		'page_content' => $this->Wrap->descView($fisma_system['FismaSystem']['description']),
	)),
);

$note_options = array(); 
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$note_options['edit'] = $this->Html->link(__('Edit Impact Details'), array('action' => 'edit_notes', $fisma_system['FismaSystem']['id'], 'impact', 'saa' => false, 'admin' => false));
}
$tabs['impact'] = array(
	'id' => 'impact',
	'name' => __('Impact Details'),
	'content' => $this->element('Utilities.page_generic', array(
		'page_options' => $note_options,
		'page_content' => $this->Wrap->descView($fisma_system['FismaSystem']['impact']),
	)),
);

$note_options = array(); 
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$note_options['edit'] = $this->Html->link(__('Edit Notes'), array('action' => 'edit_notes', $fisma_system['FismaSystem']['id'], 'notes', 'saa' => false, 'admin' => false));
}
$tabs['notes'] = array(
	'id' => 'notes',
	'name' => __('Notes'),
	'content' => $this->element('Utilities.page_generic', array(
		'page_options' => $note_options,
		'page_content' => $this->Wrap->descView($fisma_system['FismaSystem']['notes']),
	)),
);
$daar_notes_options = array(); 
if(isset($fisma_system['primaryContacts']) and $fisma_system['primaryContacts'])
{
	foreach($fisma_system['primaryContacts'] as $primaryContact)
	{
		if(in_array($primaryContact['FismaContactType']['slug'], array('DAA_R', 'DAA')))
		{
			if(isset($primaryContact['AdAccount']['username']) and $primaryContact['AdAccount']['username'] == AuthComponent::user('adaccount'))
			{
				$daar_notes_options['edit'] = $this->Html->link(__('Edit DAA-R Notes'), array('action' => 'edit_notes', $fisma_system['FismaSystem']['id'], 'daar_notes', 'saa' => false, 'admin' => false));
			}
		}
	}
}
$tabs['daar_notes'] = array(
	'id' => 'daar_notes',
	'name' => __('DAA-R Notes'),
	'content' => $this->element('Utilities.page_generic', array(
		'page_options' => $daar_notes_options,
		'page_content' => $this->Wrap->descView($fisma_system['FismaSystem']['daar_notes']),
	)),
);

$isso_notes_options = array(); 
if(isset($fisma_system['primaryContacts']) and $fisma_system['primaryContacts'])
{
	foreach($fisma_system['primaryContacts'] as $primaryContact)
	{
		if(in_array($primaryContact['FismaContactType']['slug'], array('ISSO', 'ISSO_ALT')))
		{
			if(isset($primaryContact['AdAccount']['username']) and $primaryContact['AdAccount']['username'] == AuthComponent::user('adaccount'))
			{
				$isso_notes_options['edit'] = $this->Html->link(__('Edit ISSO Notes'), array('action' => 'edit_notes', $fisma_system['FismaSystem']['id'], 'isso_notes', 'saa' => false, 'admin' => false));
			}
		}
	}
}
$tabs['isso_notes'] = array(
	'id' => 'isso_notes',
	'name' => __('ISSO Notes'),
	'content' => $this->element('Utilities.page_generic', array(
		'page_options' => $isso_notes_options,
		'page_content' => $this->Wrap->descView($fisma_system['FismaSystem']['isso_notes']),
	)),
);

$note_options = array(); 
if($this->Wrap->roleCheck(array('admin')))
{
	$note_options['edit'] = $this->Html->link(__('Edit Notes'), array('action' => 'edit_notes', $fisma_system['FismaSystem']['id'], 'fo_notes', 'saa' => false, 'admin' => false));
}
$tabs['fo_notes'] = array(
	'id' => 'fo_notes',
	'name' => __('FO Notes'),
	'content' => $this->element('Utilities.page_generic', array(
		'page_options' => $note_options,
		'page_content' => $this->Wrap->descView($fisma_system['FismaSystem']['fo_notes']),
	)),
);	

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('%s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name']),
	'page_subtitle' => __('Full Name: %s', $fisma_system['FismaSystem']['fullname'].' '),
	'page_subtitle2' => $this->Contacts->makePath($fisma_system),
	'page_options' => $page_options,
	'stats' => $stats,
	'details_blocks' => $details_blocks,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));