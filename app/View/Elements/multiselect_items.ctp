<?php 
// File: app/View/Elements/multiselect+-items.ctp
?>
<div class="top">
	<h1><?php echo __('Assign all selected items to one %s', $multiselectOption['nameSingle']); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create(); ?>
	    <fieldset>
	        <legend><?php echo __('Assign all selected items to one %s', $multiselectOption['nameSingle']); ?></legend>
	    	<?php
				echo $this->Form->input($multiselectOption['foreignKey'], array(
					'empty' => __('[ None ]'),
					'label' => __('Select one %s', $multiselectOption['nameSingle']),
					'options' => $options,
					'searchable' => true,
				));
				echo $this->Form->input('notes', array(
					'label' => __('Any notes you would like to include with this change.'),
					'type' => 'textarea',
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
			'title' => __('Selected Items. Count: %s', count($selected_items)),
			'details' => $details,
		));
}
?>
</div>
