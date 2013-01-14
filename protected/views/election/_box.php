<?php $model = ElectionForm::fromElection($election); ?>
<div class="electionBox" data-votedFor="<?= $model->candidate ? $model->candidate->user->id : null ?>">
	<?php 
	$form = $this->beginWidget('CActiveForm',array(
		'id'=>'vote-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	));
	?>
	<input type="hidden" name="ajax" value="1" />
	<div class="electionHeader">
		<?= htmlspecialchars($election->title) ?>
	</div>
	<div class="electionImage" <?php if($model->getElection()->winnerCount > 1): ?>style="display:none;"<?php endif; ?>>
		<div
			style="width: 100px; height: 100px; display: inline-block; position: relative;">
			<img src="<?= $model->candidate ? $model->candidate->user->headUrl(100) : 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=='; ?>"
				style="position: absolute; top: 0px; left: 0px;" />
			<div title="You have voted for this person!"
				style="position: absolute; bottom: 0px; right: 0px; font-size: 50px; font-weight: bold; color: green;<?= $model->candidate ? null : 'display:none;'?>">✓</div>
		</div>
	</div>
	<div class="electionSubmit">
	    <?php 
	        $htmlOptions = array();
	        if($model->getElection()->winnerCount > 1) $htmlOptions['multiple'] = 'multiple';
	        $htmlOptions['data-selectAmt'] = $model->getElection()->winnerCount;
	    ?>
		<?php echo $form->hiddenField($model,'electionID',array('value' => $model->electionID)); ?>
		<?php echo $form->dropDownList($model,'candidateID',$model->getCandidateDropdownArray(),$htmlOptions) ?>
		<?php if($model->getElection()->winnerCount > 1): ?><br /><br />Please select <?= $model->getElection()->winnerCount ?><br /><br /><?php endif; ?>
		<?php echo CHtml::submitButton('Vote'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
