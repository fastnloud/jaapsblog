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
        $site = new Site($serviceLocator);

        return $site;
    }

}