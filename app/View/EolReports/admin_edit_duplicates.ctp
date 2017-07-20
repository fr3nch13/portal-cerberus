<?php 
?>
<div class="top">
	<h1><?php echo __('Duplicates found in the %s:  %s', __('EOL Report'), $eol_report['EolReport']['name']); ?></h1>
</div>
<div class="center batchform ">
		<div>
		<ul>
			<li><?php echo __('If you don\'t want to change anything from the existing result, click the "Keep Existing Result" button.'); ?></li>
			<li><?php echo __('If you want to keep the existing result, and use the info from this report, click "Create as New Result".'); ?></li>
			<li><?php echo __('If you don\'t want to change one field then click the "Keep Existing Value Above" button.'); ?></li>
			<li><?php echo __('If you click "Keep Existing Value Above" button, and that is the last/only field that is a mismatch, then that record will be ignored, and it\'s row removed.'); ?></li>
			<li><?php echo __('If you get to a point where there are no records that need to be updated, clicking on the "%s" button will just take you to the details page.', __('Update %s', __('Eol Results'))); ?></li>
		</ul>
		</div>
		<div class="form">
			<?php echo $this->Form->create(); ?>
				<fieldset>
				<?php
$th = array(
	'ignore' => array('content' => __('Ignore All Changes')),
	'existing_id' => array('content' => __('Existing ID')),
	'ip_address_existing' => array('content' => __('Ip Address')),
	'mac_address' => array('content' => __('MAC Address')),
	'host_name' => array('content' => __('Host Name')),
	'netbios' => array('content' => __('NetBIOS')),
	'software' => array('content' => __('Software')),
);

$td = array();
$all_ids = array();
foreach($duplicates as $i => $duplicate)
{
	$remove = $this->Form->button(__('Keep Existing Result'), array(
		'type' => 'button', 
		'class' => 'remove_record'
	));
	$new_button = $this->Form->button(__('Create as New Result'), array(
		'type' => 'button', 
		'class' => 'new_record'
	));
	
	$id = $duplicate['id'];
	$all_ids[$id] = $id;
	
	$input_id = $this->Form->input($id.'.EolResult.id', array('type' => 'hidden', 'value' => $id));
	$input_new = $this->Form->input($id.'.EolResult.new', array('type' => 'hidden', 'value' => 0, 'class' => 'input_new'));
	
	$ip_address_td = $duplicate['ip_address'];
	if($duplicate['ip_address'] != $duplicate['existing']['ip_address'])
	{
		$input_ip_address_existing = $duplicate['existing']['ip_address'];
		
		$input_ip_address_new = $this->Form->input($id.'.EolResult.ip_address', array(
			'type' => 'text', 
			'value' => $duplicate['ip_address'],
//			'div' => false,
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$ip_address_td = $input_ip_address_existing. $input_ip_address_new;
	}
	
	$mac_address_td = $duplicate['mac_address'];
	if($duplicate['mac_address'] != $duplicate['existing']['mac_address'])
	{
		$input_mac_address_existing = $duplicate['existing']['mac_address'];
		
		$input_mac_address_new = $this->Form->input($id.'.EolResult.mac_address', array(
			'type' => 'text', 
			'value' => $duplicate['mac_address'],
//			'div' => false,
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$mac_address_td = $input_mac_address_existing. $input_mac_address_new;
	}
	
	$host_name_td = $duplicate['host_name'];
	if($duplicate['host_name'] != $duplicate['existing']['host_name'])
	{
		$input_host_name_existing = $duplicate['existing']['host_name'];
		
		$input_host_name_new = $this->Form->input($id.'.EolResult.host_name', array(
			'type' => 'text', 
			'value' => $duplicate['host_name'],
//			'div' => false,
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$host_name_td = $input_host_name_existing. $input_host_name_new;
	}
	
	$netbios_td = $duplicate['netbios'];
	if($duplicate['netbios'] != $duplicate['existing']['netbios'])
	{
		$input_netbios_existing = $duplicate['existing']['netbios'];
		
		$input_netbios_new = $this->Form->input($id.'.EolResult.netbios', array(
			'type' => 'text', 
			'value' => $duplicate['netbios'],
//			'div' => false,
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$netbios_td = $input_netbios_existing. $input_netbios_new;
	}
	
	$eol_software_td = $eolSoftwares[$duplicate['existing']['eol_software_id']];
	$eol_software_td .=  $this->Form->input($id.'.EolResult.eol_software_id', array('type' => 'hidden', 'value' => $duplicate['existing']['eol_software_id']));
	if($duplicate['eol_software_id'] != $duplicate['existing']['eol_software_id'])
	{
		$input_eol_software_existing = $eolSoftwares[$duplicate['existing']['eol_software_id']];
		
		$input_eol_software_new = $this->Form->input($id.'.EolResult.eol_software_id', array(
			'type' => 'text', 
			'value' => $duplicate['eol_software_id'],
			'options' => $eolSoftwares,
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$eol_software_td = $input_eol_software_existing. $input_eol_software_new;
	}
	
	$td[] = array(
		$remove. '<br/>'. $new_button,
		$input_id. $input_new.
		$this->Html->link($id, array('controller' => 'eol_results', 'action' => 'view', $id), array('target' => 'eol_result_existing', 'class' => 'existing_id')),
		$ip_address_td,
		$mac_address_td,
		$host_name_td,
		$netbios_td,
		$eol_software_td,
	);
}


$input_all_ids = array();
foreach($all_ids as $id)
{
	$input_all_ids[$id] = $this->Form->input('all_ids.id.'.$id, array('type' => 'hidden', 'value' => $id));
}

echo implode("\n", $input_all_ids);

echo $this->element('Utilities.table', array(
	'th' => $th,
	'td' => $td,
	'use_search' => false,
	'use_pagination' => false,
	'show_refresh_table' => false,
)); 
		        ?>
				</fieldset>
			<?php echo $this->Form->end(__('Update %s', __('Eol Results'))); ?>
		</div>
</div>
<script type="text/javascript">

var submitResults = false;

$(document).ready(function()
{
	$('.new_record').each(function(){
		var tr = $(this).parents('tr');
		
		$(this).on('click', function(event){
			event.preventDefault();
			
			tr.find('td input.input_new').each(function(){
				$(this).val(1);
			});
			
			tr.find('td div.input').each(function(){
				$(this).hide();
			});
			
			tr.find('td a.existing_id').each(function(){
				$(this).replaceWith(function(){
        			return $("<span>Create New Result</span>");
    			});
			});
			
		});
	});
	
	$('.remove_record').each(function(){
		var tr = $(this).parents('tr');
		
		tr.find('td').each(function(){
			$(this).addClass('nowrap');
		});
		
		$(this).on('click', function(event){
			event.preventDefault();
			tr.remove();
		});
	});
	
	$('.remove_field').each(function(){
		var div_field = $(this).parents('div.input');
		
		$(this).on('click', function(event){
			event.preventDefault();
			
			var input_count = 0;
			var tr = $(this).parents('tr');
			div_field.remove();
		
			// check to see if there are any other active input fields
			$(tr).find('div.input').each(function(){
				input_count++;
			});
			
			if(input_count == 0)
			{
				tr.remove();
			}
		});
	});
});//ready 

</script>