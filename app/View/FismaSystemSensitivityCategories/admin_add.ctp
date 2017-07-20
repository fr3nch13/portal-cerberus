<?php 
// File: app/View/FismaSystemSensitivityCategory/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemSensitivityCategory');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) ); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('rating', array('type' => 'select', 'options' => $this->Common->range(1, 10)));
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('%s - %s', __('FISMA System'), __('Sensitivity Category')) )); ?>
	</div>
</div>