<?php
// File: app/View/FismaInventory/saa_batch_review_data.ctp
?>
<div class="top">
	<h1><?php echo __('Add Many %s', __('FISMA Inventory Items')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaInventory', array('id' => 'AddFismaInventoryForm'));?>
		    <fieldset>
		        <legend class="section"><?php echo __('Review the CSV Items to be added to the %s', __('FISMA Inventory')); ?></legend>
		        <?php
$th = array(
	'content' => array('content' => __(' ')),
);


$td = array();
$i = 0;

// the apply to all options

	$line = $this->Html->tag('h2', __('Apply to all.'));
	$line .= __('To apply these settings to every item below, simply select the item from the lists.');
	
	$mac_id = 'MacAddress_'. $i;
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_system_id', array(
		'label' => array(
			'text' => __('FISMA System'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_fisma_system_id ',
		'id' => 'FismaInventory_fisma_system_id',
		'selected' => (isset($data['FismaInventory']['fisma_system_id'])?$data['FismaInventory']['fisma_system_id']:''),
		'empty' => __('[Please Select a FISMA System]'),
		'options' => $fismaSystems,
	));
	$this->Js->buffer($this->Js->get('#FismaInventory_fisma_system_id')->event('change', '
	event.preventDefault();
	if (confirm("Are you sure? This will change the setting for every record below!")){
		$(".FismaInventory_fisma_system_id").each( function() { $(this).val($("#FismaInventory_fisma_system_id").val()); })
	}', array('stop' => false)));
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_type_id', array(
		'label' => array(
			'text' => __('Type'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_fisma_type_id',
		'id' => 'FismaInventory_fisma_type_id',
		'selected' => (isset($data['FismaInventory']['fisma_type_id'])?$data['FismaInventory']['fisma_type_id']:''),
		'empty' => __('[Please Select a Type]'),
		'options' => $fismaTypes,
	));
	$this->Js->buffer($this->Js->get('#FismaInventory_fisma_type_id')->event('change', '
	event.preventDefault();
	if (confirm("Are you sure? This will change the setting for every record below!")){
		$(".FismaInventory_fisma_type_id").each( function() { $(this).val($("#FismaInventory_fisma_type_id").val()); })
	}', array('stop' => false)));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_status_id', array(
		'label' => array(
			'text' => __('Status'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_fisma_status_id',
		'id' => 'FismaInventory_fisma_status_id',
		'selected' => (isset($data['FismaInventory']['fisma_status_id'])?$data['FismaInventory']['fisma_status_id']:''),
		'empty' => __('[Please Select a Status]'),
		'options' => $fismaStatuses,
	));
	$this->Js->buffer($this->Js->get('#FismaInventory_fisma_status_id')->event('change', '
	event.preventDefault();
	if (confirm("Are you sure? This will change the setting for every record below!")){
		$(".FismaInventory_fisma_status_id").each( function() { $(this).val($("#FismaInventory_fisma_status_id").val()); })
	}', array('stop' => false)));
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_source_id', array(
		'label' => array(
			'text' => __('Source'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_fisma_source_id',
		'id' => 'FismaInventory_fisma_source_id',
		'selected' => (isset($data['FismaInventory']['fisma_source_id'])?$data['FismaInventory']['fisma_source_id']:''),
		'empty' => __('[Please Select a Source]'),
		'options' => $fismaSources,
	));
	$this->Js->buffer($this->Js->get('#FismaInventory_fisma_source_id')->event('change', '
	event.preventDefault();
	if (confirm("Are you sure? This will change the setting for every record below!")){
		$(".FismaInventory_fisma_source_id").each( function() { $(this).val($("#FismaInventory_fisma_source_id").val()); })
	}', array('stop' => false)));
	
	$td[$i] = array(
		array(
			$line,
			array(
				'id' => 'td'. $mac_id,
				'class' => 'record',
			)
		)
	);
	
foreach($this->request->data as $data)
{
	if(!isset($data['FismaInventory'])) continue;
	$i++;
	
	$line = '';
	
	$mac_id = 'MacAddress_'. $i;
	
	$line .= $this->Form->button(__('Remove this CSV Item'), array(
		'type' => 'button', 
		'class' => 'remove_record'
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.FismaInventory.name', array(
		'label' => array(
			'text' => __('Friendly Name'),
		),
		'div' => array('class' => 'half'),
		'class' => 'FismaInventory_name',
		'value' => (isset($data['FismaInventory']['name'])?$data['FismaInventory']['name']:''),
	));
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_system_id', array(
		'label' => array(
			'text' => __('FISMA System'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_fisma_system_id',
		'selected' => (isset($data['FismaInventory']['fisma_system_id'])?$data['FismaInventory']['fisma_system_id']:''),
		'empty' => __('[Please Select a FISMA System]'),
		'options' => $fismaSystems,
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.FismaInventory.mac_address', array(
		'label' => array(
			'text' => __('MAC Address'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_mac_address',
		'value' => (isset($data['FismaInventory']['mac_address'])?$data['FismaInventory']['mac_address']:''),
		'id' => $mac_id,
	));
	
	$line .= $this->Form->input($i.'.FismaInventory.asset_tag', array(
		'label' => array(
			'text' => __('NIH Asset Tag'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_asset_tag',
		'value' => (isset($data['FismaInventory']['asset_tag'])?$data['FismaInventory']['asset_tag']:''),
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.FismaInventory.ip_address', array(
		'label' => array(
			'text' => __('IP Address'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_ip_address',
		'value' => (isset($data['FismaInventory']['ip_address'])?$data['FismaInventory']['ip_address']:''),
	));
	
	$line .= $this->Form->input($i.'.FismaInventory.dns_name', array(
		'label' => array(
			'text' => __('DNS Name'),
		),
		'div' => array('class' => 'half '),
		'class' => 'FismaInventory_dns_name',
		'value' => (isset($data['FismaInventory']['dns_name'])?$data['FismaInventory']['dns_name']:''),
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_type_id', array(
		'label' => array(
			'text' => __('Type'),
		),
		'div' => array('class' => 'third '),
		'class' => 'FismaInventory_fisma_type_id',
		'selected' => (isset($data['FismaInventory']['fisma_type_id'])?$data['FismaInventory']['fisma_type_id']:''),
		'empty' => __('[Please Select a Type]'),
		'options' => $fismaTypes,
	));
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_status_id', array(
		'label' => array(
			'text' => __('Status'),
		),
		'div' => array('class' => 'third '),
		'class' => 'FismaInventory_fisma_status_id',
		'selected' => (isset($data['FismaInventory']['fisma_status_id'])?$data['FismaInventory']['fisma_status_id']:''),
		'empty' => __('[Please Select a Status]'),
		'options' => $fismaStatuses,
	));
	
	$line .= $this->Form->input($i.'.FismaInventory.fisma_source_id', array(
		'label' => array(
			'text' => __('Source'),
		),
		'div' => array('class' => 'third '),
		'class' => 'FismaInventory_fisma_source_id',
		'selected' => (isset($data['FismaInventory']['fisma_source_id'])?$data['FismaInventory']['fisma_source_id']:''),
		'empty' => __('[Please Select a Source]'),
		'options' => $fismaSources,
	));
	
	$line .= '
	
<script type="text/javascript">

var submitResults = false;

$(document).ready(function()
{
	$(\'#'.$mac_id.'\').blur(function()
	{
		var myMac = $(this).val();
		myMac=myMac.toUpperCase();
		myMac=myMac.replace(/ /g,".");
		myMac=myMac.replace(/[^a-zA-Z0-9]+/g,"");
		$(this).val( myMac );
	});
});//ready 

</script>
	';
	
	$td[$i] = array(
		array(
			$line,
			array(
				'id' => 'td'. $mac_id,
				'class' => 'record',
			)
		)
	);
} 


echo $this->element('Utilities.table', array(
	'th' => $th,
	'td' => $td,
	'use_search' => false,
	'use_pagination' => false,
));

?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save the CSV Items to the %s', __('FISMA Inventory'))); ?>
	</div>
</div>

<?php 
$this->Js->buffer($this->Js->get('.remove_record')->event('click', '
	var td = $(this).parents("td.record");
	td.parents("tr").remove();
	return false;
	', array('stop' => false)));
	
echo $this->Js->writeBuffer(); 
?>