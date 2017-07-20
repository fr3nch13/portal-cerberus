<?php 

$page_subtitle = (isset($page_subtitle)?$page_subtitle:__('All Results'));
$page_options = array();
$page_options['PoamStatus.0'] = $this->Html->link(__('All Results'), $this->Html->urlModify(array('poam_status_id' => 0)), array('class' => 'tab-hijack block-hijack'));
foreach($poamStatuses as $poamStatus_id => $poamStatus_name)
{
	$page_options['PoamStatus.'. $poamStatus_id] = $this->Html->link(__('With Status: %s', $poamStatus_name), $this->Html->urlModify(array('poam_status_id' => $poamStatus_id)), array('class' => 'tab-hijack'));
}

$th = array(
	'PoamResult.id' => array('content' => __('ID'), 'options' => array('sort' => 'PoamResult.id')),
	'PoamResult.weakness_id' => array('content' => __('Weakness ID'), 'options' => array('sort' => 'PoamResult.weakness_id' )),
	'PoamResult.report_count' => array('content' => __('# Reports')),
	'PoamResult.Division' => array('content' => __('Division')),
	'PoamResult.Branch' => array('content' => __('Branch')),
	'FismaSystem.name' => array('content' => __('FISMA System'), 'options' => array('sort' => 'FismaSystem.name')),
	'PoamResult.fisma_system.owner_contact_id' => array('content' => __('System Owner')),
	'PoamResult.fisma_system.tech_poc_id' => array('content' => __('Tech POCs')),
	'PoamResult.description' => array('content' => __('Description')),
	'PoamResult.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'PoamResult.tickets', 'editable' => array('type' => 'text'))),
	'PoamResult.waiver' => array('content' => __('Waivers'), 'options' => array('sort' => 'PoamResult.waiver', 'editable' => array('type' => 'text'))),
	'PoamCriticality.name' => array('content' => __('Criticality'), 'options' => array('sort' => 'PoamCriticality.name')),
	'PoamRisk.name' => array('content' => __('Risk'), 'options' => array('sort' => 'PoamRisk.name')),
	'PoamSeverity.name' => array('content' => __('Severity'), 'options' => array('sort' => 'PoamSeverity.name')),
	'PoamStatus.name' => array('content' => __('Status'), 'options' => array('sort' => 'PoamStatus.name')),
	'PoamResult.auto_closed' => array('content' => __('Auto Closed'), 'options' => array('sort' => 'PoamResult.auto_closed')),
	'PoamResult.identified_date' => array('content' => __('Identified Date'), 'options' => array('sort' => 'PoamResult.identified_date')),
	'PoamResult.creation_date' => array('content' => __('Creation Date'), 'options' => array('sort' => 'PoamResult.creation_date')),
	'PoamResult.scheduled_completion_date' => array('content' => __('Scheduled Completion Date'), 'options' => array('sort' => 'PoamResult.scheduled_completion_date')),
	'PoamResult.estimated_completion_date' => array('content' => __('Estimated Completion Date'), 'options' => array('sort' => 'PoamResult.estimated_completion_date')),
	'PoamResult.actual_completion_date' => array('content' => __('Actual Completion Date'), 'options' => array('sort' => 'PoamResult.actual_completion_date')),
	'PoamResult.modified' => array('content' => __('Modified'), 'options' => array('sort' => 'PoamResult.modified' )),
	'PoamResult.created' => array('content' => __('Created'), 'options' => array('sort' => 'PoamResult.created' )),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
	'multiselect' => true,
); 

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach ($poamResults as $i => $poamResult)
{
	// fix for the crazy xref stuff
	if(isset($poamResult['PoamResult']['PoamStatus']))
		$poamResult['PoamStatus'] = $poamResult['PoamResult']['PoamStatus'];
	
	$actions = array();
	$actions[] = $this->Html->link(__('View'), array('action' => 'view', $poamResult['PoamResult']['id']));
	if($this->Wrap->roleCheck(array('admin', 'reviewer', 'saa')))
		$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $poamResult['PoamResult']['id']));
	if($this->Wrap->roleCheck(array('admin')))
		$actions[] = $this->Html->link(__('Delete'), array('action' => 'delete', $poamResult['PoamResult']['id'], 'admin' => true), array('confirm' => __('Are you sure?')));
	
	$actions = implode("", $actions);
	
	$edit_id = array(
		'PoamResult' => $poamResult['PoamResult']['id'],
	);
	
	$poamResult = $this->ReportResults->addFismaSystemInfo($poamResult);
	
	$division = false;
	if(isset($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id']))
	{
		$division = $this->Html->link($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['shortname'], array('controller' => 'divisions', 'action' => 'view', $poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'], 'tab' => 'poam_results'));
	}
	$branch = false;
	if(isset($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['id']))
	{
		$branch = $this->Html->link($poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['shortname'], array('controller' => 'divisions', 'action' => 'view', $poamResult['FismaSystem']['OwnerContact']['Sac']['Branch']['id'], 'tab' => 'poam_results'));
	}
	
	$td[$i] = array(
		$this->Html->link($poamResult['PoamResult']['id'], array('action' => 'view', $poamResult['PoamResult']['id'])),
		$this->Html->link($poamResult['PoamResult']['weakness_id'], array('action' => 'view', $poamResult['PoamResult']['id'])),
		array('.', array(
			'ajax_count_url' => array('controller' => 'poam_reports', 'action' => 'poam_result', $poamResult['PoamResult']['id']), 
			'url' => array('action' => 'view', $poamResult['PoamResult']['id'], 'tab' => 'poam_reports'),
		)),
		$division,
		$branch,
		array($this->Html->link($poamResult['FismaSystem']['name'], array('controller' => 'fisma_systems', 'action' => 'view', $poamResult['FismaSystem']['id'], 'tab' => 'poam_results')), 
			array('value' => (isset($poamResult['FismaSystem']['id'])?$poamResult['FismaSystem']['id']:''))
		),
		$poamResult['owner_links'],
		$poamResult['techs_links'],
		$this->Html->tableDesc($poamResult['PoamResult']['description']),
		$this->Local->ticketLinks($poamResult['PoamResult']['tickets']),
		$this->Local->waiverLinks($poamResult['PoamResult']['waiver']),
		$this->Html->link($poamResult['PoamCriticality']['name'], array('poam_criticality_id' => $poamResult['PoamCriticality']['id'])),
		$this->Html->link($poamResult['PoamRisk']['name'], array('poam_risk_id' => $poamResult['PoamRisk']['id'])),
		$this->Html->link($poamResult['PoamSeverity']['name'], array('poam_severity_id' => $poamResult['PoamSeverity']['id'])),
		$this->Html->link($poamResult['PoamStatus']['name'], array('poam_status_id' => $poamResult['PoamStatus']['id'])),
		$this->Common->yesNo($poamResult['PoamResult']['auto_closed']),
		$this->Wrap->niceDay($poamResult['PoamResult']['identified_date']),
		$this->Wrap->niceDay($poamResult['PoamResult']['creation_date']),
		$this->Wrap->niceDay($poamResult['PoamResult']['scheduled_completion_date']),
		$this->Wrap->niceDay($poamResult['PoamResult']['estimated_completion_date']),
		$this->Wrap->niceDay($poamResult['PoamResult']['actual_completion_date']),
		$this->Wrap->niceDay($poamResult['PoamResult']['modified']),
		$this->Wrap->niceDay($poamResult['PoamResult']['created']),
		array(
			$actions,
			array('class' => 'actions'),
		),
		'multiselect' => $poamResult['PoamResult']['id'],
		'edit_id' => $edit_id,
	);
}

$use_gridedit = false;
if($this->Wrap->roleCheck(array('admin', 'reviewer', 'saa')))
	$use_gridedit = true;

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POA&M Results'),
	'page_subtitle' => (isset($page_subtitle)?$page_subtitle:false),
	'page_subtitle2' => (isset($page_subtitle2)?$page_subtitle2:false),
	'page_description' => $page_description,
	'page_options_title' => __('View By %s', __('Status')),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.<br/>%s with a &dagger; next to them have been manually chosen', __('FISMA Systems')),
	'table_widget_options' => array(
		'setup' => "
			self.element.find('td.highlight-red').parents('tr').addClass('highlight-red');
			self.element.find('td.highlight-yellow').parents('tr').addClass('highlight-yellow');
			self.element.find('td[data-style]').each(function(){ $(this).parents('tr').attr('style', $(this).data('style')) });
		"
	),
	'search_placeholder' => __('POA&M Results'),
	// grid/inline edit options
	'use_gridedit' => $use_gridedit,
));