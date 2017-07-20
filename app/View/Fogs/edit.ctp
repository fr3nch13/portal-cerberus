<?php ?>
<!-- File: app/View/Fog/admin_edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit %s', __('Firewall Object Group')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Fog');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Firewall Object Group')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					
					echo $this->Form->input('Fog.name', array(
						'label' => array(
							'text' => __('Group Name'),
						),
					));
					
					echo $this->Form->input('Fog.ip_addresses', array(
						'label' => array(
							'text' => __('IP Addresses'),
						),
						'between' => $this->Html->tag('p', __('Separate ip addresses with either a new line, or a comma.')),
					));
					
					echo $this->Form->input('FogLog.comments', array(
						'label' => __('Changelog Comments'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Firewall Object Group'))); ?>
	</div>
</div>