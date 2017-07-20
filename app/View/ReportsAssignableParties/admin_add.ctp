<?php 
// File: app/View/ReportsAssignableParty/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('Reports Assignable Party') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('ReportsAssignableParty');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Reports Assignable Party') ); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Reports Assignable Party') )); ?>
	</div>
</div>