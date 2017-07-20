<?php

$ip_addresses = __('None');
if(trim($fog['Fog']['ip_addresses']))
{
	$ip_addresses = $this->Local->strToArray($fog['Fog']['ip_addresses']);
	$ip_addresses = implode('<br />', $ip_addresses);
}

echo __('<b>%s</b> %s', __('IP Addresses'), '<br />');
echo $ip_addresses;
echo '<br /><br />';
echo __('<b>%s</b> %s', __('Child Groups'), '<br />');
echo ($fog_children?implode('<br />', $fog_children):__('None'));