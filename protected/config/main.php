<?php
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'The Night\'s Watch',
    'preload'=>array('log'),
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),
    'modules'=>array(),
    'components'=>array(
        'user'=>array(
            'allowAutoLogin'=>true,
        ),
         'urlManager'=>array(
             'urlFormat'=>'path',
             'showScriptName' => false,
             'rules'=>array(
                 '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                 '<controller:\w+>/<id:\d+>/<action:\w+>'=>'<controller>/<action>',
                 '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
             ),
         ),
        'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
            ),
        ),
    ),
    'params'=>array(
        'adminEmail'=>'me+thenightswatch@navarr.me',
    ),
);