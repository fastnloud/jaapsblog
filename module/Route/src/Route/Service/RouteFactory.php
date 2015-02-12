<?php

namespace Route\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RouteFactory
 * @package Route\Service
 */
class RouteFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Route
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Route($serviceLocator);

        return $service;
    }

}