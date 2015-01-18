<?php

namespace Reply;

return array(
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
                'name' => array(
                    'required' => true,
                    'allow_empty' => true
                ),
                'comment' => array(
                    'required' => true,
                    'allow_empty' => true
                ),
                'timestamp' => array(
                    'required' => true
                ),
                'is_admin' => array(
                    'required' => true
                ),
                'blog' => array(
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'EntityValidatorRecordExists',
                            'options' => array(
                                'repository' => 'Blog\Entity\Blog',
                                'field'      => 'id'
                            )
                        ),
                    ),
                )
            ),
        ),
    ),
);