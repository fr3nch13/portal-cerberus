<?php ?>
<!-- File: app/View/FwInterface/admin_edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit %s', __('Interface')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FwInterface');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Interface')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('slug');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Interface'))); ?>
	</div>
</div>