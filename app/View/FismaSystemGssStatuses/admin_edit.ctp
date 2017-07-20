<?php 
// File: app/View/FismaSystemGssStatus/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('%s - %s', __('FISMA System'), __('GSS Status')) ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemGssStatus');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('%s - %s', __('FISMA System'), __('GSS Status')) ); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('%s - %s', __('FISMA System'), __('GSS Status')) )); ?>
	</div>
</div>