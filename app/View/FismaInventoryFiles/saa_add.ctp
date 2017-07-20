<?php 
// File: app/View/FismaInventoryFiles/add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FISMA Inventory %s', __('File'))); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaInventoryFile', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA Inventory %s', __('File'))); ?></legend>
		    	<?php
					
					echo $this->Form->input('fisma_inventory_id', array('type' => 'hidden'));

					echo $this->Form->input('file', array('type' => 'file'));

					echo $this->Form->input('nicename', array(
						'label' => array(
							'text' => __('Friendly Name'),
						),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes'),
						),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('FISMA Inventory %s', __('File')))); ?>
	</div>
</div>