<?php 
// File: app/View/Rule/edit_state.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s\'s %s', __('Rule'), __('Review State')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Rule');?>
			<?php echo $this->Form->input('Rule.id', array('type' => 'hidden')); ?>
		    <fieldset>
		        <?php
					echo $this->Form->input('Rule.review_state_id', array(
						'label' => __('Review State'),
						'options' => $review_states,
					));
					echo $this->Form->input('ReviewStateLog.comments', array(
						'label' => __('Comments'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.send_notification', array(
						'label' => false,
						'type' => 'checkbox',
						'checked' => false,
						'class' => 'switch_holder',
					));
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Review State'))); ?>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function()
{
	// add the switchbutton to the search
	var sb_options = {
		on_label: '<?php echo _("Notify Others"); ?>',
  		off_label: false,
  		clear: false,
	};
	$("input.switch_holder").switchButton(sb_options);
});//ready 
</script>