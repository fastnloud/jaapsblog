<?php

namespace Page\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class PageControllerFactory
 * @package Page\Controller
 */
class PageControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return PageController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller = new PageController();
        $controller->setPageService($serviceLocator->getServiceLocator()->get('PageService'));

        return $controller;
    }

}