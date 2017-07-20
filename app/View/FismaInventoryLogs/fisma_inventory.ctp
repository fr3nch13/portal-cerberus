<?php 
// File: app/View/FismaInventoryLogs/fisma_inventory_log.ctp

// content
$th = array(
	//'FismaInventoryLog.id' => array('content' => __('ID'), 'options' => array('sort' => 'FismaInventoryLog.id')),
	'FismaInventoryLog.created' => array('content' => __('Changed'), 'options' => array('sort' => 'FismaInventoryLog.created')),
	'field' => array('content' => __('Field Name')),
	'old' => array('content' => __('Old Setting')),
	'new' => array('content' => __('New Setting')),
);

$td = array();
$x=0;
foreach ($fisma_inventory_logs as $i => $fisma_inventory_log)
{
	$td[$x] = array();
	//$td[$x]['FismaInventoryLog.id'] = $fisma_inventory_log['FismaInventoryLog']['id'];
	$td[$x]['FismaInventoryLog.created'] = $this->Wrap->niceTime($fisma_inventory_log['FismaInventoryLog']['created']);
	foreach($fisma_inventory_log['changes'] as $field => $change)
	{
		$x++;
		$td[$x] = array();
		//$td[$x]['FismaInventoryLog.id'] = '';
		$td[$x]['FismaInventoryLog.created'] = '';
		
		if($change['old_object'])
		{
			$field = str_replace('_id', '', $field);
		}
		$td[$x]['field'] = Inflector::humanize($field);
		
		$td[$x]['old'] = $change['old_value'];
		if(trim($change['old_object_name'])) $td[$x]['old'] = $change['old_object_name'];
		$td[$x]['new'] = $change['new_value'];
		if(trim($change['new_object_name'])) $td[$x]['new'] = $change['new_object_name'];
		
	}
	$x++;
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('FISMA Inventory Logs'),
//	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>