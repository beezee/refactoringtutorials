<?php

$env = require_once(dirname(__FILE__).'/../../rftenv.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Refactoring Tutorials',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
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
	),

	// application components
	'components'=>array(
		'request' => array(
                    'baseUrl' => $env['baseUrl'],
                    'enableCsrfValidation' => true,
                    'enableCookieValidation' => true,
                    'csrfTokenName' => 'islegit',
                ),
		'user'=>array(
			'allowAutoLogin'=>true,
                        'autoUpdateFlash' => false,
		),
                'session' => array(
                    'autoStart' => true,
                    'savePath' => '/tmp',
                    'cookieMode' => 'allow',
                    'cookieParams' => array(
                        'path' => '/',
                        //'domain' => $cookieDomain,
                        'httpOnly' => false,
                    ),
                ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'urlSuffix' => '/',
                        'showScriptName' => false,
                        'useStrictParsing' => true,
			'rules'=> array(
                            '' => 'site/index',
                            'refactoring/<refactoringSlug:[^\/]+>/step/<stepNumber:[\d]+?>'
                                => 'refactoring/step',
                            'refactoring/<refactoringSlug:[^\/]+>' => 'refactoring/index',
                        ),
		),
		//'db'=>array(
		//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);