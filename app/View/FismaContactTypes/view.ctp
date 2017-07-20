<?php 
// File: app/View/FismaContactTypes/view.ctp
$page_options = array();

if($this->Wrap->roleCheck(array('admin')))
{
	$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $fisma_contact_type['FismaContactType']['id'], 'admin' => true));
	$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $fisma_contact_type['FismaContactType']['id'], 'admin' => true), array('confirm' => __('Are you sure?')));
}

$details = array(
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fisma_contact_type['FismaContactType']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fisma_contact_type['FismaContactType']['modified'])),
);

$stats = array();
$tabs = array();

$tabs['contacts'] = $stats['contacts'] = array(
	'id' => 'contacts',
	'name' => __('Contacts'), 
	'ajax_url' => array('controller' => 'ad_accounts_fisma_systems', 'action' => 'fisma_contact_type', $fisma_contact_type['FismaContactType']['id']),
);
$tabs['no_fisma_contact_type'] = $stats['no_fisma_contact_type'] = array(
	'id' => 'no_fisma_contact_type',
	'name' => __('%s missing this %s', __('FISMA Systems'), __('Contact Type')),
	'ajax_url' => array('controller' => 'fisma_systems', 'action' => 'no_fisma_contact_type', $fisma_contact_type['FismaContactType']['id']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s : %s', __('%s %s', __('FISMA Contact'), __('Types')), $fisma_contact_type['FismaContactType']['name']),
	'page_options' => $page_options,
	'details_title' => __('Details'),
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));