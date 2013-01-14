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
<?php if($user->minezDonor): ?>
<p><?= CHtml::encode($user->ign) ?> is <?php echo !in_array(strtolower(substr($user->minezDonor,0,1)),array('a','e','i','o','u')) ? 'a' : 'an' ?> <?= CHtml::encode($user->minezDonor); ?> level donator to MineZ.</p>
<?php endif; ?>
