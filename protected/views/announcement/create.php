<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
	    'action' => array('announcement/preview'),
	    'id' => 'announcement-form',
	    'enableClientValidation'=>true,
	    'clientOptions'=>array(
	        'validateOnSubmit'=>true,
	    ),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject'); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body'); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Preview'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
