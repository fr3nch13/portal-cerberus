<?php 
// File: app/View/UsResult/edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('US Result')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('UsResult'); ?>
		<?php echo $this->Form->input('id'); ?>
		    <fieldset>
		        <legend><?php echo __('Host Information'); ?></legend>
		    	<h3><?php echo __('Host Information'); ?></h3>
		    	<?php
				echo $this->Form->input('reports_organization_id', array(
					'label' => __('Organization'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('fisma_system_id', array(
					'label' => __('FISMA System'),
					'div' => array('class' => 'forth'),
					'empty' => __('* Dynamic *'),
				));
				echo $this->Form->input('host_description', array(
					'label' => __('Host Description'),
					'div' => array('class' => 'half'),
				));
		    	?>
		    </fieldset>
		    <fieldset>
		    	<h3><?php echo __('US Result Details'); ?></h3>
		        <legend><?php echo __('US Result Details'); ?></legend>
		    	<?php
				echo $this->Form->input('description', array(
					'label' => __('Detailed Description'),
				));
				echo $this->Form->input('comments', array(
					'label' => __('Comments'),
					'div' => array('class' => 'half'),
					'after' => $this->Html->tag('p', __("(Please explain why it's False positive, Acceptable Risk or Action(s) taken) ")),
				));
				echo $this->Form->input('notes', array(
					'label' => __('Notes'),
					'div' => array('class' => 'half'),
				));
				echo $this->Tag->autocomplete();
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('US Result'))); ?>
	</div>
</div>