<?php 
$this->setPageTitle($model->subject);
?>
<style>
    #content
    {
background: -moz-linear-gradient(left,  rgba(255,255,255,0) 10%, rgba(255,255,255,0.79) 25%, rgba(255,255,255,1) 29%, rgba(255,255,255,1) 71%, rgba(255,255,255,0.79) 75%, rgba(255,255,255,0) 90%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(10%,rgba(255,255,255,0)), color-stop(25%,rgba(255,255,255,0.79)), color-stop(29%,rgba(255,255,255,1)), color-stop(71%,rgba(255,255,255,1)), color-stop(75%,rgba(255,255,255,0.79)), color-stop(90%,rgba(255,255,255,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left,  rgba(255,255,255,0) 10%,rgba(255,255,255,0.79) 25%,rgba(255,255,255,1) 29%,rgba(255,255,255,1) 71%,rgba(255,255,255,0.79) 75%,rgba(255,255,255,0) 90%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left,  rgba(255,255,255,0) 10%,rgba(255,255,255,0.79) 25%,rgba(255,255,255,1) 29%,rgba(255,255,255,1) 71%,rgba(255,255,255,0.79) 75%,rgba(255,255,255,0) 90%); /* Opera 11.10+ */
background: -ms-linear-gradient(left,  rgba(255,255,255,0) 10%,rgba(255,255,255,0.79) 25%,rgba(255,255,255,1) 29%,rgba(255,255,255,1) 71%,rgba(255,255,255,0.79) 75%,rgba(255,255,255,0) 90%); /* IE10+ */
background: linear-gradient(to right,  rgba(255,255,255,0) 10%,rgba(255,255,255,0.79) 25%,rgba(255,255,255,1) 29%,rgba(255,255,255,1) 71%,rgba(255,255,255,0.79) 75%,rgba(255,255,255,0) 90%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#00ffffff',GradientType=1 ); /* IE6-9 */
     
    }
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
