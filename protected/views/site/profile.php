<?php 
$this->setPageTitle('Edit Profile');
$this->breadcrumbs = array(
    'Edit Profile',
);
?>

<h1>Edit Profile</h1>

<?php if(Yii::app()->user->hasFlash('profile')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('profile'); ?>
</div>

<?php endif; ?>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
	    'id' => 'profile-form',
	    'enableClientValidation' => true,
	    'clientOptions'=>array(
	        'validateOnSubmit' => true,
	    )
    ))?>
	<div class="row">
		<?php echo $form->labelEx($model,'reddit'); ?>
		<?php echo $form->textField($model,'reddit'); ?>
		<?php echo $form->error($model,'reddit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'skype'); ?>
		<?php echo $form->textField($model,'skype'); ?>
		<?php echo $form->error($model,'skype'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save Profile'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
