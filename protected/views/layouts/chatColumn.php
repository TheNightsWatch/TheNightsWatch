<?php $this->beginContent('//layouts/main'); ?>
<?php if(isset($this->announcement)): ?>
<div id="announcement">
    Latest Announcement: <a href="<?php echo $this->createUrl('announcement/view',array('id' => $this->announcement->id)); ?>"><?php echo htmlspecialchars($this->announcement->subject); ?></a>
</div>
<?php endif; ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar"><ol id="chatters">
		<?php foreach($this->chatUsers as $user): ?>
			<li><a href="<?php echo $this->createUrl('user/view',array('unique' => $user->ign)); ?>" class="username" title="<?php echo htmlspecialchars($user->title); ?>"><img src="<?php echo $user->headUrl(16); ?>" /> <?php echo htmlspecialchars($user->ign); ?></a></li>
		<?php endforeach; ?>
	</ol></div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>