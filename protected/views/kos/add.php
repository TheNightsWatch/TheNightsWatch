<?php $this->setPageTitle('File a KOS Request'); ?>
<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
	    'action' => array('kos/add'),
	    'id' => 'kos-add-form',
	    'enableClientValidation'=>true,
	    'clientOptions'=>array(
	        'validateOnSubmit' => true,
	    ),
    )); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ign'); ?>
		<?php echo $form->textField($model,'ign'); ?>
		<?php echo $form->error($model,'ign'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'server'); ?>
		<?php echo $form->textField($model,'server'); ?>
		<?php echo $form->error($model,'server'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'report'); ?>
		<?php echo $form->textArea($model,'report'); ?>
		<?php echo $form->error($model,'report'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'proof'); ?>
		<?php echo $form->textArea($model,'proof'); ?>
		<?php echo $form->error($model,'proof'); ?>
		<p class="note">
			It is very important to provide proof along with your accusations.
			Listings without proof will almost NEVER be approved. Please upload
			any images of the situation you have to an <a
				href="http://imgur.com/">imgur gallery</a> and post it's link here
		</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save Report'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
