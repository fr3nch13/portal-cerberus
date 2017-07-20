<?php 

$stats = array();
foreach($fisma_inventories_stats['FismaSystem'] as $fisma_systen_id => $fisma_system_stat)
{
	$stats[] = array(
		'id' => 'fisma_system_stats_'. $fisma_systen_id,
		'name' => __('%s (%s%%)', $fisma_system_stat['name'], $fisma_system_stat['percent']),
		'value' => $fisma_system_stat['value'],  
	);
}

echo $this->element('Utilities.stats', array(
	'title' => __('Stats by %s', __('FISMA Systems')),
	'stats' => $stats,
)); 

$stats = array();
foreach($fisma_inventories_stats['FismaType'] as $fisma_type_id => $fisma_type_stat)
{
	$stats[] = array(
		'id' => 'fisma_type_stats_'. $fisma_type_id,
		'name' => __('%s (%s%%)', $fisma_type_stat['name'], $fisma_type_stat['percent']),
		'value' => $fisma_type_stat['value'],  
	);
}

echo $this->element('Utilities.stats', array(
	'title' => __('Stats by %s', __('FISMA Type')),
	'stats' => $stats,
)); 
