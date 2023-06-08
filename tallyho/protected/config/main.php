<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Tally-Ho',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
		'application.modules.role.models.*',
		'application.modules.profile.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
		'captcha' => array(
			'registration' => false,
			'user' => false,
		),
		'registration' => array(
			'enableActivationConfirmation' => false,
		),
		'user' => array(
			//'debug' => true,
			'userTable' => 'user',
		),
		'role' => array(
			'roleTable' => 'role',
			'userRoleTable' => 'user_role',
		),
	),

	// application components
	'components'=>array(
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
			'defaultRoles' => array('authenticated', 'admin')),
	   
		'cache' => array(
			'class' => 'system.caching.CDummyCache'),

		'User'=>array(
			'class'=>'User',
		),
	
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'application.modules.user.components.YumWebUser',
      		'allowAutoLogin'=>true,
			'loginUrl' => array('//user/user/login'),
		),

		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'mubi@brevitylabs.co.uk',
	),
);
