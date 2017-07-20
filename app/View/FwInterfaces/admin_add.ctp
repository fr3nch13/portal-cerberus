<?php ?>
<!-- File: app/View/FwInterface/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add %s', __('Interface')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FwInterface');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Interface')); ?></legend>
		    	<?php
					echo $this->Form->input('FwInterface.name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Interface'))); ?>
	</div>
</div>