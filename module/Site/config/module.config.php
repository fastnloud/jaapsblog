<?php

namespace Site;

return array(
    'service_manager' => array(
        'factories' => array(
            'SiteService' => 'Site\Service\SiteFactory'
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
                'domain' => array(
                    'required' => true
                ),
                'email' => array(
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'Zend\Validator\EmailAddress'
                        ),
                    ),
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
                )
            ),
        ),
    ),
);