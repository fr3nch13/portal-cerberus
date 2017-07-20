<?php ?>
<!-- File: app/View/Firewall/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add %s', __('Firewall')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Firewall');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Firewall')); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					echo $this->Form->input('hostname');
					echo $this->Form->input('domain_name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Firewall'))); ?>
	</div>
</div>