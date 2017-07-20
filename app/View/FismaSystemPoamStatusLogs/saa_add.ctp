<?php 
// File: app/View/FismaSystemPoamStatusLogs/saa_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log'))); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemPoamStatusLog');?>
			<fieldset>
				<legend><?php echo __('Add %s', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log'))); ?></legend>
				<?php
				echo $this->Form->input('fisma_system_poam_id', array('type' => 'hidden'));
				
				echo $this->Form->input('status', array(
					'type' => 'textarea',
					'label' => array(
						'text' => __('Status'),
					),
				));
				?>
			</fieldset>
		<?php echo $this->Form->end(__('Save %s', __('%s %s %s', __('FISMA System'), __('POAM'), __('Status Log')))); ?>
	</div>
</div>