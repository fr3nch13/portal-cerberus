<?php 
// File: app/View/FismaSystemPoams/saa_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('%s %s', __('FISMA System'), __('POAM'))); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemPoam');?>
			<fieldset>
				<legend><?php echo __('Add %s', __('%s %s', __('FISMA System'), __('POAM'))); ?></legend>
				<?php
				echo $this->Form->input('fisma_system_id', array('type' => 'hidden'));
				
				echo $this->Form->input('weakness_id', array(
					'type' => 'text',
					'label' => array(
						'text' => __('Weakness ID'),
					),
					'div' => array('class' => 'third'),
				));
				
				echo $this->Form->input('scheduled_completion', array(
					'type' => 'date',
					'label' => array(
						'text' => __('Scheduled Completion'),
					),
					'div' => array('class' => 'third'),
				));
				
				echo $this->Form->input('fisma_system_poam_completion_status_id', array(
					'label' => array(
						'text' => __('Completion Status'),
					),
					'div' => array('class' => 'third'),
				));
				
				echo $this->Wrap->divClear();
				
				echo $this->Form->input('controls', array(
					'type' => 'text',
					'label' => array(
						'text' => __('Controls'),
					),
				));
				
				echo $this->Wrap->divClear();
				
				echo $this->Form->input('weakness', array(
					'type' => 'textarea',
					'label' => array(
						'text' => __('Weakness'),
					),
					'div' => array('class' => 'half'),
				));
				
				echo $this->Form->input('solution', array(
					'type' => 'textarea',
					'label' => array(
						'text' => __('Solution'),
					),
					'div' => array('class' => 'half'),
				));
				?>
			</fieldset>
		<?php echo $this->Form->end(__('Save %s', __('%s %s', __('FISMA System'), __('POAM')))); ?>
	</div>
</div>