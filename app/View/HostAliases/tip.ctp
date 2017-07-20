<?php

echo __('<b>%s</b> %s', __('Aliases'), '<br />');
echo ($aliases?implode('<br />', $aliases):__('None'));