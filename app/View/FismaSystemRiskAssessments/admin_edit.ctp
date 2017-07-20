<?php 
// File: app/View/FismaSystemRiskAssessment/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemRiskAssessment');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) ); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('%s - %s', __('FISMA System'), __('FO Risk Assessment')) )); ?>
	</div>
</div>