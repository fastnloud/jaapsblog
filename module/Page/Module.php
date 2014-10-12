<?php

namespace Page;

use Page\Controller\PageController;

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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'PageService' => 'Page\Service\PageFactory'
            )
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Page\Controller\Page' => function($sm) {
                    $controller = new PageController();
                    $controller->setPageService($sm->getServiceLocator()->get('PageService'));

                    return $controller;
                }
            )
        );
    }

}