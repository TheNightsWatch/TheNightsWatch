<p>
	We are attempting to automatically connect you to <a
		href="<?php echo $teamspeak; ?>"><?php echo CHtml::encode($teamspeak); ?>
	</a>
</p>
<p>If Teamspeak does not open, please try entering in the server
	manually.</p>
<script>
setTimeout(function()
		{
    document.location = "<?php echo $teamspeak; ?>";
		},1);
</script>
