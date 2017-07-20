<?php
// File: app/View/Rule/add.ctp
?>
<div class="top">
	<h1><?php echo __('Create New %s', __('Rule')); ?></h1>
	<h3><?php echo __('All fields are required.'); ?></h3>
	<div class="page_options">
		<ul>
			<li>
				<?php 
				$rule_id = false;
				$firewall_id = false;
				if(isset($this->request->params['pass'][0]))
					$rule_id = $this->request->params['pass'][0];
				if(isset($this->request->params['pass'][2]))
					$firewall_id = $this->request->params['pass'][2];
				echo $this->Html->link(__('Advanced Form'), array('action' => 'add_advanced', $rule_id, $firewall_id)); 
				echo $this->Html->link(__('ASA Config Form'), array('action' => 'add_asa', $rule_id, $firewall_id)); 
				?>
			</li>
		</ul>
	</div>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Rule');?>
		    <fieldset>
				<h3><?php echo __('Details'); ?></h3>
		        <?php
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.poc_email', array(
						'label' => array(
							'text' => __('Rule POC Email'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('Rule.ticket', array(
						'label' => array(
							'text' => __('Related Tickets'),
						),
						'div' => array('class' => 'twothird'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.fw_int_id', array(
						'label' => array(
							'text' => __('Firewall Path'),
						),
						'div' => array('class' => 'forth'),
						'options' => $fw_ints,
					));
					echo $this->Form->input('use_fw_int', array('type' => 'hidden', 'value' => true));
					
					echo $this->Form->input('Rule.protocol_id', array(
						'label' => array(
							'text' => __('Protocol'),
						),
						'div' => array('class' => 'forth'),
						'options' => $protocols,
					));
					
					echo $this->Form->input('Rule.permit', array(
						'type' => 'hidden',
						'value' => 1,
					));
					
					echo $this->Wrap->divClear();
				?>
				<h3><?php echo __('Source'); ?></h3>
				<?php
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.src_fisma_system_id', array(
						'label' => array(
							'text' => __('FISMA System'),
						),
						'div' => array('class' => 'forth'),
						'options' => $fisma_systems,
					));
					
					echo $this->Form->input('Rule.src_fog_id', array(
						'label' => array(
							'text' => __('Firewall Object Group'),
						),
						'div' => array('class' => 'forth', 'id' => 'RuleSrcFogIdDiv'),
						'options' => $fogs,
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use Custom Ip Address(es)'), '#', array('id' => 'UseRuleSrcIpId'))),
					));
					echo $this->Form->input('Rule.src_ip', array(
						'label' => array(
							'text' => __('Ip Address(es)'),
						),
						'div' => array('class' => 'forth', 'id' => 'RuleSrcIpDiv'),
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use %s', __('Firewall Object Group')), '#', array('id' => 'UseRuleSrcFogId'))),
					));
					echo $this->Form->input('use_src_fog', array('type' => 'hidden', 'value' => 1));
					
					echo $this->Form->input('Rule.src_pog_id', array(
						'label' => array(
							'text' => __('Port Object Group'),
						),
						'div' => array('class' => 'forth', 'id' => 'RuleSrcPogIdDiv'),
						'options' => $pogs,
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use Port(s)'), '#', array('id' => 'UseRuleSrcPortId'))),
					));
					echo $this->Form->input('Rule.src_port', array(
						'label' => array(
							'text' => __('Port(s)'),
						),
						'class' => 'half',
						'div' => array('class' => 'forth', 'id' => 'RuleSrcPortDiv'),
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use %s', __('Port Object Group')), '#', array('id' => 'UseRuleSrcPogId'))),
					));
					echo $this->Form->input('use_src_pog', array('type' => 'hidden', 'value' => 1));
					
					echo $this->Form->input('Rule.src_desc', array(
						'label' => array(
							'text' => __('Description for IP Address(es)'),
						),
						'type' => 'text',
						'div' => array('class' => 'forth'),
					));
					
					echo $this->Wrap->divClear();
				?>
				<h3><?php echo __('Destination'); ?></h3>
				<?php
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.dst_fisma_system_id', array(
						'label' => array(
							'text' => __('FISMA System'),
						),
						'div' => array('class' => 'forth'),
						'options' => $fisma_systems,
					));
					
					echo $this->Form->input('Rule.dst_fog_id', array(
						'label' => array(
							'text' => __('Firewall Object Group'),
						),
						'div' => array('class' => 'forth', 'id' => 'RuleDstFogIdDiv'),
						'options' => $fogs,
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use Ip Address(es)'), '#', array('id' => 'UseRuleDstIpId'))),
					));
					echo $this->Form->input('Rule.dst_ip', array(
						'label' => array(
							'text' => __('Ip Address(es)'),
						),
						'div' => array('class' => 'forth', 'id' => 'RuleDstIpDiv'),
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use %s', __('Firewall Object Group')), '#', array('id' => 'UseRuleDstFogId'))),
					));
					echo $this->Form->input('use_dst_fog', array('type' => 'hidden', 'value' => 1));
					
					
					echo $this->Form->input('Rule.dst_pog_id', array(
						'label' => array(
							'text' => __('Port Object Group'),
						),
						'div' => array('class' => 'forth', 'id' => 'RuleDstPogIdDiv'),
						'options' => $pogs,
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use Port(s)'), '#', array('id' => 'UseRuleDstPortId'))),
					));
					echo $this->Form->input('Rule.dst_port', array(
						'label' => array(
							'text' => __('Port(s)'),
						),
						'class' => 'half',
						'div' => array('class' => 'forth', 'id' => 'RuleDstPortDiv'),
						'after' => $this->Html->tag('div', $this->Html->link(__('Click to use %s', __('Port Object Group')), '#', array('id' => 'UseRuleDstPogId'))),
					));
					echo $this->Form->input('use_dst_pog', array('type' => 'hidden', 'value' => 1));
					
					echo $this->Form->input('Rule.dst_desc', array(
						'label' => array(
							'text' => __('Description for IP Address(es)'),
						),
						'type' => 'text',
						'div' => array('class' => 'forth'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.logging', array(
						'type' => 'hidden',
						'value' => 'log notifications',
					));
					
					echo $this->Form->input('Rule.comments', array(
						'label' => array(
							'text' => __('Comments'),
						),
						'class' => 'short',
						//'div' => array('class' => 'third'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.send_notification', array(
						'label' => array(
							'text' => __('Notify Other Users'),
						),
						'type' => 'checkbox',
						'checked' => false,
						'class' => 'switch_holder',
					));
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Add %s', __('Rule'))); ?>
	</div>
</div>

<?php 
	$src_fw_int_show = 'BInput';
	if(isset($this->data['Rule']['use_fw_int']) and $this->data['Rule']['use_fw_int'])
		$src_fw_int_show = 'AInput';
		
	$src_fog_show = 'BInput';
	if(isset($this->data['Rule']['use_src_fog']) and $this->data['Rule']['use_src_fog'])
		$src_fog_show = 'AInput';
	
	$dst_fog_show = 'BInput';
	if(isset($this->data['Rule']['use_dst_fog']) and $this->data['Rule']['use_dst_fog'])
		$dst_fog_show = 'AInput';
	
	$src_port_show = 'BInput';
	if(isset($this->data['Rule']['use_src_pog']) and $this->data['Rule']['use_src_pog'])
		$src_port_show = 'AInput';
	
	$dst_port_show = 'BInput';
	if(isset($this->data['Rule']['use_dst_pog']) and $this->data['Rule']['use_dst_pog'])
		$dst_port_show = 'AInput';
?>
<script type="text/javascript">

$(document).ready(function()
{
	// add the switchbutton to the search
	var sb_options = {
		on_label: '<?php echo _("Notify Other Users"); ?>',
  		off_label: false,
  		clear: false,
	};
	//$("input.switch_holder").switchButton(sb_options); 
	
	// Source FOG / Ip
	$('body').foFieldSwitcher({
		// These are the defaults.
		DefaultShow: 		'<?php echo $src_fog_show; ?>',
		HiddenSwitchId:		'#RuleUseSrcFog',
		AInput: { FieldID: '#RuleSrcFogId', FieldDiv: '#RuleSrcFogIdDiv', FieldSwitcher: '#UseRuleSrcIpId', HiddenSwitchValue: 1 },
		BInput: { FieldID: '#RuleSrcIp', FieldDiv: '#RuleSrcIpDiv', FieldSwitcher: '#UseRuleSrcFogId', HiddenSwitchValue: 0 },
	});
	// Destination FOG / Ip
	$('body').foFieldSwitcher({
		// These are the defaults.
		DefaultShow: 		'<?php echo $dst_fog_show; ?>',
		HiddenSwitchId:		'#RuleUseDstFog',
		AInput: { FieldID: '#RuleDstFogId', FieldDiv: '#RuleDstFogIdDiv', FieldSwitcher: '#UseRuleDstIpId', HiddenSwitchValue: 1 },
		BInput: { FieldID: '#RuleDstIp', FieldDiv: '#RuleDstIpDiv', FieldSwitcher: '#UseRuleDstFogId', HiddenSwitchValue: 0 },
	});
	
	// Source Port Object Group / Port
	$('body').foFieldSwitcher({
		// These are the defaults.
		DefaultShow: 		'<?php echo $src_port_show; ?>',
		HiddenSwitchId:		'#RuleUseSrcPog',
		AInput: { FieldID: '#RuleSrcPogId', FieldDiv: '#RuleSrcPogIdDiv', FieldSwitcher: '#UseRuleSrcPortId', HiddenSwitchValue: 1 },
		BInput: { FieldID: '#RuleSrcPort', FieldDiv: '#RuleSrcPortDiv', FieldSwitcher: '#UseRuleSrcPogId', HiddenSwitchValue: 0 },
	});
	// Source Port Object Group / Port
	$('body').foFieldSwitcher({
		// These are the defaults.
		DefaultShow: 		'<?php echo $dst_port_show; ?>',
		HiddenSwitchId:		'#RuleUseDstPog',
		AInput: { FieldID: '#RuleDstPogId', FieldDiv: '#RuleDstPogIdDiv', FieldSwitcher: '#UseRuleDstPortId', HiddenSwitchValue: 1 },
		BInput: { FieldID: '#RuleDstPort', FieldDiv: '#RuleDstPortDiv', FieldSwitcher: '#UseRuleDstPogId', HiddenSwitchValue: 0 },
	});
	
	// try to fill out the comments
	$('#RuleSrcIp').blur(function()
	{
		if(!$('#RuleSrcDesc').val().length)
		{
			if($(this).val().length)
			{
			
				$.post(
					"<?php echo $this->Html->url(array('controller' => 'host_aliases', 'action' => 'lookup_ip')); ?>",
					{ field: $(this).attr('id'), value: $(this).val() },
					function(msg) {
						 if(msg.length > 0)
						 {
						 	$('#RuleSrcDesc').val(msg);
						 }
					}
				);
			}
		}
	});
	// try to fill out the comments
	$('#RuleDstIp').blur(function()
	{
		if(!$('#RuleDstDesc').val().length)
		{
			if($(this).val().length)
			{
			
				$.post(
					"<?php echo $this->Html->url(array('controller' => 'rules', 'action' => 'lookup_ip')); ?>",
					{ field: $(this).attr('id'), value: $(this).val() },
					function(msg) {
						 if(msg.length > 0)
						 {
						 	$('#RuleDstDesc').val(msg);
						 }
					}
				);
			}
		}
	});
});//ready 

</script>