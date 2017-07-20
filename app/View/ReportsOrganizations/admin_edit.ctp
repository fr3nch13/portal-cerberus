<?php 
// File: app/View/ReportsOrganizations/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('Organization') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create();?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Organization') ); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Organization') )); ?>
	</div>
</div>