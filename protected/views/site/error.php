<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo isset($code) ? $code : null; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>