<?php 
// File: app/View/FismaSoftwareGroup/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('FISMA Software Group')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSoftwareGroup');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('FISMA Software Group')); ?></legend>
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
		<?php echo $this->Form->end(__('Update %s', __('FISMA Software Group'))); ?>
	</div>
</div>