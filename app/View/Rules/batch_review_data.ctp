<?php
// File: app/View/Equipment/batch_review_data.ctp
?>
<div class="top">
	<h1><?php echo __('Create Many New NAC Exceptions/Tracking'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Equipment', array('id' => 'AddEquipmentForm'));?>
		    <fieldset>
		        <legend class="section"><?php echo __('Review the CSV Items to be added to Naccess'); ?></legend>
		        <?php
$th = array(
	'content' => array('content' => __(' ')),
);


$td = array();
$i = 0;
foreach($this->request->data as $data)
{
	$line = '';
	
	$mac_id = 'MacAddress_'. $i;
	
	$line .= $this->Form->button(__('Remove this CSV Item'), array(
		'type' => 'button', 
		'class' => 'remove_record'
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.EquipmentDetail.mac_address', array(
		'label' => array(
			'text' => __('Associated MAC Address'),
		),
		'div' => array('class' => 'third'),
		'value' => (isset($data['EquipmentDetail']['mac_address'])?$data['EquipmentDetail']['mac_address']:''),
		'id' => $mac_id,
	));
	
	$line .= $this->Form->input($i.'.EquipmentDetail.ip_address', array(
		'label' => array(
			'text' => __('Associated IP Address'),
		),
		'div' => array('class' => 'third'),
		'value' => (isset($data['EquipmentDetail']['ip_address'])?$data['EquipmentDetail']['ip_address']:''),
	));
	
	$line .= $this->Form->input($i.'.EquipmentDetail.asset_tag', array(
		'label' => array(
			'text' => __('Serial Number or NIH Asset Tag'),
		),
		'div' => array('class' => 'third'),
		'value' => (isset($data['EquipmentDetail']['asset_tag'])?$data['EquipmentDetail']['asset_tag']:''),
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.EquipmentDetail.ticket_ticket', array(
		'label' => array(
			'text' => __('%s Ticket', $this->Html->link('Ticket', 'https://tickets.example.com/', array('target' => '_blank'))),
		),
		'div' => array('class' => 'half'),
		'value' => (isset($data['EquipmentDetail']['ticket_ticket'])?$data['EquipmentDetail']['ticket_ticket']:'TBD'),
	));
	
	$line .= $this->Form->input($i.'.EquipmentDetail.tickets', array(
		'label' => array(
			'text' => __('Other Related Tickets'),
		),
		'div' => array('class' => 'half'),
		'value' => (isset($data['EquipmentDetail']['tickets'])?$data['EquipmentDetail']['tickets']:''),
		'type' => 'text',
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.EquipmentDetail.apo', array(
		'label' => array(
			'text' => __('Associated Project Officer, COR or COTR'),
		),
		'div' => array('class' => 'half'),
		'value' => (isset($data['EquipmentDetail']['apo'])?$data['EquipmentDetail']['apo']:''),
	));
	
	$line .= $this->Form->input($i.'.EquipmentDetail.tech_poc', array(
		'label' => array(
			'text' => __('Technical POC'),
		),
		'div' => array('class' => 'half'),
		'value' => (isset($data['EquipmentDetail']['tech_poc'])?$data['EquipmentDetail']['tech_poc']:''),
	));
	
	$line .= $this->Wrap->divClear();
	
	$line .= $this->Form->input($i.'.EquipmentType', array(
		'label' => array(
			'text' => __('Equipment Type(s)'),
		),
		'div' => array('class' => 'third'),
		'options' => $equipment_types,
		'empty' => __('None/Other'),
	));
	
	$line .= $this->Form->input($i.'.Equipment.op_div_id', array(
		'label' => array(
			'text' => __('OPDIV/IC'),
		),
		'div' => array('class' => 'third'),
		'value' => (isset($data['Equipment']['op_div_id'])?$data['Equipment']['op_div_id']:0),
		'options' => $op_divs,
		'empty' => __('None/Other'),
	));
	
	$line .= $this->Form->input($i.'.EquipmentDetail.op_div_other', array(
		'type' => 'hidden',
	));
	
/*
	$line .= $this->Form->input($i.'.EquipmentDetail.op_div_other', array(
		'label' => array(
			'text' => __('OPDIV/IC (Not in list)'),
		),
		'div' => array('class' => 'third'),
		'value' => (isset($data['EquipmentDetail']['op_div_other'])?$data['EquipmentDetail']['op_div_other']:''),
	));
*/
	
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
		
		if($(this).val().length)
		{
			$.post(
				"'. $this->Html->url(array('controller' => 'equipment', 'action' => 'validate_mac')). '",
				{ field: $(this).attr(\'id\'), value: $(this).val() },
				function (error)
				{
    				if(error.length > 0)
    				{
    					alert(error);
    					$( \'#'.$mac_id.'\' ).focus();
    					return false;
    				}
    				return true;
				}
			);
		}
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
		<?php echo $this->Form->end(__('Save the CSV Items to Naccess')); ?>
	</div>
</div><script type="text/javascript">

var submitResults = false;

$(document).ready(function()
{
	$('.remove_record').click(function()
	{
		// find the parents
		var $td = $(this).parents('td.record');
		$td.parents('tr').remove();
		return false;
	});

});//ready 

</script>