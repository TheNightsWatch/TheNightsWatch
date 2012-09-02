<header>
	<h1>
		<?= CHtml::encode($user->ign) ?>
	</h1>
	<div style="text-align: right;">
		<em><?= $user->title ?> of the Night's Watch</em>
	</div>
	<div style="text-align: right; font-weight: bold;">
		<?php if($user->verified): ?>
		<em>Verified Member</em>
		<?php else: ?>
		<em>Account NOT Verified</em>
		<?php endif;?>
	</div>
</header>
<p>Information will go here once/if I acquire some sort of API for MineZ
	Stats</p>
