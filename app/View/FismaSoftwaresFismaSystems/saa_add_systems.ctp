<?php 
// File: app/View/FismaSoftwaresFismaSystems/saa_add_systems.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s to this %s', __('FISMA Systems'), __('Whitelist Software')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSoftwareFismaSystem'); ?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Whitelist Software')); ?></legend>
		    	<?php
					echo $this->Form->input('FismaSystem', array(
						'multiple' => true,
						'label' => __('FISMA Systems'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Add %s', __('FISMA Systems'))); ?>
	</div>
</div>