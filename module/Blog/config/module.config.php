<?php

namespace Blog;

return array(
    'service_manager' => array(
        'factories' => array(
            'BlogService' => 'Blog\Service\BlogFactory'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'forms' => array(
        __NAMESPACE__ . '\Entity\\' . __NAMESPACE__ => array(
            'input_filter' => array(
                'title' => array(
                    'required' => true
                ),
                'subtitle' => array(
                    'required' => true
                ),
                'author' => array(
                    'required' => true
                ),
                'date' => array(
                    'required' => true
                ),
                'status' => array(
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'EntityValidatorRecordExists',
                            'options' => array(
                                'repository' => 'Status\Entity\Status',
                                'field'      => 'id'
                            )
                        ),
                    ),
                ),
                'slug' => array(
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name' => 'EntityValidatorNoRecordExists',
                            'options' => array(
                                'repository' => __NAMESPACE__ . '\Entity\\' . __NAMESPACE__,
                                'field'      => 'slug',
                                'exclude'    => 'id'
                            )
                        ),
                    ),
                ),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'index'
                    ),
                ),
            )
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);