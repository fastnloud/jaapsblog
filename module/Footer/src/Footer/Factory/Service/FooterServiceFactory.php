<?php

namespace Footer\Factory\Service;

use Footer\Service\FooterService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FooterServiceFactory
 * @package Footer\Factory\Service
 */
class FooterServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FooterService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new FooterService($serviceLocator);

        return $service;
    }

}