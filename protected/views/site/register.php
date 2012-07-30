<?php
$this->setPageTitle('Register');
$this->breadcrumbs=array(
	'Register',
);
?>

<h1>Register</h1>

<p><strong>Important Things to remember before joining the watch:</strong></p>
<ul>
	<li>The Watch does not take part in the politics of the realm.  By joining the watch, you must forget the politcs of any churches you belonged to.  You may keep the religion, but stay out of their Holy Wars.</li>
	<li>The Watch is (semi) permanent.  Once you have taken the black, there is (almost) no going back.  To leave the watch, you must request your dismissal/retirement through the Council (right now, by using ModMail on the Subreddit).</li>
	<li>You join the watch reborn.  Release any old grudges you have.  Once you have joined the watch, your past crimes are forgiven.</li>
	<li>The Watch does not take revenge.  Kill-On-Sight is Restricted for those that have comitted atrocious crimes against the watch, or will attack you upon seeing you.  It is not for people who have murdered you but are otherwise friendly.</li>
	<li>You are accountable for your actions.  If you seem to be killing a large number of players and acting like a bandit, the Council will hold you responsible and you may be found guilty of desertion.  Such a finding would have you placed on the Watch's KoS list.</li>
</ul>

<p>Please fill out the following credentials, and take the vow of the Night's Watch:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	)
))?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<div class="row">
		<?php echo $form->labelEx($model,'ign'); ?>
		<?php echo $form->textField($model,'ign'); ?>
		<?php echo $form->error($model,'ign'); ?>
		<p class="note">
			Please remember, your Minecraft username is cAsE sEnSiTiVe.
		</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="note">
			This does <strong>not</strong> have to be the same as your Minecraft password, and will be one-way encrypted.
		</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password2'); ?>
		<?php echo $form->passwordField($model,'password2'); ?>
		<?php echo $form->error($model,'password2'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',array(NULL => '', User::TYPE_RANGER => 'Ranger',User::TYPE_MAESTER => 'Maester')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
	
	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
	
	<div class="row buttons">
		<button style="text-align:justify;font-style:italic;padding:10px;">Night gathers, and now my watch begins. It shall not end until my banishment. I shall take no mate, hold no lands, render no children. I shall wear no crowns and win no glory. I shall live and die at my post. I am the sword in the darkness. I am the watcher on the walls. I am the fire that burns against the cold, the light that brings the dawn, the horn that wakes the sleepers, the shield that guards the realms of men. I pledge my life and honor to the Night's Watch, for this night and all nights to come.</button>
	</div>
	
<?php $this->endWidget(); ?>
</div>