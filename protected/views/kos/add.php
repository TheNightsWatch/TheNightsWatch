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
		<p class="note">
			<strong>We support markdown!</strong><br /> What does this mean? It
			means you can use safe bits of HTML and <a
				href="http://daringfireball.net/projects/markdown/syntax">markdown
				syntax</a> within your reason and proof.<br /> <br /> To include an
			image in your proof, please use the code ![](http://imgur.com/image).
			To make a link <a href="http://google.com/">like this</a>, simply
			type [like this](http://google.com). That's all it takes!
		</p>
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
