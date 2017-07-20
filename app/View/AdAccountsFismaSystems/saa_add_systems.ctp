<?php 
// File: app/View/FismaContactsFismaSystems/saa_add_systems.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s to this %s', __('FISMA Systems'), __('FISMA Contact')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('AdAccountFismaSystem'); ?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA Systems')); ?></legend>
		    	<?php
					echo $this->Form->input('FismaSystem', array(
						'multiple' => true,
						'label' => __('FISMA Systems'),
						'class' => 'multiselect',
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Add %s', __('FISMA Systems'))); ?>
	</div>
</div>