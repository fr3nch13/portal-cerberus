<?php 
// File: app/View/ReportsOrganizations/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('Organization') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create();?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Organization') ); ?></legend>
		    	<?php
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Organization') )); ?>
	</div>
</div>