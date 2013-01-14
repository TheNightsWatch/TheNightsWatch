<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'The Night\'s Watch',
    'preload' => array('log'),
    'import' => array('application.models.*','application.components.*'),
    'components' => array(
    ),
);