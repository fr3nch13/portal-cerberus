<?php 
// File: app/View/ReportsVerification/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('Reports Verification') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('ReportsVerification');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Reports Verification') ); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Reports Verification') )); ?>
	</div>
</div>