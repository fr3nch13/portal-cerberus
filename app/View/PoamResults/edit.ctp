<?php 
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('POA&M Result')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('PoamResult'); ?>
		<?php echo $this->Form->input('id'); ?>
		    <fieldset>
		    	<h3><?php echo __('POA&M Result Details'); ?></h3>
		        <legend><?php echo __('POA&M Result Details'); ?></legend>
		    	<?php
				echo $this->Form->input('fisma_system_id', array(
					'label' => __('FISMA System'),
				));
				echo $this->Form->input('description', array(
					'label' => __('Detailed Description'),
				));
				echo $this->Form->input('comments', array(
					'label' => __('Comments'),
					'div' => array('class' => 'half'),
				));
				echo $this->Form->input('notes', array(
					'label' => __('Notes'),
					'div' => array('class' => 'half'),
				));
				echo $this->Tag->autocomplete();
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('POA&M Result'))); ?>
	</div>
</div>