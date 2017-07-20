<?php 
// File: app/View/ReportsSystemType/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('Reports System Type') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('ReportsSystemType');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Reports System Type') ); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Reports System Type') )); ?>
	</div>
</div>