<?php 
$ad_account_id = (isset($ad_account_id) and $ad_account_id?$ad_account_id:AuthComponent::user('id'));
?>
	<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'main', 'action' => 'dashboard', $ad_account_id, 'lead' => true, 'plugin' => false), array('class' => 'top')); ?></li>
