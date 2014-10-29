<?php

namespace Admin;

use Admin\Controller\PageController;
use Admin\Controller\StatusController;
use Zend\Mvc\Controller\ControllerManager;

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
                'Admin\Controller\Page' => function(ControllerManager $cm) {
                    $controller = new PageController();
                    $controller->setPageService($cm->getServiceLocator()->get('PageService'));

                    return $controller;
                },
                'Admin\Controller\Status' => function(ControllerManager $cm) {
                    $controller = new StatusController();
                    $controller->setStatusService($cm->getServiceLocator()->get('StatusService'));

                    return $controller;
                }
            )
        );
    }

}