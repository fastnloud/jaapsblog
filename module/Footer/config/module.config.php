<?php

namespace Footer;

return array(
    'service_manager' => array(
        'factories' => array(
            'FooterService' => 'Footer\Service\FooterFactory'
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
                'label' => array(
                    'required' => true,
                    'allow_empty' => true
                ),
                'href' => array(
                    'required' => true,
                    'allow_empty' => true
                ),
                'priority' => array(
                    'required' => true
                ),
                'footer_column' => array(
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
                'site' => array(
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'EntityValidatorRecordExists',
                            'options' => array(
                                'repository' => 'Site\Entity\Site',
                                'field'      => 'id'
                            )
                        ),
                    ),
                )
            ),
        ),
    ),
);