<?php ?>
<!-- File: app/View/FismaSystem/edit_notes.ctp -->
<div class="top">
	<h1><?php echo __('Edit %s - %s', __('FISMA System'), Inflector::humanize($field) ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystem');?>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input($field, array(
						'label' => array(
							'text' => Inflector::humanize($field),
						),
						'type' => 'textarea',
					));
		    	?>
			</fieldset>
			
		<?php echo $this->Form->end(__('Update %s - %s', __('FISMA System'), Inflector::humanize($field) )); ?>
	</div>
</div>