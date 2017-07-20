<?php 
// File: app/View/FismaSystemImpact/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('%s - %s', __('FISMA System'), __('Impact')) ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemImpact');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('%s - %s', __('FISMA System'), __('Impact')) ); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('rating', array('type' => 'select', 'options' => $this->Common->range(1, 10)));
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('%s - %s', __('FISMA System'), __('Impact')) )); ?>
	</div>
</div>