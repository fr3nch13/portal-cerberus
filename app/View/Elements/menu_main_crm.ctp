<?php 
$ad_account_id = (isset($ad_account_id) and $ad_account_id?$ad_account_id:AuthComponent::user('id'));
?>
	<li><?php echo $this->Html->link(__('CRM Dashboard'), array('controller' => 'main', 'action' => 'dashboard', $ad_account_id, 'crm' => true, 'plugin' => false), array('class' => 'top')); ?></li>
	<li><?php echo $this->Html->link(__('%s Owners Dashboards', __('FISMA Systems')), '#', array('class' => 'top')); ?>
		<?php echo $this->element('Utilities.menu_items', array(
			'request_url' => array('controller' => 'fisma_systems', 'action' => 'menu_owners', $ad_account_id, 'admin' => false, 'saa' => false, 'owner' => false, 'crm' => false, 'plugin' => false),
		));?>
	</li>
