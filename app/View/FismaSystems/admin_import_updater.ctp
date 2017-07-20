<?php 
// File: app/View/FismaSystem/admin_import_updater.ctp
?>
<div class="top">
	<h1><?php echo __('Import/Update %s', __('FISMA Systems')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystem', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Import/Update %s', __('FISMA Systems')); ?></legend>
		    	<?php
				echo $this->Form->input('file', array(
					'div' => array('class' => 'forth'),
					'type' => 'file',
					'label' => __('%s %s File', __('FISMA Systems'), __('Excel')),
				));

		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Import/Update %s', __('FISMA Systems'))); ?>
	</div>
</div>