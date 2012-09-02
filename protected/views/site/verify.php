<?php if(Yii::app()->user->hasFlash('verify')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('verify'); ?>
</div>
<?php elseif(Yii::app()->user->hasFlash('verify_error')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('verify_error'); ?>
</div>
<?php else: ?>
<div class="flash-notice">Due to recent impersonation attempts, we now
	require all Minecraft usernames to be verified. To verify your
	Minecraft account, simply enter your Minecraft or Mojang username and
	password into the form below. If you feel uncomfortable providing this
	information, feel free to change your password before and after the
	verification process. Verification will only toggle a verified flag on
	your account, and change your IGN to the proper capitalization. Neither
	your mojang email, nor your password will be stored.</div>
<?php endif; ?>

<?php $form = $this->beginWidget('CActiveForm'); ?>
<label>Username: <input name="user" />
</label>
<br />
<label>Password: <input name="pass" type="password" />
</label>
<br />
<input type="submit" />
<?php $this->endWidget(); ?>