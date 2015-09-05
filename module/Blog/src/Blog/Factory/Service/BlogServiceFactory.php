<?php

namespace Blog\Factory\Service;

use Blog\Service\BlogService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BlogServiceFactory
 * @package Blog\Factory\Service
 */
class BlogServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlogService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new BlogService($serviceLocator);

        return $service;
    }

}