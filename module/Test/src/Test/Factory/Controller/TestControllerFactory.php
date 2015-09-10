<?php

namespace Test\Factory\Controller;

use Test\Controller\TestController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TestControllerFactory
 * @package Test\Factory\Controller
 */
class TestControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return TestController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller = new TestController();
        $controller->setTestForm($serviceLocator->getServiceLocator()->get('FormElementManager')
                   ->get('Test\Form\TestForm'));

        return $controller;
    }

}