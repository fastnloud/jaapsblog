<?php

namespace Admin;

use Admin\Controller\PageController;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            /*'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),*/
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Admin\Controller\Page' => function($sm) {
                    $controller = new PageController();
                    $controller->setPageService($sm->getServiceLocator()->get('PageService'));

                    return $controller;
                }
            )
        );
    }

}