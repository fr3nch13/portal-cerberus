<?php 
// File: app/View/FismaContactType/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FISMA Contact'), __('Type')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaContactType');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA Contact'), __('Type')); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('FISMA Contact'), __('Type'))); ?>
	</div>
</div>