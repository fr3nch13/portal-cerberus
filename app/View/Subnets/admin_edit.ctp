<?php 
// File: app/View/Subnet/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('Subnet') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Subnet');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Subnet') ); ?></legend>
		    	<?php
				echo $this->Form->input('id');
				
				echo $this->Form->input('subnet_check', array(
					'type' => 'hidden', 
					'id'=> 'subnet_check', 
					'class' => 'subnet_check'
				));
				echo $this->Form->input('cidr', array(
					'label' => __('CIDR'),
					'class' => 'subnet_check',
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('netmask', array(
					'class' => 'subnet_check',
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('ip_start', array(
					'class' => 'subnet_check',
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('ip_end', array(
					'class' => 'subnet_check',
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('ic', array(
					'label' => __('IC'),
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('location', array(
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('comments', array(
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('dhcp', array(
					'label' => __('DHCP?'),
					'div' => array('class' => 'forth'),
					'type' => 'select',
					'options' => array(
						0 => __('Unknown'),
						1 => __('Yes'),
						2 => __('No'),
					),
				));
				echo $this->Form->input('dhcp_scope', array(
					'label' => __('DHCP Scope'),
					'div' => array('class' => 'threeforths'),
				));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Subnet') )); ?>
	</div>
</div>
<script type="text/javascript">

//<![CDATA[
$(document).ready(function()
{
	$('input.subnet_check').blur(function() 
	{
		$('#subnet_check').val($(this).attr('data-field'));
		var data = $('input.subnet_check').serialize();
		$.ajax({
			type: "POST",
			url: '<?php echo $this->Html->url(array("action" => "subnet_check")); ?>',
			data: data,
			dataType: 'json',
			success: function(data, textStatus, jqXHR)
			{
				$.each(data.data.Subnet, function(i, item)
				{
					$('input[data-field="Subnet.'+i+'"]').val(item);
				});
			},
		});
	});
});//ready
//]]>

</script>
