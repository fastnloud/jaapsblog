<?php

namespace Admin\Factory\Controller;

use Admin\Controller\AdminController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AdminControllerFactory
 * @package Admin\Factory\Controller
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

        $controller = new AdminController($config);

        return $controller;
    }

}