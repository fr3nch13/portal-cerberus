<?php 
// File: app/View/FismaSystemFipsRating/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('%s - %s', __('FISMA System'), __('Fips Rating')) ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemFipsRating');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('%s - %s', __('FISMA System'), __('Fips Rating')) ); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name', array(
						'div' => array('class' => 'twothird'),
					));
					echo $this->Form->input('color_code_hex', array(
						'div' => array('class' => 'third'),
						'label' => __('Assigned Color'),
						'type' => 'color',
					));
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('%s - %s', __('FISMA System'), __('Fips Rating')) )); ?>
	</div>
</div>