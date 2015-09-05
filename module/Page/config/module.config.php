<?php

namespace Page;

return array(
    'service_manager' => array(
        'factories' => array(
            'Page\Service\PageService' => 'Page\Factory\Service\PageServiceFactory'
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Page\Controller\PageController' => 'Page\Factory\Controller\PageControllerFactory'
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
                'label' => array(
                    'required' => true
                ),
                'priority' => array(
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
                'route' => array(
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'EntityValidatorRecordExists',
                            'options' => array(
                                'repository' => 'Route\Entity\Route',
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
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Page\Controller\PageController',
                        'slug'       => 'home',
                        'action'     => 'index'
                    ),
                ),
            ),
            'page' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/[:slug].html',
                    'constraints' => array(
                        'slug'   => '[a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Page\Controller\PageController',
                        'action'     => 'page'
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