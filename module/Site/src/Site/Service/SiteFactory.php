<?php

namespace Site\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SiteFactory
 * @package Site\Service
 */
class SiteFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Site
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Site($serviceLocator);
        $service->setRequest($serviceLocator->get('Request'));

        return $service;
    }

}