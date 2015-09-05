<?php

namespace Blog\Factory\Controller;

use Blog\Controller\BlogController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BlogControllerFactory
 * @package Blog\Factory\Controller
 */
class BlogControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlogController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller = new BlogController();
        $controller->setBlogService($serviceLocator->getServiceLocator()->get('Blog\Service\BlogService'));
        $controller->setPageService($serviceLocator->getServiceLocator()->get('Page\Service\PageService'));

        return $controller;
    }

}