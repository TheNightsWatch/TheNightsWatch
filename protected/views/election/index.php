<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<div style="text-align: center;">
	<?php
	if($elections) foreach($elections as $election) $this->renderPartial('_box',array('election' => $election));
	?>
</div>
<script>
	var electionHeadImageTpl = '<?= $this->createUrl('user/head',array('unique' => 'NAME','size' => 100)); ?>';
	var blankGif = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
	$('.electionBox').on('change','.electionSubmit select',function(e)
	{
		var newSrc;
		var box = $(this).closest('.electionBox');
		
		if($(this).val() > 0)
			newSrc = electionHeadImageTpl.replace('NAME',$(this).text());
		else
			newSrc = blankGif;
		
		box.find('.electionImage img').attr('src',newSrc);
		
		if($(this).val() && $(this).val() == box.attr('data-votedFor'))
			box.find('.electionImage div div').show();
		else
			box.find('.electionImage div div').hide();
	});
	$('.electionBox').on('submit','form',function(e)
	{
		e.preventDefault();
		var form = $(this);
		var action = form.attr('action');
		var id = $(this).find('select').val();
		if(!id)
		{
			alert("Listen...\nYou can't vote for nobody.\nSo either vote for somebody, or don't vote at all.");
			return;
		}

		$.ajax(action,{
			type: form.attr('method'),
			data: form.serialize(),
			dataType: 'json',
			success: function(data,textStatus,jqXHR)
			{
				if(!data.success)
				{
					alert('There was an error submitting your vote.  Please try again.');
					return;
				}
				var box = form.closest('.electionBox');
				box.attr('data-votedFor',id);
				if(box.find('select').val() == id)
					box.find('.electionImage div div').show();
			}
		});
	});
</script>
<style>
.electionBox {
	text-align: left;
	width: 200px;
	display: inline-block;
	margin: 5px;
	border: 1px solid black;
	padding-bottom: 10px;
}

.electionHeader {
	padding: 5px;
	font-weight: bold;
	border-bottom: 1px solid black;
}

.electionImage {
	text-align: center;
	padding: 10px;
}

.electionSubmit {
	text-align: center;
}

.electionSubmit select {
	width: 75%;
	text-align: left;
}

.electionSubmit input {
	width: 75px;
}
</style>
