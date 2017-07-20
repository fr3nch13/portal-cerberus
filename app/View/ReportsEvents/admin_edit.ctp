<?php 
// File: app/View/ReportsEvents/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('Reports Event') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create();?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Reports Event') ); ?></legend>
		    	<?php
				echo $this->Form->input('id');
				echo $this->Form->input('name', array(
					'div' => array('class' => 'half'),
				));
				echo $this->Form->input('shortname', array(
					'div' => array('class' => 'forth'),
					'label' => __('Short Name'),
				));
				echo $this->Form->input('event_date', array(
					'div' => array('class' => 'forth'),
					'label' => __('Event Date'),
				));
				echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Reports Event') )); ?>
	</div>
</div>