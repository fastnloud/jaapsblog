<?php

namespace Page\Factory\Controller;

use Page\Controller\PageController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class PageControllerFactory
 * @package Page\Factory\Controller
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
        $controller->setPageService($serviceLocator->getServiceLocator()->get('Page\Service\PageService'));
        $controller->setSiteService($serviceLocator->getServiceLocator()->get('Site\Service\SiteService'));

        return $controller;
    }

}