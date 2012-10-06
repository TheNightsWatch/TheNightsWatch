<?php
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'The Night\'s Watch',
	'preload'=>array('log'),
	'import'=>array(
		'application.forms.*',
		'application.models.*',
		'application.components.*',
		'application.vendors.*',
		'application.filters.*',
	    'application.extensions.yii-mail.*',
	),
	'modules'=>array(),
	'components'=>array(
	    'mail' => array(
	        'class' => 'YiiMail',
        ),
		'request'=>array(
		    'class' => 'HttpRequest',
		    'noCsrfValidationRoutes' => array(
		        'map/update',
		        'user/cape',
	        ),
			'enableCsrfValidation' => true,
			'enableCookieValidation' => true,
		),
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				// Specific Routes
				'' => 'site/index',
				'chat' => 'chat/index',
				'login' => 'site/login',
				'register' => 'site/register',
				'logout' => 'site/logout',
			    'profile' => 'site/profile',
			    'mods' => 'site/mods',
			    'rules' => 'site/rules',
			    'minecraft.jar' => 'site/modDownload',
			    'resetPassword' => 'site/forgot',
			    
			    // Map Downloader
                'map/MineZ/<path:.+>' => 'map/download',
			    
				// Other Routes
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<id:\d+>/<action:\w+>'=>'<controller>/<action>',
				
				// Cape Route
                array('user/cape','pattern' => 'cape/<unique:.+>.png', 'verb' => 'GET, POST'),
			    array('user/capeHead','pattern' => 'cape/<unique:.+>.png', 'verb' => 'HEAD'),

				// User Specific
				'user' => 'user/index',
				'user/<unique:\w+>'=>'user/view',
				'user/<unique:\w+>/<action:\w+>'=>'user/<action>',
			    
			    'kos' => 'kos/index',
			    'kos/add' => 'kos/add',
			    'kos/<unique:\w+>'=>'kos/view',

				// Controller/Action
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<unique\w+>/<action:\w+>'=>'<controller>/<action>',
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
