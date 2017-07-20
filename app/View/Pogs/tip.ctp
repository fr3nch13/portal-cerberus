<?php

$ports = __('None');
if(trim($pog['Pog']['ports']))
{
	$ports = $this->Local->strToArray($pog['Pog']['ports']);
	$ports = implode('<br />', $ports);
}

echo __('<b>%s</b> %s', __('Ports'), '<br />');
echo $ports;
echo '<br /><br />';
echo __('<b>%s</b> %s', __('Child Groups'), '<br />');
echo ($pog_children?implode('<br />', $pog_children):__('None'));