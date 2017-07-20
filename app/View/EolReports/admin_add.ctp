<?php 
// File: app/View/EolReport/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('EOL Report')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('EolReport', array('type' => 'file')); ?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('EOL Report')); ?></legend>
		    	<?php
					echo $this->Form->input('name', array(
						'div' => array('class' => 'half'),
					));
					echo $this->Form->input('report_date', array(
						'div' => array('class' => 'forth'),
						'type' => 'date',
					));
					echo $this->Form->input('file', array(
						'div' => array('class' => 'forth'),
						'type' => 'file',
						'label' => __('%s %s File', __('EOL Report'), __('PDF')),
					));
					echo $this->Wrap->divClear();
					echo $this->Tag->autocomplete();
					echo $this->Form->input('notes', array(
						'label' => __('Notes/Details'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('EOL Report'))); ?>
	</div>
</div>