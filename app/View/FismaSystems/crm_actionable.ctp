<?php 

$page_options = array();

if($this->Common->roleCheck(array('admin', 'saa')) and isset($crms))
{
	foreach($crms as $crm_id => $crm_name)
	{
		$page_options[$crm_id] = $this->Html->link($crm_name, array('action' => $this->request->action, $crm_id));
	}
}

$this->start('page_content'); 

usort($fismaSystems, function ($fismaSystems1, $fismaSystems2) {
	$item1 = $fismaSystems1['OwnerContact']['Sac']['Branch']['Division']['id'];
	$item2 = $fismaSystems2['OwnerContact']['Sac']['Branch']['Division']['id'];
	if ($item1 == $item2) return 0;
    return $item1 < $item2 ? -1 : 1;
});

$content = array();

$counts = array(
	'FismaSystems' => array('name' => __('# %s', __('FISMA Systems')), 'value' => 0),
	'TotalResults' => array('name' => __('# OPEN %s', __('Results')), 'value' => 0),
	'EolResults' => array('name' => __('# OPEN %s', __('End Of Life')), 'value' => 0),
	'PenTestResults' => array('name' => __('# OPEN %s', __('Penetration Tests')), 'value' => 0),
	'HighRiskResults' => array('name' => __('# OPEN %s', __('High Risk Vulnerabilities')), 'value' => 0),
);
foreach ($fismaSystems as $i => $fismaSystem)
{
	$counts['FismaSystems']['value']++;
	$resultContent = array();
	$details_blocks = array();
	
	$systemOwner['AdAccount'] = (isset($fismaSystem['OwnerContact'])?$fismaSystem['OwnerContact']:array());
	
	$details_blocks[1][1] = array(
		'title' => __('Details'),
		'details' => array(
			array('name' => __('Name'), 'value' => $fismaSystem['FismaSystem']['fullname']),
			array('name' => __('Division/Branch'), 'value' => (isset($systemOwner['AdAccount']['Sac']['Branch']['Division']['id'])?__('%s - %s', $systemOwner['AdAccount']['Sac']['Branch']['Division']['shortname'], $systemOwner['AdAccount']['Sac']['Branch']['Division']['name']):'').' / '.(isset($systemOwner['AdAccount']['Sac']['Branch']['id'])?__('%s - %s', $systemOwner['AdAccount']['Sac']['Branch']['shortname'], $systemOwner['AdAccount']['Sac']['Branch']['name']):'')),
			array('name' => __('Division/Branch Directors'), 'value' => (isset($systemOwner['AdAccount']['Sac']['Branch']['Division']['DivisionDirector']['id'])?$systemOwner['AdAccount']['Sac']['Branch']['Division']['DivisionDirector']['name']:'').' / '.(isset($systemOwner['AdAccount']['Sac']['Branch']['BranchDirector']['id'])?$systemOwner['AdAccount']['Sac']['Branch']['BranchDirector']['name']:'')),
			array('name' => __('System Owner'), 'value' => (isset($systemOwner['AdAccount']['id'])?$systemOwner['AdAccount']['name']:'').' / '.(isset($systemOwner['AdAccount']['id'])?$systemOwner['AdAccount']['username']:'').' / '.(isset($systemOwner['AdAccount']['id'])?$this->Html->link($systemOwner['AdAccount']['email'], 'mailto:'. $systemOwner['AdAccount']['email']):'')),
		),
	);
	$totalCount = count($fismaSystem['EolResults']) + count($fismaSystem['PenTestResults']) + count($fismaSystem['HighRiskResults']);
	$details_blocks[1][2] = array(
		'title' => __('Result Counts'),
		'details' => array(
			array('name' => __('Total'), 'value' => $totalCount),
			array('name' => __('OPEN End Of Life #'), 'value' => (count($fismaSystem['EolResults'])?count($fismaSystem['EolResults']):'0&nbsp;')),
			array('name' => __('OPEN Penetration Tests #'), 'value' => (count($fismaSystem['PenTestResults'])?count($fismaSystem['PenTestResults']):'0&nbsp;')),
			array('name' => __('OPEN High Risk Vulnerability #'), 'value' => (count($fismaSystem['HighRiskResults'])?count($fismaSystem['HighRiskResults']):'0&nbsp;')),
		),
	);
	
	$th = array();
	$th['type'] = array('content' => __('Type'));
	$th['vulnerability'] = array('content' => __('Vulnerability/Software'));
	$th['ip_address'] = array('content' => __('Ip Address'));
	$th['host_name'] = array('content' => __('Host Name'));
	$th['reported_to_ic_date'] = array('content' => __('Reported to ORG/IC'));
	$th['resolved_by_date'] = array('content' => __('Must be Resolved By'));
	$th['tickets'] = array('content' => __('Tickets'));
	$th['waiver'] = array('content' => __('Waiver'));
	
	$thresholdNow = time();
	$thresholdSoon = strtotime('+10 days');
	$td = array();
	$i=0;
	if(count($fismaSystem['EolResults']))
	{
		$counts['EolResults']['value'] = ($counts['EolResults']['value'] + count($fismaSystem['EolResults']));
		$counts['TotalResults']['value'] = ($counts['TotalResults']['value'] + count($fismaSystem['EolResults']));
		foreach ($fismaSystem['EolResults'] as $result)
		{
			$i++;
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
			
			$td[$i] = array();
			$td[$i]['type'] = __('EOL');
			$td[$i]['vulnerability'] = $result['EolSoftware']['name'];
			$td[$i]['ip_address'] = $result['EolResult']['ip_address'];
			$td[$i]['host_name'] = $result['EolResult']['host_name'];
			$td[$i]['reported_to_ic_date'] = array($this->Wrap->niceDay($result['EolResult']['reported_to_ic_date'], false), array('data-date-raw' => $result['EolResult']['reported_to_ic_date']));
			$td[$i]['resolved_by_date'] = array($this->Wrap->niceDay($result['EolResult']['resolved_by_date'], false), array('class' => $highlightDueDate, 'data-date-raw' => $result['EolResult']['resolved_by_date']));
			$td[$i]['tickets'] = array($this->Local->ticketLinks($result['EolResult']['tickets']), array('class' => 'nowrap'));
			$td[$i]['waiver'] = array($this->Local->waiverLinks($result['EolResult']['waiver']), array('class' => 'nowrap'));
		}
	}

	if(count($fismaSystem['PenTestResults']))
	{
		$counts['PenTestResults']['value'] = ($counts['PenTestResults']['value'] + count($fismaSystem['PenTestResults']));
		$counts['TotalResults']['value'] = ($counts['TotalResults']['value'] + count($fismaSystem['PenTestResults']));
		foreach ($fismaSystem['PenTestResults'] as $result)
		{
			$i++;
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
			
			$td[$i] = array();
			$td[$i]['type'] = __('PT');
			$td[$i]['vulnerability'] = $result['PenTestResult']['vulnerability'];
			$td[$i]['ip_address'] = $result['PenTestResult']['ip_address'];
			$td[$i]['host_name'] = $result['PenTestResult']['host_name'];
			$td[$i]['reported_to_ic_date'] = array($this->Wrap->niceDay($result['PenTestResult']['reported_to_ic_date'], false), array('data-date-raw' => $result['PenTestResult']['reported_to_ic_date']));
			$td[$i]['resolved_by_date'] = array($this->Wrap->niceDay($result['PenTestResult']['resolved_by_date'], false), array('class' => $highlightDueDate, 'data-date-raw' => $result['PenTestResult']['resolved_by_date']));
			$td[$i]['tickets'] = array($this->Local->ticketLinks($result['PenTestResult']['tickets']), array('class' => 'nowrap'));
			$td[$i]['waiver'] = array($this->Local->waiverLinks($result['PenTestResult']['waiver']), array('class' => 'nowrap'));
		}
	}

	if(count($fismaSystem['HighRiskResults']))
	{
		$counts['HighRiskResults']['value'] = ($counts['HighRiskResults']['value'] + count($fismaSystem['HighRiskResults']));
		$counts['TotalResults']['value'] = ($counts['TotalResults']['value'] + count($fismaSystem['HighRiskResults']));
		foreach ($fismaSystem['HighRiskResults'] as $result)
		{
			$i++;
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
			
			$td[$i] = array();
			$td[$i]['type'] = __('HRV');
			$td[$i]['vulnerability'] = $result['HighRiskResult']['vulnerability'];
			$td[$i]['ip_address'] = $result['HighRiskResult']['ip_address'];
			$td[$i]['host_name'] = $result['HighRiskResult']['host_name'];
			$td[$i]['reported_to_ic_date'] = array($this->Wrap->niceDay($result['HighRiskResult']['reported_to_ic_date'], false), array('data-date-raw' => $result['HighRiskResult']['reported_to_ic_date']));
			$td[$i]['resolved_by_date'] = array($this->Wrap->niceDay($result['HighRiskResult']['resolved_by_date'], false), array('class' => $highlightDueDate, 'data-date-raw' => $result['HighRiskResult']['resolved_by_date']));
			$td[$i]['tickets'] = array($this->Local->ticketLinks($result['HighRiskResult']['ticket']), array('class' => 'nowrap'));
			$td[$i]['waiver'] = array($this->Local->waiverLinks($result['HighRiskResult']['waiver']), array('class' => 'nowrap'));
		}
	}
	
	$resultContent[] = $this->element('Utilities.page_view_columns', array(
		'page_subtitle' => __('%s: %s', __('FISMA System'), $fismaSystem['FismaSystem']['name']),
		'page_subtitle2' => $this->Contacts->makePath($fismaSystem, true),
		'details_blocks' => $details_blocks,
		'details_options' => array('viewToggles' => false),
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
			'table_stripped' => true,
			'table_widget_options' => array(
				'setup' => "
					self.element.find('td.highlight-red').parent().addClass('highlight-red');
					self.element.find('td.highlight-yellow').parent().addClass('highlight-yellow');
				"
			),
		));
	}
	$content[] = $this->Html->tag('div', implode('', $resultContent), array('class' => 'consolidated-section'));
}

$stats = array();
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
//array_unshift($content, $stats_html);
echo implode("\n", $content);

$this->end(); // $this->start('page_content'); 
$page_content = $this->fetch('page_content');

$page_content = $this->Html->tag('div', $page_content, array('class' => 'consolidated-view'));

echo $this->element('Utilities.page_generic', array(
	'page_title' => __('Unresolved Results (by system) for: %s', $crm['AdAccount']['name']),
	'page_subtitle' => __('%s with OPEN Results that need to be resolved.', __('FISMA Systems')),
	'page_subtitle2' => __('Page loaded on %s', $this->Wrap->niceTime(date('Y-m-d H:i:s'))),
	'page_options_html' => $stats_html,
	'page_options_title' => __('View Results for:'),
	'page_options' => $page_options,
	'page_content' => $page_content,
));