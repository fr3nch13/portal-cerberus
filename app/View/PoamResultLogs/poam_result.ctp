<?php 

$page_options = array(
);

// content
$th = array(
	'PoamResultLog.tickets' => array('content' => __('Tickets'), 'options' => array('sort' => 'PoamResultLog.tickets')),
	'PoamResultLog.poam_status_id' => array('content' => __('Status'), 'options' => array('sort' => 'PoamResultLog.poam_status_id')),
	'PoamResultLog.modified_user_id' => array('content' => __('Change Done By'), 'options' => array('sort' => 'PoamResultLog.modified_user_id')),
	'PoamResultLog.created' => array('content' => __('Change Done On'), 'options' => array('sort' => 'PoamResultLog.created')),
); 

$td = array();
foreach ($poamResultLogs as $i => $poamResult_log)
{	
	$action_date = $this->Wrap->niceTime($poamResult_log['PoamResultLog']['action_date']);	
	
	$td[$i] = array(
		array($poamResult_log['PoamResultLog']['tickets'], array('class' => 'nowrap')),
		array((isset($poamResult_log['PoamStatus']['name'])?$poamResult_log['PoamStatus']['name']:'&nbsp;'), array('class' => 'nowrap')),
		$this->Wrap->niceTime($poamResult_log['PoamResultLog']['created']),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('POA&M Results'),
	'th' => $th,
	'td' => $td,
));