<?php 
// File: app/View/FismaSystemFileStates/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FISMA System File State')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemFileState');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA System File State')); ?></legend>
		    	<?php
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('FISMA System File State'))); ?>
	</div>
</div>