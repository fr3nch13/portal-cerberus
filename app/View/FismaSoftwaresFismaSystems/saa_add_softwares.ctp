<?php 
// File: app/View/FismaSoftwaresFismaSystems/saa_add_softwares.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s to this %s', __('Whitelisted Software'), __('FISMA System')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSoftwareFismaSystem');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Whitelisted Software')); ?></legend>
		    	<?php
					echo $this->Form->input('FismaSoftware', array(
						'multiple' => true,
						'label' => __('Whitelisted Software'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Add %s', __('Whitelisted Software'))); ?>
	</div>
</div>