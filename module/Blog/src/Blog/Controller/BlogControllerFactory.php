<?php

namespace Blog\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BlogControllerFactory
 * @package Blog\Controller
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
        $controller->setBlogService($serviceLocator->getServiceLocator()->get('BlogService'));
        $controller->setPageService($serviceLocator->getServiceLocator()->get('PageService'));

        return $controller;
    }

}