<?php 
// File: app/View/EolReportFiles/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('%s %s', __('EOL Report'), __('File'))); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('EolReportFile', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('%s %s', __('EOL Report'), __('File'))); ?></legend>
		    	<?php
					
					echo $this->Form->input('eol_report_id', array('type' => 'hidden'));

					echo $this->Form->input('nicename', array(
						'label' => __('Friendly Name'),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Wrap->divClear();

					echo $this->Form->input('file', array('type' => 'file'));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes'),
						),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('%s %s', __('EOL Report'), __('File')))); ?>
	</div>
</div>