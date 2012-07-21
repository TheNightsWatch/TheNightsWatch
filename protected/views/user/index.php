<ul style="list-style-type:none;">
<?php foreach($users as $user): ?>
	<li><img src="<?= $user->headUrl(16); ?>" style="width:16px;height:16px;vertical-align:middle;" /> <a href="<?= $this->createUrl('/user/view',array('unique' => $user->ign)); ?>"><?= CHtml::encode($user->ign); ?></a>, <em><?= $user->title; ?> of the Night's Watch</em></li>
<?php endforeach; ?>
</ul>