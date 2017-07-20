<?php 
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('Physical Location')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create(); ?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Physical Location')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name', array(
						'div' => array('class' => 'forth'),
					));
					echo $this->Form->input('fullname', array(
						'div' => array('class' => 'threeforths'),
					));
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Physical Location'))); ?>
	</div>
</div>