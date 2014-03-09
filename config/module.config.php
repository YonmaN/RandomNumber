<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'RandomNumber-1_8' => 'RandomNumber\WebAPIController',
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
				__DIR__ . '/../views',
		),
	),
	'webapi_routes' => array(
		'randomNumber' => array(
			'type'	=> 'Zend\Mvc\Router\Http\Literal',
			'options' => array(
				'route'	=> '/Api/randomNumber',
				'defaults' => array(
					'controller' => 'RandomNumber',
					'action'	 => 'randomNumber',
					'versions'	 => array('1.8'),
					'skipauth'	=> true,
					'bootstrap' => false,
				),
			),
		),
	),
);