<?php ?>
<!-- File: app/View/Users/admin_edit.ctp -->

<div class="top">
	<h1><?php echo __('Edit User'); ?></h1>
</div>

<div class="center">
	<div class="tabs">
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo __('Edit User Details'); ?></a></li>
				<li><a href="#tabs-2"><?php echo __('Email Settings'); ?></a></li>
			</ul>
			
			<div id="tabs-1">
				<div class="form">
					<?php echo $this->Form->create('User');?>
					<fieldset>
						<legend><?php echo __('Edit User Details'); ?></legend>
						<?php
				echo $this->Form->input('id', array('type' => 'hidden'));
//				echo $this->Form->input('name');
//				echo $this->Form->input('email');
//				echo $this->Form->input('role', array('options' => $this->Wrap->userRoles()));
				echo $this->Form->input('paginate_items', array(
					'between' => $this->Html->para('form_info', __('How many items should show up in a table by default.')),
					'options' => array(
						'10' => '10',
						'25' => '25',
						'50' => '50',
						'100' => '100',
						'150' => '150',
						'200' => '200',
					),
				));
				echo $this->Form->input('api_key', array('type' => 'api_key'));
						?>
					</fieldset>
					<?php echo $this->Form->end(__('Save User Details'));?>
				</div>
			</div>
	
			<div id="tabs-2">
				<div class="form">
				<?php echo $this->Form->create('User');?>
					<fieldset>
						<legend><?php echo __('Email Settings'); ?></legend>
						<?php
							echo $this->Form->input('UserSetting.email_new', array(
								'label' => __('When new Equipment/Exception Update is added'),
								'between' => $this->Html->para('form_info', __('Get an email when a new equipment or exception update entry is entered.')),
								'options' => array(
									'0' => __('Never'),
									'1' => __('When I\'m involved.'),
									'2' => __('Always'),
								),
								'default' => '1',
							));
							echo $this->Form->input('UserSetting.email_updated', array(
								'label' => __('When Equipment/Exception Update is updated'),
								'between' => $this->Html->para('form_info', __('Get an email when a equipment or exception update entry is updated.')),
								'options' => array(
									'0' => __('Never'),
									'1' => __('When I\'m involved.'),
									'2' => __('Always'),
								),
								'default' => '1',
							));
							echo $this->Form->input('UserSetting.email_closed', array(
								'label' => __('When Equipment is closed'),
								'between' => $this->Html->para('form_info', __('Get an email when a equipment entry is marked as closed.')),
								'options' => array(
									'0' => __('Never'),
									'1' => __('When I\'m involved.'),
									'2' => __('Always'),
								),
								'default' => '1',
							));
							echo $this->Form->input('id', array('type' => 'hidden'));
							echo $this->Form->input('UserSetting.id', array('type' => 'hidden'));
						?>
					</fieldset>
				<?php echo $this->Form->end(__('Save Email Settings'));?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
	$(document).ready(function () {
		$( "#tabs" ).tabs();
	});
//]]>
</script>