<?php

namespace Status\Factory\Service;

use Status\Service\StatusService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class StatusServiceFactory
 * @package Status\Factory\Service
 */
class StatusServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return StatusService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new StatusService($serviceLocator);

        return $service;
    }

}