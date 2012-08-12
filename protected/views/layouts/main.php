<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css?v=20120807v1" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php
		$ongoingElections = Election::countAllOngoing();
		$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('site/index')),
			//	array('label'=>'Chat', 'url'=>array('/chat')),
				array('label'=>'Members', 'url'=>array('user/index')),
				array('label'=>'Chat', 'url'=>array('chat/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Elections', 'url'=>array('election/index'), 'visible'=>($ongoingElections && !Yii::app()->user->isGuest)),
				array('label'=>'Election Results', 'url' => array('election/results'), 'visible' => !$ongoingElections),
				array('label'=>'Reddit', 'url'=>'http://reddit.com/r/TheNightsWatch'),
				array('label'=>'Teamspeak', 'url'=>array('site/teamspeak')),
			    array('label'=>'KOS', 'url'=>array('site/KOS'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest, 'linkOptions' => array('style' => 'float:right;position:relative;top:-4px;')),
				array('label'=>'Join', 'url'=>array('site/register'), 'visible'=>Yii::app()->user->isGuest, 'linkOptions' => array('style' => 'float:right;position:relative;top:-4px;')),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'linkOptions' => array('style' => 'float:right;position:relative;top:-4px;')),
			    array('label'=>'Profile', 'url'=>array('site/profile'), 'visible'=>!Yii::app()->user->isGuest, 'linkOptions' => array('style' => 'float:right;position:relative;top:-4px;')),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">

	</div><!-- footer -->

</div><!-- page -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2330128-19']);
  _gaq.push(['_setDomainName', 'minez-nightswatch.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
