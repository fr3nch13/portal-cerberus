<?php 
// File: app/View/FismaSoftwareSource/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('FISMA Software Source')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSoftwareSource');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('FISMA Software Source')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					
					echo $this->Form->input('name', array(
						'label' => array(
							'text' => __('Name'),
						),
					));
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('FISMA Software Source'))); ?>
	</div>
</div>