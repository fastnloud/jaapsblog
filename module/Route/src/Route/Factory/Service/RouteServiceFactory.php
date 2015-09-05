<?php

namespace Route\Factory\Service;

use Route\Service\RouteService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RouteServiceFactory
 * @package Route\Factory\Service
 */
class RouteServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return RouteService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new RouteService($serviceLocator);

        return $service;
    }

}