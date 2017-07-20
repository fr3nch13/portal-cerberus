<?php 
$page_options = array();

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin', 'saa')))
{
	$use_gridedit = true;
}

$th = array();
//$th['AdAccount.path'] = array('content' => __('Path'));
$th['AdAccountFismaSystem.ad_account_id'] = array('content' => __('AD Account'), 'options' => array('sort' => 'AdAccountFismaSystem.ad_account_id', 'editable' => array('type' => 'select', 'searchable' => true, 'options' => $adAccounts) ));
$th['FismaSystem.name'] = array('content' => __('FISMA System'), 'options' => array('sort' => 'FismaSystem.name'));
$th['FismaSystem.modified'] = array('content' => __('%s %s', __('FISMA System'), __('Last Modified')), 'options' => array('sort' => 'FismaSystem.modified'));
$th['FismaSystem.modified_user_id'] = array('content' => __('%s %s', __('FISMA System'), __('Last Modified By')), 'options' => array('sort' => 'FismaSystem.modified_user_id'));
$th['OwnerContact.name'] = array('content' => __('%s Owner', __('FISMA System')));
$th['Crm.name'] = array('content' => __('%s CRM', __('FISMA System')));
$th['PhysicalLocation.name'] = array('content' => __('Physical Locations'));
$th['AdAccountDetail.fisma_training_date'] = array('content' => __('%s Training', __('FISMA System')), 'options' => array('editable' => array('type' => 'date')) );
$th['FismaSystem.ato_expiration'] = array('content' => __('ATO Expiration'), 'options' => array('sort' => 'FismaSystem.ato_expiration'));
$th['FismaSystem.pii_count'] = array('content' => __('PII Count'), 'options' => array('sort' => 'FismaSystem.pii_count'));
$th['FismaSystemFipsRating.name'] = array('content' => __('FIPS Rating'), 'options' => array('sort' => 'FismaSystem.fisma_system_fips_rating_id'));
$th['FismaInventory.count'] = array('content' => __('# Inventory'));
$th['FismaInventoryLastModified.modified'] = array('content' => __('Inventory Last Modified'));
//$th['FismaInventoryLastModified.name'] = array('content' => __('Last Inventory Modified Name'));
$th['FismaSystemFileLastAdded.added'] = array('content' => __('Last File Added'));
$th['FismaSystemFileLastAdded.name'] = array('content' => __('Last File Added Filename'));
$th['multiselect'] = true;

$thresholdNow = time();
$thresholdSoon = strtotime('+30 days');
$thresholdPast = strtotime('-120 days');
$trainingThresholdYellow = strtotime('-300 days');
$trainingThresholdRed = strtotime('-365 days');
$td = array();
foreach ($adAccounts_fismaSystems as $i => $adAccounts_fismaSystem)
{
	$fismaModifiedUser = false;
	if(isset($adAccounts_fismaSystem['FismaSystem']['FismaModifiedUser']['name']))
		$fismaModifiedUser = $this->Html->link($adAccounts_fismaSystem['FismaSystem']['FismaModifiedUser']['name'], array('controller' => 'users', 'action' => 'view', $adAccounts_fismaSystem['FismaSystem']['FismaModifiedUser']['id']));
	
	$fismaLastInventory = false;
	$fismaLastInventoryModified = false;
	$fismaLastInventoryModifiedTime = false;
	if(isset($adAccounts_fismaSystem['FismaSystem']['FismaInventoryLastModified']['name']))
	{
		$fismaLastInventory = $this->Html->link($adAccounts_fismaSystem['FismaSystem']['FismaInventoryLastModified']['name'], array('controller' => 'fisma_inventories', 'action' => 'view', $adAccounts_fismaSystem['FismaSystem']['FismaInventoryLastModified']['id']));
		$fismaLastInventoryModified = $this->Wrap->niceTime($adAccounts_fismaSystem['FismaSystem']['FismaInventoryLastModified']['created']);
		$fismaLastInventoryModifiedTime = strtotime($adAccounts_fismaSystem['FismaSystem']['FismaInventoryLastModified']['created']);
	}
	
	$fismaLastFile = false;
	$fismaLastFileAdded = false;
	$fismaLastFileAddedTime = false;
	if(isset($adAccounts_fismaSystem['FismaSystem']['FismaSystemFileLastAdded']['filename']))
	{
		$fismaLastFile = $adAccounts_fismaSystem['FismaSystem']['FismaSystemFileLastAdded']['filename'];
		$fismaLastFileAdded = $this->Wrap->niceTime($adAccounts_fismaSystem['FismaSystem']['FismaSystemFileLastAdded']['created']);
		$fismaLastFileAddedTime = strtotime($adAccounts_fismaSystem['FismaSystem']['FismaSystemFileLastAdded']['created']);
	}
	$inventoryCount = $this->requestAction(array('controller' => 'fisma_inventories', 'action' => 'fisma_system', $adAccounts_fismaSystem['FismaSystem']['id'], 'getcount' => true), array('return'));
	$inventoryCount = intval($inventoryCount);
	
	$highlightAtoExpired = false;
/*
		if(!$highlightAtoExpired and !$inventoryCount)
			$highlightAtoExpired = 'highlight-red';
		if(!$highlightAtoExpired and !$fismaLastInventoryModifiedTime)
			$highlightAtoExpired = 'highlight-red';
		if(!$highlightAtoExpired and !$fismaLastFileAddedTime)
			$highlightAtoExpired = 'highlight-red';
			
		if(!$highlightAtoExpired and $fismaLastInventoryModifiedTime < $thresholdPast)
			$highlightAtoExpired = 'highlight-yellow';
		if(!$highlightAtoExpired and $fismaLastFileAddedTime < $thresholdPast)
			$highlightAtoExpired = 'highlight-yellow';
		if(!$highlightAtoExpired and $atoExpirationDate <= $thresholdSoon)
			$highlightAtoExpired = 'highlight-yellow';
*/
		
	$td[$i] = array();
//	$td[$i]['AdAccount.path'] = $this->Contacts->makePath($adAccounts_fismaSystem);
	$td[$i]['AdAccountFismaSystem.ad_account_id'] = array(
		$this->Html->link($adAccounts_fismaSystem['AdAccount']['name_username'], array('controller' => 'ad_accounts', 'action' => 'view', $adAccounts_fismaSystem['AdAccount']['id'])),
		array('value' => $adAccounts_fismaSystem['AdAccount']['id']),
	);
	$td[$i]['FismaSystem.name'] = $this->Html->link($adAccounts_fismaSystem['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $adAccounts_fismaSystem['FismaSystem']['id'], 'tab' => 'fisma_contacts'));
	$td[$i]['FismaSystem.modified'] = $this->Wrap->niceTime($adAccounts_fismaSystem['FismaSystem']['modified']);
	$td[$i]['FismaSystem.modified_user_id'] = $fismaModifiedUser;
	
	$owner = false;
	if(isset($adAccounts_fismaSystem['FismaSystem']['OwnerContact']['name']))
		$owner = $this->Html->link($adAccounts_fismaSystem['FismaSystem']['OwnerContact']['name'], array('controller' => 'ad_accounts', 'action' => 'view', $adAccounts_fismaSystem['FismaSystem']['OwnerContact']['id']));
	
	$td[$i]['OwnerContact.name'] = $owner;
	$td[$i]['Crm.name'] = $this->Contacts->getClosestCrm($adAccounts_fismaSystem);
	
	$locationClass = 'highlight-red';
	$locations = false;
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$locations = $this->Html->link(__('[Add Locations]'), array('saa' => true, 'controller' => 'fisma_systems_physical_locations', 'action' => 'edit_locations', $adAccounts_fismaSystem['FismaSystem']['id']));
	}
	
	if(isset($adAccounts_fismaSystem['FismaSystem']['PhysicalLocation']) and $adAccounts_fismaSystem['FismaSystem']['PhysicalLocation'])
	{
		$locations = array();
		$locationClass = 'highlight-green';
		foreach($adAccounts_fismaSystem['FismaSystem']['PhysicalLocation'] as $location)
		{
			$locations[$location['id']] = $this->Html->link($location['name'], array('prefix' => false, 'controller' => 'physical_locations', 'action' => 'view', $location['id']));
		}
		$locations = implode(', ', $locations);
	}
	$td[$i]['PhysicalLocation.name'] = array(
		$locations,
		array('class' => $locationClass)
	);
	
	$training_day = false;
	if(isset($adAccounts_fismaSystem['FismaSystem']['OwnerContact']['AdAccountDetail']['fisma_training_date']))
		$training_day = $adAccounts_fismaSystem['FismaSystem']['OwnerContact']['AdAccountDetail']['fisma_training_date'];
		
	$trainingClass = 'highlight-green';
	$trainingTime = strtotime($training_day);
	if(!$trainingTime)
		$trainingClass = 'highlight-red';
	elseif($trainingTime < $trainingThresholdYellow)
		$trainingClass = 'highlight-yellow';
	elseif($trainingTime < $trainingThresholdRed)
		$trainingClass = 'highlight-red';
	
	$td[$i]['AdAccountDetail.fisma_training_date'] = array(
		$this->Wrap->niceDay($training_day),
		array('class' => $trainingClass, 'value' => $training_day)
	);
	
	$atoExpClass = 'highlight-green';
	$atoExpirationDate = strtotime($adAccounts_fismaSystem['FismaSystem']['ato_expiration']);
	if(!$atoExpirationDate)
		$atoExpClass = 'highlight-red';
	elseif($atoExpirationDate < $thresholdNow)
		$atoExpClass = 'highlight-red';
	elseif($atoExpirationDate <= $thresholdSoon)
		$atoExpClass = 'highlight-yellow';
	
	$td[$i]['FismaSystem.ato_expiration'] = array(
		$this->Wrap->niceDay($adAccounts_fismaSystem['FismaSystem']['ato_expiration']),
		array('class' => $atoExpClass),
	);
	$td[$i]['FismaSystem.pii_count'] = array(
		($adAccounts_fismaSystem['FismaSystem']['pii_count']?$adAccounts_fismaSystem['FismaSystem']['pii_count']:'0&nbsp;'),
		array('class' => ($adAccounts_fismaSystem['FismaSystem']['pii_count']?'highlight-yellow':'highlight-green'))
	);
	
	$td[$i]['FismaSystemFipsRating.name'] = array(
		'&nbsp;',
		array('class' => 'highlight-red'),
	);
	if(isset($adAccounts_fismaSystem['FismaSystem']['FismaSystemFipsRating']['name']))
	{
		$td[$i]['FismaSystemFipsRating.name'] = array(
			$adAccounts_fismaSystem['FismaSystem']['FismaSystemFipsRating']['name'],
			array('style' => 'background-color: '.$this->Common->makeRGBfromHex($adAccounts_fismaSystem['FismaSystem']['FismaSystemFipsRating']['color_code_hex']).';'),
		);
		
	}
	
	$td[$i]['FismaInventory.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_inventories', 'action' => 'fisma_system', $adAccounts_fismaSystem['FismaSystem']['id']), 
		'url' => array('controller' => 'fisma_systems', 'action' => 'view', $adAccounts_fismaSystem['FismaSystem']['id'], 'tab' => 'fisma_inventories'),
		'data-no-highlight-class' => 'highlight-red',
		'data-highlight-class' => 'highlight-green',
	));
	
	$inventoryClass = 'highlight-green';
	if(!$fismaLastInventoryModifiedTime)
		$inventoryClass = 'highlight-red';
	elseif($fismaLastInventoryModifiedTime < $thresholdPast)
		$inventoryClass = 'highlight-yellow';
	
	$td[$i]['FismaInventoryLastModified.added'] = array($fismaLastInventoryModified, array('class' => $inventoryClass));

	$fileClass = 'highlight-green';
	if(!$fismaLastFileAddedTime)
		$fileClass = 'highlight-red';
	elseif($fismaLastFileAddedTime < $thresholdPast)
		$fileClass = 'highlight-yellow';
	
	$td[$i]['FismaSystemFileLastAdded.added'] = array($fismaLastFileAdded, array('class' => $fileClass));
	$td[$i]['FismaSystemFileLastAdded.name'] = $fismaLastFile;
	
	$td[$i]['edit_id'] = array(
		'AdAccountFismaSystem' => $adAccounts_fismaSystem['AdAccountFismaSystem']['id'],
		'AdAccountDetail.id' => (isset($adAccounts_fismaSystem['FismaSystem']['OwnerContact']['AdAccountDetail']['id'])?$adAccounts_fismaSystem['FismaSystem']['OwnerContact']['AdAccountDetail']['id']:false),
		'AdAccountDetail.ad_account_id' => (isset($adAccounts_fismaSystem['FismaSystem']['OwnerContact']['id'])?$adAccounts_fismaSystem['FismaSystem']['OwnerContact']['id']:false),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Contacts'),
	'page_options' => $page_options,
	'search_placeholder' => __('FISMA Contacts'),
	'th' => $th,
	'td' => $td,
	'table_caption' => __('Highlights - Red: Needs Action - Yellow: Needs Attention - Green: Looks fine.'),
	'use_gridedit' => $use_gridedit,
));