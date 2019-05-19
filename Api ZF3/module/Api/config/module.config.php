<?php

namespace Api;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
		'routes' => [
			'api' => [
				'type' => \Zend\Router\Http\Segment::class,
				'options' => [
					'route' => '/api[/:action]',
					'contraints' => [
						'action' => '*[a-zA-Z][a-zA-Z0-9_-]*'
					],
					'defaults' => [
						'controller' => Controller\ApiController::class,
						'action' => 'index'
					]
				]
			]
		]
	],
	'controllers' => [
		'factories' => [
			Controller\ApiController::class => InvokableFactory::class
		]
	],
	'view_manager' => [
		'template_path_stack' => [
			'api' => __DIR__ . '/../view'
		]
	]
];
