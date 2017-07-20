<?php 
// File: app/View/HighRiskReport/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('High Risk Report')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('HighRiskReport', array('type' => 'file')); ?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('High Risk Report')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name', array(
						'div' => array('class' => 'half'),
					));
					echo $this->Form->input('report_date', array(
						'div' => array('class' => 'forth'),
						'type' => 'date',
					));
					echo $this->Wrap->divClear();
					echo $this->Tag->autocomplete();
					echo $this->Form->input('notes', array(
						'label' => __('Notes/Details'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('High Risk Report'))); ?>
	</div>
</div>