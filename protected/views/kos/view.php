<p>
	<strong>Status:</strong>
	<em><?php echo KOS::translateStatus($kos->status); ?></em>
</p>
<?php if(count($kos->reports)): ?>
<?php $markdown = new CMarkdownParser(); ?>
<p><strong>Reports:</strong></p>
<table id="reportTable">
	<?php foreach($kos->reports as $report): ?>
	<tr>
		<td><img src="<?php echo $report->reporter->headUrl(); ?>" alt=""
			class="miniHead" /> <?php echo CHtml::encode($report->reporter->ign); ?>
		</td>
		<td><?php echo CHtml::encode($report->server); ?></td>
		<td><?php echo $report->date->format("M d, Y"); ?></td>
	</tr>
	<tr>
		<td colspan="3">
			<p>
				<strong>Report:</strong>
			</p> <?php echo $markdown->safeTransform($report->report); ?>
		</td>
	</tr>
	<?php if($report->proof): ?>
	<tr>
		<td colspan="3">
			<p>
				<strong>Proof:</strong>
			</p> <?php echo $markdown->safeTransform($report->proof); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php endforeach; ?>
</table>
<style>
#reportTable img {
	max-width: 200px;
	max-height: 200px;
}

img.miniHead {
	width: 16px;
	height: 16px;
}

#reportTable,#reportTable td {
	border: 1px solid #444;
}

#reportTable {
	border-collapse: collapse;
}
</style>
<?php endif; ?>