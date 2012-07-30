<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/framework/yiic.php';
$config=require dirname(__FILE__).'/config/console.php';
if(file_exists(dirname(__FILE__).'/config/local.php'))
{
    $local=require dirname(__FILE__).'/config/local.php';
    if(!isset($config['components'])) $config['components'] = array();
    $config['components']['db'] = $local['components']['db'];
}

require_once($yiic);
