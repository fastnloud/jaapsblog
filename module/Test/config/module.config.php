<?php

return array(
    'controllers' => array(
        'factories' => array(
            'Test\Controller\TestController' => 'Test\Factory\Controller\TestControllerFactory'
        )
    ),
    'forms' => array(
        'Test\Form\TestForm' => array(
            'type' => 'Test\Form\TestForm'
        )
    ),
    'router' => array(
        'routes' => array(
            'test' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/test',
                    'defaults' => array(
                        'controller' => 'Test\Controller\TestController',
                        'action'     => 'test'
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);