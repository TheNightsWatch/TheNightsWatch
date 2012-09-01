<header>
	<h1><?= CHtml::encode($user->ign) ?></h1>
	<div style="text-align: right;"><em><?= $user->title ?> of the Night's Watch</em></div>
	<?php if($user->verified): ?><div style="text-align: right;font-weight:bold;"><em>Verified Member</em></div><?php endif; ?>
</header>
<p>Information will go here once/if I acquire some sort of API for MineZ Stats</p>