<?php ?>
<!-- File: app/View/Pog/edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit %s', __('Port Object Group')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Pog');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Port Object Group')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					
					echo $this->Form->input('Pog.name', array(
						'label' => array(
							'text' => __('Group Name'),
						),
					));
					
					echo $this->Form->input('Pog.ports', array(
						'label' => array(
							'text' => __('Port Numbers'),
						),
						'between' => $this->Html->tag('p', __('Separate ports with a new line, or a comma (can include a range like 50 60 - separated by a space).')),
					));
					
					echo $this->Form->input('PogLog.comments', array(
						'label' => __('Changelog Comments'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Port Object Group'))); ?>
	</div>
</div>