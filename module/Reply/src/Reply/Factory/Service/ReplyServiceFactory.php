<?php

namespace Reply\Factory\Service;

use Reply\Service\ReplyService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ReplyServiceFactory
 * @package Reply\Factory\Service
 */
class ReplyServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ReplyService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new ReplyService($serviceLocator);

        return $service;
    }

}