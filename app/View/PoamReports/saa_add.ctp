<?php 
?>
<div class="top">
	<h1><?php echo __('Add %s', __('POA&M Report')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('PoamReport', array('type' => 'file')); ?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('POA&M Report')); ?></legend>
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
						'label' => __('%s %s File', __('POA&M Report'), __('Excel')),
					));
					echo $this->Wrap->divClear();
					echo $this->Tag->autocomplete();
					echo $this->Form->input('notes', array(
						'label' => __('Notes/Details'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('POA&M Report'))); ?>
	</div>
</div>