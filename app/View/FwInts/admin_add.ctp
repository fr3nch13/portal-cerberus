<?php ?>
<!-- File: app/View/FwInt/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add %s', __('Firewall Path')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FwInt');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Firewall Path')); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('firewall_id', array(
						'label' => array(
							'text' => __('Firewall'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('fw_interface_id', array(
						'label' => array(
							'text' => __('Interface'),
						),
						'div' => array('class' => 'half'),
						'options' => $fw_interfaces,
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Firewall Path'))); ?>
	</div>
</div>