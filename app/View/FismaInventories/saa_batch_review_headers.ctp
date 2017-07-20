<?php
// File: app/View/FismaInventory/saa_batch_review_headers.ctp
?>
<div class="top">
	<h1><?php echo __('Create Many %s', __('FISMA Inventory Items')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaInventory', array('id' => 'AddFismaInventoryForm'));?>
		    <fieldset>
		        <legend class="section"><?php echo __('Map your CSV Fields to the %s Fields', __('FISMA Inventory')); ?></legend>
		        <p class="info"><?php echo __('Match up your CSV Field to the %s Field.', __('FISMA Inventory')); ?></p>
		        <?php
		        
$th = array(
	'csv_map' => array('content' => __('%s Fields', __('FISMA Inventory'))),
	'header' => array('content' => __('Your CSV Fields')),
);

$td = array();

$i = 0;
foreach($csv_field_map as $key => $value)
{
	$input = $this->Form->input($key, array(
		'label' => false,
		'options' => $headers,
		'multiple' => false,
		'empty' => __('None'),
	));
	
	$label = $this->Form->label($key, $value);
	
	$td[$i] = array(
		$label,
		$input
	);
	$i++;
}

echo $this->element('Utilities.table', array(
	'th' => $th,
	'td' => $td,
	'use_search' => false,
	'use_pagination' => false,
)); 
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Review the CSV Items')); ?>
	</div>
</div>
