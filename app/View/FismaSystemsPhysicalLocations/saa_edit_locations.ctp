<?php 
?>
<div class="top">
	<h1><?php echo __('Select %s for the %s: %s', __('Physical Locations'), __('FISMA System'), $fismaSystem['FismaSystem']['name']); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create(); ?>
		<fieldset>
<?php
$th = array();
$th['PhysicalLocation.id'] = array('content' => __('ID'));
$th['PhysicalLocation.name'] = array('content' => __('Location Name'));
$th['PhysicalLocation.fullname'] = array('content' => __('Full Name'));

$td = array();
foreach ($physicalLocations as $i => $physicalLocation)
{
	$td[$i] = array();
	$td[$i]['PhysicalLocation.id'] = $this->Form->input('PhysicalLocation.'.$physicalLocation['PhysicalLocation']['id'], array(
		'div' => false,
		'label' => false,
		'type' => 'checkbox',
		'checked' => (isset($physicalLocation_ids[$physicalLocation['PhysicalLocation']['id']])?true:false),
		'value' => $physicalLocation['PhysicalLocation']['id'],
		'class' => 'multiselect_item',
	));
	$td[$i]['PhysicalLocation.name'] = $physicalLocation['PhysicalLocation']['name'];
	$td[$i]['PhysicalLocation.fullname'] = $physicalLocation['PhysicalLocation']['fullname'];
}

echo $this->element('Utilities.table', array(
	'th' => $th,
	'td' => $td,
	'use_filter' => false,
	'use_search' => false,
	'use_pagination' => false,
	'show_refresh_table' => false,
	'use_row_highlighting' => false,
	'use_jsordering' => false,
)); 
?>
		</fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Physical Locations'))); ?>
	</div>
</div>