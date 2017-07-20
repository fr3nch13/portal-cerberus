<?php 
$page_options = array();

// content
$th = array();
$th['actions_left'] = array('content' => __('Actions'));
$th['parent'] = array('content' => __('Parent'));
$th['name'] = array('content' => __('Name'));
$th['owner'] = array('content' => __('System Owner'));
$th['fips'] = array('content' => __('FIPS'));
$th['gss'] = array('content' => __('GSS'));
$th['pii_count'] = array('content' => __('PII Count'));
$th['actions_right'] = array('content' => __('Actions'));

$td = array();
$stats = array();

foreach ($fismaSystems as $i => $fismaSystem)
{
	$actions = array(
		$this->Html->link(__('View'), array('action' => 'view', $fismaSystem['FismaSystem']['id'])),
	);
	
	// check the user's permissions
	if($this->Wrap->roleCheck(array('admin', 'saa')))
	{
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fismaSystem['FismaSystem']['id'], 'saa' => true));
//		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fismaSystem['FismaSystem']['id'], 'saa' => true),array('confirm' => 'Are you sure?'));
	}
	$actions = implode('', $actions); 
	
	$td[$i] = array();
	$td[$i]['actions_left'] = array(
		$actions, 
		array('class' => 'actions'),
	);
	
	$systemOwner['AdAccount'] = (isset($fismaSystem['OwnerContact'])?$fismaSystem['OwnerContact']:array());
	$systemOwnerLink = (isset($systemOwner['AdAccount']['id'])?$this->Html->link($systemOwner['AdAccount']['name'], array('controller' => 'ad_accounts', 'action' => 'view', $systemOwner['AdAccount']['id'])):'');
	$systemOwnerPath = $this->Contacts->makePath($systemOwner);

	$td[$i]['parent'] = (isset($fismaSystem['FismaSystemParent']['name'])?$fismaSystem['FismaSystemParent']['name']:'');
	$td[$i]['name'] = __('(%s) %s', $fismaSystem['FismaSystem']['name'], (isset($fismaSystem['FismaSystem']['fullname'])?$fismaSystem['FismaSystem']['fullname']:''));
	$td[$i]['owner'] = ($systemOwner['AdAccount']?$systemOwnerLink. '<br/>'.$systemOwnerPath:'');
	
	$td[$i]['fips'] = (isset($fismaSystem['FismaSystemFipsRating']['name'])?$fismaSystem['FismaSystemFipsRating']['name']:'');
	$td[$i]['gss'] = (isset($fismaSystem['FismaSystemGssStatus']['name'])?$fismaSystem['FismaSystemGssStatus']['name']:'');
	$td[$i]['pii_count'] = array(
		(($fismaSystem['FismaSystem']['pii_count'] > 0)?$fismaSystem['FismaSystem']['pii_count']:0),
		array(
			'value' => (($fismaSystem['FismaSystem']['pii_count'] > 0)?$fismaSystem['FismaSystem']['pii_count']:0),
			'class' => (($fismaSystem['FismaSystem']['pii_count'] > 0)?'highlight bold':''),
		)
	);
	$td[$i]['actions_right'] = array(
		$actions, 
		array('class' => 'actions'),
	);
}
echo $this->element('Utilities.page_index', array(
	'page_title' => __('All %s', __('FISMA Systems')),
	'th' => $th,
	'td' => $td,
	'use_pagination' => false,
	'use_search' => false,
));