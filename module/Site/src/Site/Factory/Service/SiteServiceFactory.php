<?php

namespace Site\Factory\Service;

use Site\Service\SiteService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SiteServiceFactory
 * @package Site\Factory\Service
 */
class SiteServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SiteService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new SiteService($serviceLocator);
        $service->setRequest($serviceLocator->get('Request'));

        return $service;
    }

}