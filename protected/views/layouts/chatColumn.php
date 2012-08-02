<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar"><ol id="chatters">
		<?php foreach($this->chatUsers as $user): ?>
			<li><a href="<?php echo $this->createUrl('user/view',array('unique' => $user->ign)); ?>" class="username"><img src="<?php echo $user->headUrl(16); ?>" /> <?php echo htmlspecialchars($user->ign); ?></a></li>
		<?php endforeach; ?>
	</ol></div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>