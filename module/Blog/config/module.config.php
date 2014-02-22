<?php

return array (
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Page',
                        'action'     => 'page'
                    ),
                ),
            ),
            'page' => array(
                'type' => 'regex',
                'options' => array(
                    'regex'    => '/(?!home|blog)(?<page>[a-zA-Z0-9_-]+).html',
                    'constraints' => array(
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Page',
                        'action'     => 'page'
                    ),
                    'spec' => '/%page%.html',
                ),
            ),
            'blog' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),
            ),
            'blog_post' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/blog/[:action]/[:id]/[:title].html',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'title'  => '[a-zAZ0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),
            ),
            'xml' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/xml[/:action].xml',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Xml'
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Page' => 'Blog\Controller\PageController',
            'Blog\Controller\Xml'  => 'Blog\Controller\XmlController'
        ),
    ),
    'view_manager' => array(
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);