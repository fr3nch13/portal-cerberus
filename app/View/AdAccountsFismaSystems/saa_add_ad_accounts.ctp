<?php 
// File: app/View/FismaContactsFismaSystems/saa_add_contacts.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s to this %s', __('FISMA Contacts'), __('FISMA System')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('AdAccountFismaSystem');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA Contacts')); ?></legend>
		    	<?php
					echo $this->Form->input('AdAccount', array(
						'multiple' => true,
						'label' => __('FISMA Contacts'),
						'class' => 'multiselect',
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Add %s', __('FISMA Contacts'))); ?>
	</div>
</div>