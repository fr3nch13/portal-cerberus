<?php ?>
<!-- File: app/View/Protocol/admin_edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit %s', __('Protocol')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Protocol');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Protocol')); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('slug');
					
					echo $this->Form->input('protocols', array(
						'label' => array(
							'text' => __('Defined Protocols'),
						),
						'between' => $this->Html->tag('p', __('Separate protocols with a new line.')).
									 $this->Html->tag('p', __('Note: This will make this protocol show up as an object-group on exports.')),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Protocol'))); ?>
	</div>
</div>