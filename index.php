<?php

// If a development environment
if(getenv('APPLICATION_ENV') == 'development')
{
	// remove the following lines when in production mode
	defined('YII_DEBUG') or define('YII_DEBUG',true);

	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}

$yii=dirname(__FILE__).'/protected/framework/yii.php';
require_once($yii);

$defaults = require dirname(__FILE__).'/protected/config/main.php';
$local = require dirname(__FILE__).'/protected/config/local.php';
if(empty($local))
    die('Please run protected/yiic setup');

$config = CMap::mergeArray($defaults,$local);
unset($defaults,$local);

Yii::createWebApplication($config)->run();