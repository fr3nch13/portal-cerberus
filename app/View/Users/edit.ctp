<?php 

$page_options = array();


$this->start('edit_details');
?>
	<?php echo $this->Form->create(); ?>
	<fieldset>
		<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('paginate_items', array(
			'between' => $this->Html->para('form_info', __('How many items should show up in a list by default.')),
			'options' => array(
				'10' => __('10'),
				'25' => __('25'),
				'50' => __('50'),
				'100' => __('100'),
				'150' => __('150'),
				'200' => __('200'),
				'500' => __('500 - May Load Slowly'),
				'1000' => __('1000 - May Load Slowly'),
			),
			'selected' => '25',
		));
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Save Details'));?>
<?php
$this->end(); // $this->start('edit_details'); 


$tabs = array();
$tabs['details'] = array(
	'id' => 'details',
	'name' => __('Edit Details'),
	'content' => $this->fetch('edit_details'),
);
$tabs['apikey'] = array(
	'id' => 'apikey',
	'name' => __('API Key'),
	'ajax_url' => array('action' => 'apikey'),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('Account Options'),
	'page_options' => $page_options,
	'tabs' => $tabs,
));