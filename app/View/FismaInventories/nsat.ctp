<?php

$headers = array(
	'entity_name' => 'Entity Name',
	'asset_name' => 'Asset Name',
	'parent_component' => 'Parent Component',
	'parent_entity_name' => 'Parent Entity Name',
	'parent_asset' => 'Parent Asset',
	'type' => 'Type',
	'vendor' => 'Vendor',
	'product' => 'Product',
	'version' => 'Version',
	'model' => 'Model',
	'description' => 'Description',
	'netbios_name' => 'NETBIOS-Name',
	'hostname' => 'Hostname',
	'url' => 'URL',
	'mac_address' => 'MAC Address',
	'ip_address' => 'IP Address',
	'ip_address_range_start' => 'IP Address Range (Start)',
	'ip_address_range_end' => 'IP Address Range (End)',
	'serial_number' => 'Serial Number',
	'cpe' => 'CPE',
	'patch_level' => 'Patch Level',
	'database_details' => 'Database Details',
	'software_details' => 'Software Details',
	'supported_modules' => 'Supported Modules',
	'location' => 'Location',
	'ports' => 'Ports',
	'protocols' => 'Protocols'
);

$spacer = array();
foreach($headers as $i => $header)
{
	$spacer[$i] = '';
}

$content = '';
$data = array();
$data[] = $headers;
$data[] = $spacer;
$data[] = $spacer;

foreach($fisma_inventories as $i => $fisma_inventory)
{
	$ip_address_range_start = '';
	$ip_address_range_end = '';
	
	if(isset($fisma_inventory['SubnetMember']['Subnet']))
	{
		$ip_address_range_start = $fisma_inventory['SubnetMember']['Subnet']['ip_start'];
		$ip_address_range_end = $fisma_inventory['SubnetMember']['Subnet']['ip_end'];
	}
	
	$data[] = array(
		'entity_name' => $fisma_inventory['FismaSystem']['name'],
		'asset_name' => $fisma_inventory['FismaInventory']['name'],
		'parent_component' => '',
		'parent_entity_name' => '',
		'parent_asset' => '',
		'type' => $fisma_inventory['FismaType']['export_type'],
		'vendor' => '',
		'product' => '',
		'version' => '',
		'model' => '',
		'description' => '',
		'netbios_name' => '',
		'hostname' => $fisma_inventory['FismaInventory']['dns_name'],
		'url' => $this->Html->url(array('action' => 'view', $fisma_inventory['FismaInventory']['id']), array('full' => true)),
		'mac_address' => $fisma_inventory['FismaInventory']['mac_address'],
		'ip_address' => $fisma_inventory['FismaInventory']['ip_address'],
		'ip_address_range_start' => $ip_address_range_start,
		'ip_address_range_end' => $ip_address_range_end,
		'serial_number' => '',
		'cpe' => '',
		'patch_level' => '',
		'database_details' => '', // ?? example: MS SQL Server 2005 Compact Edition Runtime
		'software_details' => '', // ?? example: 'Windows 2007'
		'supported_modules' => $fisma_inventory['FismaInventory']['purpose'],
		'location' => '', // ?? example: Building 33
		'ports' => '',
		'protocols' => ''
	);
}

ob_start();
$csvBuffer = fopen("php://output", 'w');
foreach($data as $line) {
	$line = preg_replace('/\n+/', ' [newline] ', $line);
	fputcsv($csvBuffer, $line);
}
fclose($csvBuffer);

$content .= ob_get_clean();

echo $content;
