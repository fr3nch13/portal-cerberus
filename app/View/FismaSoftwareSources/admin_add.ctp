<?php 
// File: app/View/FismaSoftwareSource/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FISMA Software Source')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSoftwareSource');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA Software Source')); ?></legend>
		    	<?php
					echo $this->Form->input('name', array(
						'label' => array(
							'text' => __('Name'),
						),
					));
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('FISMA Software Source'))); ?>
	</div>
</div>