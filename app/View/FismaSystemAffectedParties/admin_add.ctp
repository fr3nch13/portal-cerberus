<?php 

?>
<div class="top">
	<h1><?php echo __('Add %s', __('%s - %s', __('FISMA System'), __('Affected Party Option')) ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemAffectedParty');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('%s - %s', __('FISMA System'), __('Affected Party Option')) ); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('%s - %s', __('FISMA System'), __('Affected Party Option')) )); ?>
	</div>
</div>