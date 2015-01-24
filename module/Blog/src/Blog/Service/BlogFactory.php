<?php

namespace Blog\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BlogFactory
 * @package Blog\Service
 */
class BlogFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Blog
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Blog($serviceLocator);

        return $service;
    }

}