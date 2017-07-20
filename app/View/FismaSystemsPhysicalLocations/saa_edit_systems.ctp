<?php 
?>
<div class="top">
	<h1><?php echo __('Select %s for the %s: %s - %s', __('FISMA Systems'), __('Physical Location'), $physicalLocation['PhysicalLocation']['name'], $physicalLocation['PhysicalLocation']['fullname']); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create(); ?>
		<fieldset>
<?php
$th = array();
$th['FismaSystem.id'] = array('content' => __('ID'));
$th['FismaSystem.name'] = array('content' => __('FISMA System'));
$th['FismaSystem.fullname'] = array('content' => __('Full Name'));

$td = array();
foreach ($fismaSystems as $i => $fismaSystem)
{
	$td[$i] = array();
	$td[$i]['FismaSystem.id'] = $this->Form->input('FismaSystem.'.$fismaSystem['FismaSystem']['id'], array(
		'div' => false,
		'label' => false,
		'type' => 'checkbox',
		'checked' => (isset($fismaSystem_ids[$fismaSystem['FismaSystem']['id']])?true:false),
		'value' => $fismaSystem['FismaSystem']['id'],
		'class' => 'multiselect_item',
	));
	$td[$i]['FismaSystem.name'] = $fismaSystem['FismaSystem']['name'];
	$td[$i]['FismaSystem.fullname'] = $fismaSystem['FismaSystem']['fullname'];
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
		<?php echo $this->Form->end(__('Update %s', __('FISMA Systems'))); ?>
	</div>
</div>