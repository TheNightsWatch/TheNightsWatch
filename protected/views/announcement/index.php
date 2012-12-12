<?php if(count($models)): ?>
<ul>
	<?php foreach($models as $model): ?>
	<li><a
		href="<?php echo $this->createUrl('announcement/view',array('id' => $model->id)); ?>"><?php echo CHtml::encode($model->subject); ?>
	</a></li>
	<?php endforeach; ?>
</ul>
<?php else: ?>
<p>There are no announcements.</p>
<?php endif; ?>