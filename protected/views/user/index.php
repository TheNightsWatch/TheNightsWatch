<ul>
<?php foreach($users as $user): ?>
	<li><a href="<?= $this->createUrl('/user/view',array('unique' => $user->ign)); ?>"><?= CHtml::encode($user->ign); ?></a>, <em><?= $user->title; ?> of the Night's Watch</em></li>
<?php endforeach; ?>
</ul>