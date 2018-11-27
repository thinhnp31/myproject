<?php
	if (isset($msg)  && ($msg != "")) {
?>
		<div class="alert alert-<?php echo $msg_type;?> " role="alert" id="message">			
			<?php echo $msg; ?>
			<button type="button" class="close" onclick="$('#message').hide();"><span>&times;</span></button>
		</div>
<?php
	}
?>