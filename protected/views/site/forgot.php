<h1>Password Reset</h1>
<div class="flash-notice">
	<p>Use this form to change your password if you have forgotten it. You
		should, of course, pick a password that is easy to remember but secure
		enough to ensure that other people will not be able to guess it.</p>
	<p>If your password change is successful, you will be immediately
		logged in.</p>
</div>
<div class="form">
	<?php $form = $this->beginWidget('CActiveForm',array(
	    'id' => 'forgot-form',
	    'enableClientValidation' => true,
	    'clientOptions'=>array(
	        'validateOnSubmit' => true,
	    ),
)); ?>
	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>
	<div class="row">
		<?php echo $form->labelEx($model,'mojang'); ?>
		<?php echo $form->textField($model,'mojang'); ?>
		<?php echo $form->error($model,'mojang'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'minecraftPassword'); ?>
		<?php echo $form->passwordField($model,'minecraftPassword'); ?>
		<?php echo $form->error($model,'minecraftPassword'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'password2'); ?>
		<?php echo $form->passwordField($model,'password2'); ?>
		<?php echo $form->error($model,'password2'); ?>
	</div>
	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
