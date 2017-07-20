<?php 
/**
 * File: app/View/Users/admin_admin.ctp
 *
 * The dashboard for the admin side of things
 */

$content = array(
	$this->element('Utilities.block', array(
		'title' => __('Users'),
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'users', 'action' => 'index', 'admin' => true)),
			$this->Html->link(__('Add'), array('controller' => 'users', 'action' => 'add', 'admin' => true)),
		),
	)),
);

echo $this->element('Utilities.page_generic', array(
	'page_title' => __('Admin Dashboard'),
	'page_content' => implode("\n", $content),
));

?>
