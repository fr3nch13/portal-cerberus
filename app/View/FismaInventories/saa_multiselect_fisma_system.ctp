<?php 
// File: app/View/FismaInventories/saa_multiselect_fisma_system.ctp
?>
<div class="top">
	<h1><?php echo __('Assign all selected %s to %s %s', __('FISMA Inventory Items'), 'a', __('FISMA System')); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create('FismaInventory'); ?>
	    <fieldset>
	        <legend><?php echo __('Assign all selected %s to %s %s', __('FISMA Inventory Items'), 'a', __('FISMA System')); ?></legend>
	    	<?php
				echo $this->Form->input('FismaInventory.fisma_system_id', array(
					'empty' => __('[ None ]'),
					'label' => __('FISMA System'),
				));
	    	?>
	    </fieldset>
	<?php echo $this->Form->end(__('Save')); ?>
	</div>
<?php
if(isset($selected_items) and $selected_items)
{
	$details = array();
	foreach($selected_items as $selected_item)
	{
		$details[] = array('name' => __('Item: '), 'value' => $selected_item);
	}
	echo $this->element('Utilities.details', array(
			'title' => __('Selected %s. Count: %s', __('FISMA Inventory Items'), count($selected_items)),
			'details' => $details,
		));
}
?>
</div>
