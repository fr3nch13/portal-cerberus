<?php ?>
<!-- File: app/View/HostAlias/add.ctp -->
<div class="top">
	<h1><?php echo __('Add %s', __('Host Alias')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('HostAlias');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Host Alias')); ?></legend>
		    	<?php
					
					echo $this->Form->input('ip_address', array(
						'label' => array(
							'text' => __('IP Address'),
						),
					));
					
					echo $this->Form->input('alias', array(
						'label' => array(
							'text' => __('Alias'),
						),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Host Alias'))); ?>
	</div>
</div>