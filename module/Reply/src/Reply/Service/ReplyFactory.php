<?php

namespace Reply\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ReplyFactory
 * @package Reply\Service
 */
class ReplyFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Reply
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $category = new Reply($serviceLocator);

        return $category;
    }

}