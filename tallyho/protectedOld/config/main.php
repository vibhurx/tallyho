<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Tallyho',
	// preloading 'log' component
	'preload'=>array('log'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.contact.models.*',
		'application.modules.organization.models.*',
		'application.modules.match.models.*',
		'application.modules.participant.models.*',
		'application.modules.payment.models.*',
		'application.modules.player.models.*',
		'application.modules.tour.models.*',
		'application.modules.tour.modules.category.models.*',
		'application.modules.user.models.*',
		'application.modules.developer.models.*',
	),

	'modules'=>array(
		'captcha' => array(
			'registration' => false,
			'user' => false,
		),
		'contact',
		'developer',
		'match',
		'membership',
		'organization',
		'participant',
		'payment',
		'player',
		'registration',
		'tour' => array(
			'modules' => array('category')),
		'user',
				
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			// If removed, Gii defaults to localhost only. Edit carefully to test.
			//'ipFilters'=>array('127.0.0.1','::1'),
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
	
		'common' => array(
			'class' => 'application.components.Common'),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=tally64g_tallyho',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset'  => 'utf8',
			'tablePrefix' => ''),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error'),
		
		'import'=>array(
			'application.modules.user.models.*'),
		
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
		
 		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		), 
		
		'user'=>array(
      		'class' => 'application.modules.user.components.YumWebUser',
      		'allowAutoLogin'=>true,
      		'loginUrl' => array('//user/login'),
 		),
		
	), //end components

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'admin@tallyho.in',
	),
);