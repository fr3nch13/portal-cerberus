<?php 
// File: app/View/FismaInventories/saa_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FISMA Inventory')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaInventory');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA Inventory')); ?></legend>
		    	<?php

					echo $this->Form->input('name', array(
						'label' => array(
							'text' => __('Friendly Name'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('fisma_system_id', array(
						'label' => array(
							'text' => __('FISMA System'),
						),
						'div' => array('class' => 'half'),
						'empty' => __('[Please Select a FISMA System]'),
						'searchable' => true,
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('mac_address', array(
						'label' => array(
							'text' => __('MAC Address'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('asset_tag', array(
						'label' => array(
							'text' => __('Asset Tag'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('location', array(
						'label' => array(
							'text' => __('Location'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('ip_address', array(
						'label' => array(
							'text' => __('IP Address'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('nat_ip_address', array(
						'label' => array(
							'text' => __('NAT IP Address'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('dns_name', array(
						'label' => array(
							'text' => __('DNS Name'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('fisma_type_id', array(
						'label' => array(
							'text' => __('Type'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('fisma_status_id', array(
						'label' => array(
							'text' => __('Status'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('fisma_source_id', array(
						'label' => array(
							'text' => __('Source'),
						),
						'div' => array('class' => 'third'),
					));
					
/*
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('contact_name', array(
						'label' => array(
							'text' => __('Contact Name'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('contact_email', array(
						'label' => array(
							'text' => __('Contact Email'),
						),
						'div' => array('class' => 'half'),
					));
*/
					
					echo $this->Wrap->divClear();

					echo $this->Form->input('purpose', array(
						'label' => array(
							'text' => __('Purpose'),
						),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes'),
						),
					));
					
					echo $this->Tag->autocomplete();
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('FISMA Inventory'))); ?>
	</div>
</div>
<script type="text/javascript">

$(document).ready(function()
{
	$('#FismaInventoryMacAddress').blur(function()
	{
		var myMac = $(this).val();
		myMac=myMac.toUpperCase();
		myMac=myMac.replace(/ /g,".");
		myMac=myMac.replace(/[^a-zA-Z0-9]+/g,"");
		$(this).val( myMac );
	});
});//ready 

</script>