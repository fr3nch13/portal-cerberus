<?php
// File: app/View/Equipment/batch_review_headers.ctp
?>
<div class="top">
	<h1><?php echo __('Create Many New NAC Exceptions/Tracking'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Equipment', array('id' => 'AddEquipmentForm'));?>
		    <fieldset>
		        <legend class="section"><?php echo __('Map the Naccess Fields to the CSV Fields'); ?></legend>
		        <p class="info"><?php echo __('The following are the NACCESS input fields you can map to: List the 8 items that are on the left column from this page (NACCESS fields):'); ?></p>
		        <?php
		        
$th = array(
	'csv_map' => array('content' => __('Naccess Fields')),
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
