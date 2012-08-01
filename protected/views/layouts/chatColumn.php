<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar"><ol id="chatters">
		<?php foreach($this->chatUsers as $user): ?>
			<li><?php echo htmlspecialchars($user->ign); ?></li>
		<?php endforeach; ?>
	</ol></div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>