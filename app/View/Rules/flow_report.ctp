<?php 
// File: app/View/Rules/flow_report.ctp
?>
<div class="top">
	<h1><?php echo __('Update %s', __('Flow Report')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Rule', array('type' => 'file')); ?>
		    <fieldset>
		        <legend><?php echo __('Update %s', __('Flow Report')); ?></legend>
		    	<?php	
					echo $this->Form->input('file', array(
						'div' => array('class' => 'half'),
						'type' => 'file',
						'label' => __('%s %s File', __('Flow Report'), __('Excel')),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Flow Report'))); ?>
	</div>
</div>