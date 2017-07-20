<?php 
?>
<div class="top">
	<h1><?php echo __('Duplicates found in the %s:  %s', __('High Risk Report'), $high_risk_report['HighRiskReport']['name']); ?></h1>
</div>
<div class="center batchform ">
		<div>
		<ul>
			<li><?php echo __('If you don\'t want to change anything from the existing result, click the "Keep Existing Result" button.'); ?></li>
			<li><?php echo __('If you want to keep the existing result, and use the info from this report, click "Create as New Result".'); ?></li>
			<li><?php echo __('If you don\'t want to change one field then click the "Keep Existing Value Above" button.'); ?></li>
			<li><?php echo __('If you click "Keep Existing Value Above" button, and that is the last/only field that is a mismatch, then that record will be ignored, and it\'s row removed.'); ?></li>
			<li><?php echo __('If you get to a point where there are no records that need to be updated, clicking on the "%s" button will just take you to the details page.', __('Update %s', __('HighRisk Results'))); ?></li>
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
	'host_name' => array('content' => __('Host Name')),
	'port' => array('content' => __('Port')),
	'vulnerability' => array('content' => __('Vulnerability')),
	
	'reports_system_type_id' => array('content' => __('System Type')),
	'dhs' => array('content' => __('DHS')),
	'reported_to_ic_date' => array('content' => __('Reported to ORG/IC')),
	'resolved_by_date' => array('content' => __('Must be Resolved By')),
//	'estimated_remediation_date' => array('content' => __('Est. Remediation Date')),
);

$td = array();
$all_ids = array();
foreach($duplicates as $i => $duplicate)
{
	$needsedit = false;
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
	
	$input_id = $this->Form->input($id.'.HighRiskResult.id', array('type' => 'hidden', 'value' => $id));
	$input_new = $this->Form->input($id.'.HighRiskResult.new', array('type' => 'hidden', 'value' => 0, 'class' => 'input_new'));
	
	$ip_address_td = $duplicate['ip_address'];
	if($duplicate['ip_address'] != $duplicate['existing']['ip_address'])
	{
		$needsedit = true;
		$input_ip_address_existing = $duplicate['existing']['ip_address'];
		$input_ip_address_new = $this->Form->input($id.'.HighRiskResult.ip_address', array(
			'type' => 'text', 
			'value' => $duplicate['ip_address'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$ip_address_td = $input_ip_address_existing. $input_ip_address_new;
	}
	
	$host_name_td = $duplicate['host_name'];
	if($duplicate['host_name'] != $duplicate['existing']['host_name'])
	{
		$needsedit = true;
		$input_host_name_existing = $duplicate['existing']['host_name'];
		$input_host_name_new = $this->Form->input($id.'.HighRiskResult.host_name', array(
			'type' => 'text', 
			'value' => $duplicate['host_name'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$host_name_td = $input_host_name_existing. $input_host_name_new;
	}

	$port_td = $duplicate['port'];
	if($duplicate['port'] != $duplicate['existing']['port'])
	{
		$needsedit = true;
		$input_port_existing = $duplicate['existing']['port'];
		$input_port_new = $this->Form->input($id.'.HighRiskResult.port', array(
			'type' => 'text', 
			'value' => $duplicate['port'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$port_td = $input_port_existing. $input_port_new;
	}
	
	$vulnerability_td = $duplicate['vulnerability'];
	if($duplicate['vulnerability'] != $duplicate['existing']['vulnerability'])
	{
		$needsedit = true;
		$input_vulnerability_existing = $duplicate['existing']['vulnerability'];
		$input_vulnerability_new = $this->Form->input($id.'.HighRiskResult.vulnerability', array(
			'type' => 'text', 
			'value' => $duplicate['vulnerability'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$vulnerability_td = $input_vulnerability_existing. $input_vulnerability_new;
	}
	
	$reports_system_type_id_td = $duplicate['reports_system_type_id'];
	if($duplicate['reports_system_type_id'] != $duplicate['existing']['reports_system_type_id'])
	{
		$needsedit = true;
		$input_reports_system_type_id_existing = $duplicate['existing']['reports_system_type_id'];
		$input_reports_system_type_id_new = $this->Form->input($id.'.HighRiskResult.reports_system_type_id', array(
			'type' => 'select', 
			'value' => $duplicate['reports_system_type_id'],
			'options' => $reportsSystemTypes,
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$reports_system_type_id_td = $input_reports_system_type_id_existing. $input_reports_system_type_id_new;
	}

	$dhs_td = $duplicate['dhs'];
	if($duplicate['dhs'] != $duplicate['existing']['dhs'])
	{
		$needsedit = true;
		$input_dhs_existing = $duplicate['existing']['dhs'];
		$input_dhs_new = $this->Form->input($id.'.HighRiskResult.dhs', array(
			'type' => 'text', 
			'value' => $duplicate['dhs'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$dhs_td = $input_dhs_existing. $input_dhs_new;
	}

	$reported_to_ic_date_td = $duplicate['reported_to_ic_date'];
	if($duplicate['reported_to_ic_date'] != $duplicate['existing']['reported_to_ic_date'])
	{
		$needsedit = true;
		$input_reported_to_ic_date_existing = $duplicate['existing']['reported_to_ic_date'];
		$input_reported_to_ic_date_new = $this->Form->input($id.'.HighRiskResult.reported_to_ic_date', array(
			'type' => 'date', 
			'value' => $duplicate['reported_to_ic_date'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$reported_to_ic_date_td = $input_reported_to_ic_date_existing. $input_reported_to_ic_date_new;
	}

	$resolved_by_date_td = $duplicate['resolved_by_date'];
	if($duplicate['resolved_by_date'] != $duplicate['existing']['resolved_by_date'])
	{
		$needsedit = true;
		$input_resolved_by_date_existing = $duplicate['existing']['resolved_by_date'];
		$input_resolved_by_date_new = $this->Form->input($id.'.HighRiskResult.resolved_by_date', array(
			'type' => 'date', 
			'value' => $duplicate['resolved_by_date'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$resolved_by_date_td = $input_resolved_by_date_existing. $input_resolved_by_date_new;
	}

/*
	$estimated_remediation_date_td = $duplicate['estimated_remediation_date'];
	if($duplicate['estimated_remediation_date'] != $duplicate['existing']['estimated_remediation_date'])
	{
		$input_estimated_remediation_date_existing = $duplicate['existing']['estimated_remediation_date'];
		$input_estimated_remediation_date_new = $this->Form->input($id.'.HighRiskResult.estimated_remediation_date', array(
			'type' => 'date', 
			'value' => $duplicate['estimated_remediation_date'],
			'label' => __('New Value'),
			'between' => $this->Form->button(__('Keep Existing Value Above'), array(
				'type' => 'button', 
				'class' => 'remove_field'
			)). '<br/>',
			'before' => '<hr/>',
		));
		
		$estimated_remediation_date_td = $input_estimated_remediation_date_existing. $input_estimated_remediation_date_new;
	}
*/
	
	if($needsedit)
	{
		$td[] = array(
			$remove. '<br/>'. $new_button,
			$input_id. $input_new.
			$this->Html->link($id, array('controller' => 'high_risk_results', 'action' => 'view', $id), array('target' => 'high_risk_result_existing', 'class' => 'existing_id')),
			$ip_address_td,
			$host_name_td,
			$port_td,
			$vulnerability_td,
			$reports_system_type_id_td,
			$dhs_td,
			$reported_to_ic_date_td,
			$resolved_by_date_td,
	//		$estimated_remediation_date_td,
		);
	}
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
			<?php echo $this->Form->end(__('Update %s', __('HighRisk Results'))); ?>
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