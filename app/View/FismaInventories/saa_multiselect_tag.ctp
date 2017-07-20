<?php 
// File: app/View/FismaInventories/saa_multiselect_fisma_tag.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s to all selected %', __('Tags'), __('FISMA Inventory Items')); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create('FismaInventory'); ?>
	    <fieldset>
	        <legend><?php echo __('Add %s to all selected %', __('Tags'), __('FISMA Inventory Items')); ?></legend>
	    	<?php
					echo $this->Tag->autocomplete(false, array('update_tags' => false));
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
