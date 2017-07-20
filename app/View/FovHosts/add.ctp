<?php 
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FOV Hosts')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create(); ?>
		    <fieldset>
		    	<h3><?php echo __('Host Information'); ?></h3>
				<?php
				echo $this->Form->input('hosts', array(
					'label' => __('Hosts'),
					'type' => 'textarea',
					'description' => __('CSV Format: host_description, hostname, ip address, asset tag, mac address, netbios'),
				));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('FOV Hosts'))); ?>
	</div>
</div>