<?php 
$this->setPageTitle($model->subject);
?>
<style>
    #email { text-align: center; font-family: Georgia, serif; color: #222; }
    #email-body { text-align: justify; padding-top: 10px; }
    #email-body p { text-align: justify; }
    #email-date { text-align: right; }
    #email-subject,#email-date,#email-body,#email hr { margin: 0 auto; }
    #email hr { width: 450px; }
    #email-subject,#email-date,#email-body { width: 400px; }
    #email-date { font-style: italic; }
</style>
<div id="email">
	<h1 id="email-subject">
		<?php echo htmlspecialchars($model->subject); ?>
	</h1>
	<hr />
	<div id="email-date">
	    posted on <?php echo $model->timestamp->format("F j, Y"); ?>
	</div>
	<div id="email-body">
		<?php echo $model->body; ?>
	</div>
</div>
