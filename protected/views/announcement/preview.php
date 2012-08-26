<?php
$this->renderPartial('view',array('model' => $model));
echo '<br />';
echo CHtml::openTag('div',array('style' => 'text-align:center;'));

$form = $this->beginWidget('CActiveForm',array(
        'htmlOptions' => array('style' => 'display:inline;'),
		'action' => array('announcement/create'),
));
echo $form->hiddenField($model,'subject');
echo $form->hiddenField($model,'body');
echo CHtml::submitButton('Edit');
$this->endWidget();

$form = $this->beginWidget('CActiveForm',array(
    'htmlOptions' => array('style' => 'display:inline;'),
    'action' => array('announcement/post'),
));
echo $form->hiddenField($model,'subject');
echo $form->hiddenField($model,'body');
echo CHtml::submitButton('Send');
$this->endWidget();

echo CHtml::closeTag('div');
