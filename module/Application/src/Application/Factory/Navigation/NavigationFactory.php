<?php

namespace Application\Factory\Navigation;

use Application\Navigation\Navigation;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class NavigationFactory
 * @package Application\Factory\Navigation
 */
class NavigationFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Zend\Navigation\Navigation
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new Navigation();

        return $navigation->createService($serviceLocator);
    }

}