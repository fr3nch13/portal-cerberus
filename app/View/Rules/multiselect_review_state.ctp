<?php ?>
<!-- File: app/View/Rules/multiselect_review_state.ctp -->
<div class="top">
	<h1><?php echo __('Assign %s to %s', __('Review State'), __('Rule')); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create('Rule');?>
	    <fieldset>
	        <legend><?php echo __('Assign %s to %s', __('Review State'), __('Rule')); ?></legend>
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
	<?php echo $this->Form->end(__('Update %s', __('Rules'))); ?>
	</div>
</div>

<script type="text/javascript">
//$(document).ready(function()
//{
//	// add the switchbutton to the search
//	var sb_options = {
//		on_label: '<?php echo _("Notify Others"); ?>',
//  		off_label: false,
// 		clear: false,
//	};
//	$("input.switch_holder").switchButton(sb_options);
//});//ready 
</script>
