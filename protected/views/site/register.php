<?php
$this->setPageTitle('Register');
$this->breadcrumbs=array(
    'Register',
);
?>

<h1>Register</h1>

<p>
	<strong>Important Things to remember before joining the watch:</strong>
</p>
<ul>
	<li>The Watch does not take part in the politics of the realm. By
		joining the watch, you must forget the politcs of any churches you
		belonged to. You may keep the religion, but stay out of their Holy
		Wars.</li>
	<li>The Watch is (semi) permanent. Once you have taken the black, there
		is (almost) no going back. To leave the watch, you must request your
		dismissal/retirement through the Council (right now, by using ModMail
		on the Subreddit).</li>
	<li>You join the watch reborn. Release any old grudges you have. Once
		you have joined the watch, your past crimes are forgiven.</li>
	<li>The Watch does not take revenge. Kill-On-Sight is Restricted for
		those that have comitted atrocious crimes against the watch, or will
		attack you upon seeing you. It is not for people who have murdered you
		but are otherwise friendly.</li>
	<li>You are accountable for your actions. If you seem to be killing a
		large number of players and acting like a bandit, the Council will
		hold you responsible and you may be found guilty of desertion. Such a
		finding would have you placed on the Watch's KoS list.</li>
</ul>

<p>Please fill out the following credentials, and take the vow of the
	Night's Watch:</p>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
	    'id'=>'register-form',
	    'enableClientValidation'=>true,
	    'clientOptions'=>array(
	        'validateOnSubmit'=>true,
	    )
))?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<div class="row">
		<?php echo $form->labelEx($model,'ign'); ?>
		<?php echo $form->textField($model,'ign'); ?>
		<?php echo $form->error($model,'ign'); ?>
		<p class="note">Please remember, your Minecraft username is cAsE
			sEnSiTiVe.</p>
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
			This does <strong>not</strong> have to be the same as your Minecraft
			password, and will be one-way encrypted.
		</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password2'); ?>
		<?php echo $form->passwordField($model,'password2'); ?>
		<?php echo $form->error($model,'password2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',array(NULL => '', User::TYPE_RANGER => 'Ranger - I want to kill the undead',User::TYPE_MAESTER => 'Maester - I want to heal the living and support the Rangers')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
	<p class="note">
	
	
	<blockquote>
		<strong>Rules of the Watch:</strong>
		<blockquote>
			<ol>
				<li>You may not kill any player unprovoked. Read the <a
					href="<?php echo $this->createUrl('site/rules'); ?>">rules of engagement</a>
					to understand what we consider "provocation"
				</li>
				<li>You may not steal from players - If you commit to a trade you
					must follow through with it.</li>
				<li>You may not share information on our website with non-Night's
					Watch players - For announcements, only link them. If they can't
					see them, then they're not supposed to.</li>
				<li>You may not leave the watch without a request to do so signed by
					the Lord Commander</li>
			</ol>
		</blockquote>
		<p>
			Doing any of the above may warrant your immediate placement as a
			deserter. Particularly heinous offenses may lead to members of the
			Watch hunting you down. The Watch is supposed to be a great big happy
			family. And you know what they say - <q><strong><em>You do not anger
						the family.</em> </strong> </q>
		</p>
		<p>Clicking the button belows means that you've taken our Oath, and
			are bound to these rules. For additional brownie points, say it out
			loud.</p>
	</blockquote>
	</p>
	<div class="row buttons">
		<button
			style="text-align: justify; font-style: italic; padding: 10px;">Night
			gathers, and now my watch begins. It shall not end until my
			banishment. I shall take no mate, hold no lands, render no children.
			I shall wear no crowns and win no glory. I shall live and die at my
			post. I am the sword in the darkness. I am the watcher on the walls.
			I am the fire that burns against the cold, the light that brings the
			dawn, the horn that wakes the sleepers, the shield that guards the
			realms of men. I pledge my life and honor to the Night's Watch, for
			this night and all nights to come.</button>
	</div>

	<?php $this->endWidget(); ?>
</div>
