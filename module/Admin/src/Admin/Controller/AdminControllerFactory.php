<?php

namespace Admin\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AdminControllerFactory
 * @package Admin\Controller
 */
class AdminControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AdminController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->getServiceLocator()
                                 ->get('Config');

        $controller = new AdminController($config['admin']['tables']);

        return $controller;
    }

}