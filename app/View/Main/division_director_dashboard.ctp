<?php 

$page_options = array();
if($this->Common->roleCheck(array('admin', 'saa')) and isset($directors))
{
	foreach($directors as $director_id => $director_name)
	{
		$page_options[$director_id] = $this->Html->link($director_name, array('action' => $this->request->action, $director_id));
	}
}

$tabs = array();
$details_blocks = array();
$recommendedActions = array();
$fismaSystemsIndex = array();

if($directorOf)
{
	if($directorOfList = $this->Contacts->listDirectorOf($directorOf, true, true))
	{
		$details_blocks[1][1] = array(
			'title' => ' ',
			'options' => array('class' => 'details details-long'),
			'details' => array(),
		);
		if(isset($directorOfList['divisions']))
			$details_blocks[1][1]['details'][] = array('name' => __('Director of %s:', __('Division')), 'value' => implode(', ', $directorOfList['divisions']));
		if(isset($crms) and $crms)
		{
			$_crms = array();
			foreach($crms as $email => $name)
			{
				$email = $this->Html->link($email, 'mailto:'. $email);
				$_crms[] = __('%s (%s)', $name, $email);
			}
			$details_blocks[1][1]['details'][] = array('name' => __('Customer Relationship Manager (CRM):'), 'value' => implode(', ', $_crms));
		}
		if(isset($daas) and $daas)
		{
			$_daas = array();
			foreach($daas as $email => $name)
			{
				$email = $this->Html->link($email, 'mailto:'. $email);
				$_daas[] = __('%s (%s)', $name, $email);
			}
			$details_blocks[1][1]['details'][] = array('name' => __('Chief Information Officer/Authorizing Official (CIO/AO):'), 'value' => implode(', ', $_daas));
		}
		if(isset($issos) and $issos)
		{
			$_issos = array();
			foreach($issos as $email => $name)
			{
				$email = $this->Html->link($email, 'mailto:'. $email);
				$_issos[] = __('%s (%s)', $name, $email);
			}
			$details_blocks[1][1]['details'][] = array('name' => __('Information System Security Officer (ISSO):'), 'value' => implode(', ', $_issos));
		}
	}
}

$counts = array(
	'TotalResults' => array('name' => __('# OPEN %s', __('Results')), 'value' => 0),
);
	
$th = array();
$th['id'] = array('content' => __('ID'));
$th['fisma_system'] = array('content' => __('FISMA System'));
$th['owner'] = array('content' => __('System Owner'));
$th['host'] = array('content' => __('Host'));
$th['vulnerability'] = array('content' => __('%s (see the %s tab)', __('Software/Vulnerability'), __('Recommended Actions')));
$th['reported_to_ic_date'] = array('content' => __('Reported to ORG/IC'));
$th['resolved_by_date'] = array('content' => __('Must be Resolved By'));
$th['tickets'] = array('content' => __('Tickets'));
//$th['waiver'] = array('content' => __('Waivers'));
//$th['changerequest'] = array('content' => __('Change Request IDs'));

$thresholdNow = time();
$thresholdSoon = strtotime('+10 days');
$td = array();
foreach($results as $i => $result)
{
	$counts['TotalResults']['value']++;
	$totalCount = 0;
	
	$result = $this->ReportResults->addFismaSystemInfo($result, true, true);

	$highlightDueDate = false;
	if(isset($result['PenTestResult']['resolved_by_date']))
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
	
	$reported_to_ic = null;
	if($result['PenTestResult']['reported_to_ic_date'])
		$reported_to_ic = $result['PenTestResult']['reported_to_ic_date'];
	
	$td[$i] = array();
	$td[$i]['id'] = $result['PenTestResult']['id'];
	$td[$i]['fisma_system'] = $result['fisma_system_links'];
	$td[$i]['owner'] = $result['owner_links'];
	$td[$i]['type'] = ($result['PenTestResult']['host_name']?$result['PenTestResult']['host_name']:$result['PenTestResult']['ip_address']);
	$td[$i]['vulnerability'] = $result['EolSoftware']['name'];
	$td[$i]['reported_to_ic_date'] = array($this->Wrap->niceDay($reported_to_ic, false), array('data-date-raw' => $reported_to_ic));
	$td[$i]['resolved_by_date'] = array($this->Wrap->niceDay($result['PenTestResult']['resolved_by_date'], false), array('class' => $highlightDueDate, 'data-date-raw' => $result['PenTestResult']['resolved_by_date']));
	$td[$i]['tickets'] = array($this->Local->ticketLinks($result['PenTestResult']['tickets']), array('class' => 'nowrap'));
//	$td[$i]['waiver'] = array($this->Local->waiverLinks($result['PenTestResult']['waiver']), array('class' => 'nowrap'));
//	$td[$i]['changerequest'] = array($this->Local->crLinks($result['PenTestResult']['changerequest']), array('class' => 'nowrap'));
}

$tabs['results'] = array(
	'id' => 'results',
	'name' => __('Results'),
	'content' => $this->element('Utilities.page_index', array(
		'page_title' => __('FISMA Systems'),
		'th' => $th,
		'td' => $td,
		'table_caption' => __('Highlights - Red: Open/past resolved by date - Yellow: Open/resolved by date within 10 days from now.<br/>%s with a &dagger; next to them have been manually chosen', __('FISMA Systems')),
		'table_widget_options' => array(
			'setup' => "self.element.find('td.highlight-red').parent().addClass('highlight-red'); self.element.find('td.highlight-yellow').parent().addClass('highlight-yellow');"
		),
		'table_export_name' => __('Unresolved Results for Division%s', (isset($directorOfList['divisions'])?' - '.implode(' and ', $directorOfList['divisions']):false)),
		'use_search' => false,
		'use_filter' => false,
		'filter_plugin' => false,
		'use_multiselect' => false,
		'show_refresh_table' => false,
		'use_pagination' => false,
		'use_collapsible_columns' => false,
		'use_show_all' => false,
		'use_js_search' => false,
		'no_records' => __('There are no open Penetration Test action items for your FISMA System(s)'),
		'subscribable' => false,
	)),
);

$recommendedActionsList = false;
if($recommendedActions)
{
	$ralis = array();
	foreach($recommendedActions as $y => $recommendedAction)
	{
		$ralis[$y] = $this->Html->tag('h4', $recommendedAction['name']).$this->Html->tag('p', $recommendedAction['action_recommended']);
		$ralis[$y]  = $this->Html->tag('li', $ralis[$y]);
	}
	
	$recommendedActionsList = $this->Html->tag('ul', implode("\n", $ralis), array('class' => 'recommended-actions'));
}
$tabs['recommended_actions'] = array(
	'id' => 'recommended_actions',
	'name' => __('Recommended Actions'),
	'content' => $this->element('Utilities.page_generic', array(
		'page_title' => __('Recommended Actions'),
		'page_subtitle' => __('Recommended actions for the Software/Vulnerabilities'),
		'page_content' => $recommendedActionsList,
	)),
);

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

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('Dashboard for: %s', $adAccount['OwnerContact']['name']),
	'page_subtitle' => __('Open Penetration Test findings'),
	'page_subtitle2' => __('Page loaded on %s', $this->Wrap->niceTime(date('Y-m-d H:i:s'))),
	'page_options_html' => $stats_html,
	'page_options_title' => __('View Results for:'),
	'page_options' => $page_options,
	'details_blocks' => $details_blocks,
	'details_options' => array('viewToggles' => false),
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));