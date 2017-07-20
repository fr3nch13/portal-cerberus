<?php ?>
<!-- File: app/View/Import/admin_rescan.ctp -->
<div class="top">
	<h1><?php echo __('%s/%s %s %s', __('Scan'), __('Rescan'), __('Import'), __('Config File')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Import');?>
		    <fieldset>
		        <legend><?php echo __('%s/%s %s %s', __('Scan'), __('Rescan'), __('Import'), __('Config File')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('update', array(
						'type' => 'checkbox',
						'value' => true,
						'label' => __('Update %s, %s, %s, etc?', __('Rules'), __('FOGs'), __('POGs')),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Scan %s %s', __('Import'), __('Config File'))); ?>
	</div>
</div>