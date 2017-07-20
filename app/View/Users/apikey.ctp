<?php 
// File: app/View/Users/api_key.ctp
?>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create(); ?>
		    <fieldset>
		    	<?php
				echo $this->Form->input('api_key', array(
					'type' => 'api_key',
				));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(); ?>
	</div>
</div>