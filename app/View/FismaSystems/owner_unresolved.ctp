<?php

$page_options = array();

if($this->Common->roleCheck(array('admin', 'saa')) and isset($owners) and !$isSubscription)
{
	foreach($owners as $owner_id => $owner_name)
	{
		$page_options[$owner_id] = $this->Html->link($owner_name, array('action' => $this->request->action, $owner_id));
	}
}

$page_options2 = array();
if($this->Common->roleCheck(array('admin', 'saa', 'crm')) and isset($crm_owners) and !$isSubscription)
{
	foreach($crm_owners as $crm_owner_id => $crm_owner_name)
	{
		$page_options2[$crm_owner_id] = $this->Html->link($crm_owner_name, array('action' => 'unresolved', $crm_owner_id, $crm_id, 'owner' => true));
	}
}

$this->start('page_content'); 

$content = array();

$counts = array(
	'FismaSystems' => array('name' => __('# %s', __('FISMA Systems')), 'value' => 0),
	'TotalResults' => array('name' => __('# OPEN %s', __('Results')), 'value' => 0),
	'EolResults' => array('name' => __('# OPEN %s', __('End Of Life')), 'value' => 0),
	'PenTestResults' => array('name' => __('# OPEN %s', __('Penetration Tests')), 'value' => 0),
	'HighRiskResults' => array('name' => __('# OPEN %s', __('High Risk Vulnerabilities')), 'value' => 0),
);

$recommendedActions = array();
$fismaSystemsIndex = array();

foreach ($fismaSystems as $y => $fismaSystem)
{
	$counts['FismaSystems']['value']++;
	
	$fismaCounts = array(
		'TotalResults' => array('name' => __('# OPEN %s', __('Results')), 'value' => 0),
		'EolResults' => array('name' => __('# OPEN %s (EOL)', __('End Of Life')), 'value' => 0),
		'PenTestResults' => array('name' => __('# OPEN %s (PT)', __('Penetration Tests')), 'value' => 0),
		'HighRiskResults' => array('name' => __('# OPEN %s (HRV)', __('High Risk Vulnerabilities')), 'value' => 0),
	);
	
	$fismaCounts['TotalResults']['value'] = count($fismaSystem['EolResults']) + count($fismaSystem['PenTestResults']) + count($fismaSystem['HighRiskResults']);
	$resultContent = array();
	$totalCount = 0;
		
	// track the fisma systems
	if(isset($fismaSystem['FismaSystem']['id']) and !isset($fismaSystemsIndex[$fismaSystem['FismaSystem']['id']]))
		$fismaSystemsIndex[$fismaSystem['FismaSystem']['id']] = $fismaSystem['FismaSystem'];
	
	$th = array();
	$th['type'] = array('content' => __('Type'));
	$th['vulnerability'] = array('content' => __('Vulnerability/Software'));
	$th['ip_address'] = array('content' => __('Ip Address'));
	$th['host_name'] = array('content' => __('Host Name'));
	$th['reported_to_ic_date'] = array('content' => __('Reported to ORG/IC'));
	$th['resolved_by_date'] = array('content' => __('Must be Resolved By'));
	$th['tickets'] = array('content' => __('Tickets'));
	$th['waiver'] = array('content' => __('Waivers'));
	$th['changerequest'] = array('content' => __('Change Request IDs'));
	
	$td = array();
	$i = 0;
	$thresholdNow = time();
	$thresholdSoon = strtotime('+10 days');
	
	if(count($fismaSystem['EolResults']))
	{
		$counts['EolResults']['value'] = ($counts['EolResults']['value'] + count($fismaSystem['EolResults']));
		$counts['TotalResults']['value'] = ($counts['TotalResults']['value'] + count($fismaSystem['EolResults']));
		$fismaCounts['EolResults']['value'] = count($fismaSystem['EolResults']);
		
		foreach ($fismaSystem['EolResults'] as $result)
		{
			$highlightDueDate = false;
			if(isset($result['EolResult']['resolved_by_date']) 
				and isset($result['ReportsStatus']['name'])
				and $this->Common->slugify($result['ReportsStatus']['name']) == 'open')
			{
				if($result['EolResult']['resolved_by_date'] == '0000-00-00 00:00:00')
					$result['EolResult']['resolved_by_date'] = false;
				$resolvedByDate = strtotime($result['EolResult']['resolved_by_date']);
				if($resolvedByDate)
				{
					if($resolvedByDate <= $thresholdNow)
						$highlightDueDate = 'highlight-red';
					elseif($resolvedByDate <= $thresholdSoon)
						$highlightDueDate = 'highlight-yellow';
				}
			}
			
			// track the recommended actions
			if(isset($result['EolSoftware']['id']) and !isset($recommendedActions[$result['EolSoftware']['id']]))
				$recommendedActions[$result['EolSoftware']['id']] = $result['EolSoftware'];
		
			$i++;
			$td[$i] = array();
			$td[$i]['type'] = __('EOL');
			$td[$i]['vulnerability'] = $result['EolSoftware']['name'];
			$td[$i]['ip_address'] = $result['EolResult']['ip_address'];
			$td[$i]['host_name'] = $result['EolResult']['host_name'];
			$td[$i]['reported_to_ic_date'] = array($this->Wrap->niceDay($result['EolResult']['reported_to_ic_date'], false), array('data-date-raw' => $result['EolResult']['reported_to_ic_date']));
			$td[$i]['resolved_by_date'] = array($this->Wrap->niceDay($result['EolResult']['resolved_by_date'], false), array('class' => $highlightDueDate, 'data-date-raw' => $result['EolResult']['resolved_by_date']));
			$td[$i]['tickets'] = array($this->Local->ticketLinks($result['EolResult']['tickets']), array('class' => 'nowrap'));
			$td[$i]['waiver'] = array($this->Local->waiverLinks($result['EolResult']['waiver']), array('class' => 'nowrap'));
			$td[$i]['changerequest'] = array($this->Local->crLinks($result['EolResult']['changerequest']), array('class' => 'nowrap'));
		}
	}
	
	if(count($fismaSystem['PenTestResults']))
	{
		$counts['PenTestResults']['value'] = ($counts['PenTestResults']['value'] + count($fismaSystem['PenTestResults']));
		$counts['TotalResults']['value'] = ($counts['TotalResults']['value'] + count($fismaSystem['PenTestResults']));
		$fismaCounts['PenTestResults']['value'] = count($fismaSystem['PenTestResults']);
		
		foreach ($fismaSystem['PenTestResults'] as $result)
		{
			$highlightDueDate = false;
			if(isset($result['PenTestResult']['resolved_by_date']) 
				and isset($result['ReportsStatus']['name'])
				and $this->Common->slugify($result['ReportsStatus']['name']) == 'open')
			{
				if($result['PenTestResult']['resolved_by_date'] == '0000-00-00 00:00:00')
					$result['PenTestResult']['resolved_by_date'] = false;
				$resolvedByDate = strtotime($result['PenTestResult']['resolved_by_date']);
				if($resolvedByDate)
				{
					if($resolvedByDate <= $thresholdNow)
						$highlightDueDate = 'highlight-red';
					elseif($resolvedByDate <= $thresholdSoon)
						$highlightDueDate = 'highlight-yellow';
				}
			}
			
			// track the recommended actions
			if(isset($result['EolSoftware']['id']) and !isset($recommendedActions[$result['EolSoftware']['id']]))
				$recommendedActions[$result['EolSoftware']['id']] = $result['EolSoftware'];
			
			$reported_to_ic = false;
			if($result['PenTestResult']['reported_to_ic_date'])
				$reported_to_ic = $result['PenTestResult']['reported_to_ic_date'];
			
			$i++;
			$td[$i] = array();
			$td[$i]['type'] = __('PT');
			$td[$i]['vulnerability'] = $result['EolSoftware']['name'];
			$td[$i]['ip_address'] = $result['PenTestResult']['ip_address'];
			$td[$i]['host_name'] = $result['PenTestResult']['host_name'];
			$td[$i]['reported_to_ic_date'] = array($this->Wrap->niceDay($reported_to_ic, false), array('data-date-raw' => $reported_to_ic));
			$td[$i]['resolved_by_date'] = array($this->Wrap->niceDay($result['PenTestResult']['resolved_by_date'], false), array('class' => $highlightDueDate, 'data-date-raw' => $result['PenTestResult']['resolved_by_date']));
			$td[$i]['tickets'] = array($this->Local->ticketLinks($result['PenTestResult']['tickets']), array('class' => 'nowrap'));
			$td[$i]['waiver'] = array($this->Local->waiverLinks($result['PenTestResult']['waiver']), array('class' => 'nowrap'));
			$td[$i]['changerequest'] = array($this->Local->crLinks($result['PenTestResult']['changerequest']), array('class' => 'nowrap'));
		}
	}

	if(count($fismaSystem['HighRiskResults']))
	{
		$counts['HighRiskResults']['value'] = ($counts['HighRiskResults']['value'] + count($fismaSystem['HighRiskResults']));
		$counts['TotalResults']['value'] = ($counts['TotalResults']['value'] + count($fismaSystem['HighRiskResults']));
		$fismaCounts['HighRiskResults']['value'] = count($fismaSystem['HighRiskResults']);

		foreach ($fismaSystem['HighRiskResults'] as $result)
		{
			$highlightDueDate = false;
			if(isset($result['HighRiskResult']['resolved_by_date']) 
				and isset($result['ReportsStatus']['name'])
				and $this->Common->slugify($result['ReportsStatus']['name']) == 'open')
			{
				if($result['HighRiskResult']['resolved_by_date'] == '0000-00-00 00:00:00')
					$result['HighRiskResult']['resolved_by_date'] = false;
				$resolvedByDate = strtotime($result['HighRiskResult']['resolved_by_date']);
				if($resolvedByDate)
				{
					if($resolvedByDate <= $thresholdNow)
						$highlightDueDate = 'highlight-red';
					elseif($resolvedByDate <= $thresholdSoon)
						$highlightDueDate = 'highlight-yellow';
				}
			}
			
			// track the recommended actions
			if(isset($result['EolSoftware']['id']) and !isset($recommendedActions[$result['EolSoftware']['id']]))
				$recommendedActions[$result['EolSoftware']['id']] = $result['EolSoftware'];
		
			$i++;
			$td[$i] = array();
			$td[$i]['type'] = __('HRV');
			$td[$i]['vulnerability'] = $result['EolSoftware']['name'];
			$td[$i]['ip_address'] = $result['HighRiskResult']['ip_address'];
			$td[$i]['host_name'] = $result['HighRiskResult']['host_name'];
			$td[$i]['reported_to_ic_date'] = array($this->Wrap->niceDay($result['HighRiskResult']['reported_to_ic_date'], false), array('data-date-raw' => $result['HighRiskResult']['reported_to_ic_date']));
			$td[$i]['resolved_by_date'] = array($this->Wrap->niceDay($result['HighRiskResult']['resolved_by_date'], false), array('class' => $highlightDueDate, 'data-date-raw' => $result['HighRiskResult']['resolved_by_date']));
			$td[$i]['tickets'] = array($this->Local->ticketLinks($result['HighRiskResult']['ticket']), array('class' => 'nowrap'));
			$td[$i]['waiver'] = array($this->Local->waiverLinks($result['HighRiskResult']['waiver']), array('class' => 'nowrap'));
			$td[$i]['changerequest'] = array($this->Local->crLinks($result['HighRiskResult']['changerequest']), array('class' => 'nowrap'));
		}
	}
	
	$divisionName = false;
	if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['id']))
		$divisionName = __('%s - %s', $fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname'], $fismaSystem['OwnerContact']['Sac']['Branch']['Division']['name']);
		
	$divisionDirector = false;
	if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['DivisionDirector']['id']))
		$divisionDirector = $fismaSystem['OwnerContact']['Sac']['Branch']['Division']['DivisionDirector']['name'];
	
	$branchName = false;
	if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['id']))
		$branchName = __('%s - %s', $fismaSystem['OwnerContact']['Sac']['Branch']['shortname'], $fismaSystem['OwnerContact']['Sac']['Branch']['name']);
		
	$branchPoc = false;
	if(isset($fismaSystem['OwnerContact']['Sac']['Branch']['BranchDirector']['id']))
		$branchPoc = $fismaSystem['OwnerContact']['Sac']['Branch']['BranchDirector']['name'];
	
	$details_blocks = [];
	
	$details_blocks[1][1] = [
		'title' => __('Details'),
		'details' => [
			['name' => __('Division'), 'value' => $divisionName],
			['name' => __('Division Director'), 'value' => $divisionDirector],
			['name' => __('Branch'), 'value' => $branchName],
			['name' => __('Branch POC'), 'value' => $branchPoc],

		],
	];
	
	$crmName = false;
	if(isset($fismaSystem['OwnerContact']['Sac']['SacCrm']['id']))
		$crmName = $fismaSystem['OwnerContact']['Sac']['SacCrm']['name'];
	elseif(isset($fismaSystem['OwnerContact']['Sac']['Branch']['BranchCrm']['id']))
		$crmName = $fismaSystem['OwnerContact']['Sac']['Branch']['BranchCrm']['name'];
	elseif(isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['DivisionCrm']['id']))
		$crmName = $fismaSystem['OwnerContact']['Sac']['Branch']['Division']['DivisionCrm']['name'];
	elseif(isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgCrm']['id']))
		$crmName = $fismaSystem['OwnerContact']['Sac']['Branch']['Division']['Org']['OrgCrm']['name'];
	
	$isso = $this->ReportResults->getFismaSystemContact($fismaSystem, 'is_isso');
	$daa = $this->ReportResults->getFismaSystemContact($fismaSystem, 'is_daa');
	
	$details_blocks[1][2] = [
		'title' => '&nbsp;',
		'details' => [
			['name' => __('CIO/AO'), 'value' => $daa],
			['name' => __('ISSO'), 'value' => $isso],
			['name' => __('EXAMPLE CRM'), 'value' => $crmName],
		],
	];
	
	foreach($fismaCounts as $f => $fismaCount)
		if(!$fismaCount['value'])
			$fismaCounts[$f]['value'] = '0&nbsp;';
	
	$details_blocks[1][3] = array(
		'title' => __('Result Counts'),
		'details' => $fismaCounts,
	);
	
	$resultContent[] = $this->element('Utilities.page_view_columns', array(
		'page_subtitle' => __('%s: %s', __('FISMA System'), $fismaSystem['FismaSystem']['name']),
		'page_subtitle2' => $this->Contacts->makePath($fismaSystem, true),
		'details_blocks' => $details_blocks,
		'details_options' => array('viewToggles' => false),
		'subscribable' => false,
	));
	
	if(count($td))
	{
		usort($td, function ($td1, $td2) {
			$item1 = $td2['resolved_by_date'][1]['data-date-raw'];
			$item2 = $td1['resolved_by_date'][1]['data-date-raw'];
			if ($item1 == $item2) return 0;
			return $item1 < $item2 ? -1 : 1;
		});
	
		$resultContent[] = $this->element('Utilities.table', array(
			'th' => $th,
			'td' => $td,
			'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.'),
			'table_widget_options' => array(
				'setup' => "self.element.find('td.highlight-red').parent().addClass('highlight-red'); self.element.find('td.highlight-yellow').parent().addClass('highlight-yellow');"
			),
			'export_name' => __('Unresolved Results for %s', $fismaSystem['FismaSystem']['name']),
			'use_search' => false,
			'use_filter' => false,
			'filter_plugin' => false,
			'use_multiselect' => false,
			'show_refresh_table' => false,
			'use_pagination' => false,
			'use_collapsible_columns' => false,
			'use_show_all' => false,
			'use_js_search' => false,
		));
	}
	
	$content[] = $this->Html->tag('div', implode('', $resultContent), array('class' => 'consolidated-section', 'id' => 'fisma-system-'. $fismaSystem['FismaSystem']['id']));
}

if(!count($fismaSystems))
{
	$nr_desc = __('There are no open End of Life, Penetration Test or High Risk Vulnerability action items for your FISMA System(s)');
	$nr_content = $this->Html->tag('div', $nr_desc, array('class' => 'no_results'));
	$content[] = $this->Html->tag('div', $nr_content, array('class' => 'object-table nihfo-object nihfo-object-table'));
}

$stats = array();

$ownerFismaSystemTraining = null;
if(isset($owner['AdAccountDetail']['fisma_training_date']))
	$ownerFismaSystemTraining = $owner['AdAccountDetail']['fisma_training_date'];

$stats['fisma_training_date'] = array(
	'id' => 'fisma_training_date',
	'name' => __('Last FISMA System Owner Training'),
	'value' => $this->Wrap->niceDay($ownerFismaSystemTraining),
);

foreach($counts as $k => $count)
{
	$stats[$k] = array(
		'id' => $k,
		'name' => $count['name'], 
		'value' => $count['value'],
	);
}

$stats_html = $this->element('Utilities.stats', array(
	'title' => '',
	'stats' => $stats,
)); 

if($recommendedActions)
{
	$ralis = array();
	foreach($recommendedActions as $y => $recommendedAction)
	{
		$ralis[$y] = $this->Html->tag('h4', $recommendedAction['name']).$this->Html->tag('p', $recommendedAction['action_recommended']);
		$ralis[$y]  = $this->Html->tag('li', $ralis[$y]);
	}
	
	$recommendedActionsList = $this->Html->tag('ul', implode("\n", $ralis), array('class' => 'recommended-actions'));
	
	$content[] = $this->Html->clearb();
	$content[] = $this->Html->tag('h2', __('Recommended Actions'), array('class' => 'page-subtitle'));
	$content[] = $this->Html->tag('div', $recommendedActionsList, array('class' => 'consolidated-section'));
}

if($fismaSystemsIndex)
{
	$ralis = array();
	foreach($fismaSystemsIndex as $y => $fismaSystemIndex)
	{
//		$ralis[$y] = $this->Html->tag('h4', $this->Html->link($fismaSystemIndex['name'], '#fisma-system-'. $fismaSystem['FismaSystem']['id'])).$this->Html->tag('p', $fismaSystemIndex['fullname']);
		$ralis[$y] = $this->Html->tag('h4', $fismaSystemIndex['name']).$this->Html->tag('p', $fismaSystemIndex['fullname']);
		$ralis[$y]  = $this->Html->tag('li', $ralis[$y]);
	}
	
	$fismaSystemsIndexList = $this->Html->tag('ul', implode("\n", $ralis), array('class' => 'fisma-system-index recommended-actions'));
	
	$content[] = $this->Html->clearb();
	$content[] = $this->Html->tag('h2', __('FISMA Systems Index'), array('class' => 'page-subtitle'));
	$content[] = $this->Html->tag('div', $fismaSystemsIndexList, array('class' => 'consolidated-section'));
}

//array_unshift($content, $stats_html);
echo implode("\n", $content);

$this->end(); // $this->start('page_content'); 
$page_content = $this->fetch('page_content');

$page_content = $this->Html->tag('div', $page_content, array('class' => 'consolidated-view'));

		
echo $this->element('Utilities.page_generic', array(
	'page_title' => __('Unresolved Results for: %s', $owner['AdAccount']['name']),
	'page_subtitle' => __('%s with OPEN Results that need to be resolved.', __('FISMA Systems')),
	'page_subtitle2' => __('Page created on %s', $this->Wrap->niceTime(date('Y-m-d H:i:s'))),
	'page_options_html' => $stats_html,
	'page_options_title' => __('View Results for:'),
	'page_options' => $page_options,
	'page_options_title2' => __('System Owners'),
	'page_options2' => $page_options2,
	'page_content' => $page_content,
));