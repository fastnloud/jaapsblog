<?php

namespace Blog;

return array(
    'service_manager' => array(
        'factories' => array(
            'BlogService' => 'Blog\Service\BlogFactory'
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Blog\Controller\Blog' => 'Blog\Controller\BlogControllerFactory'
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
                                'include'    => 'site_id',
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
                'type' => 'segment',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'index',
                        'slug'       => 'blog'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'item' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/[:item].html',
                            'constraints' => array(
                                'item' => '[a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                'action' => 'blog-item',
                            ),
                        ),
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