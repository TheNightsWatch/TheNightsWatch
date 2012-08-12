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
		<?php echo $form->labelEx($model,'profession'); ?>
		<?php echo $form->dropDownList($model,'profession',array(NULL => '', User::TYPE_RANGER => 'Ranger - I want to kill the undead',User::TYPE_MAESTER => 'Maester - I want to heal the living and support the Rangers')); ?>
		<?php echo $form->error($model,'profession'); ?>
	</div>
	
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
