<?php

$content = 'This is where the content goes.';

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => $this->Html->link(__('%s - Overview', __('Rules')), array('action' => 'dashboard')),
	'content' => $content,
));