<?php

namespace Blog;

use Blog\Controller\BlogController;
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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'BlogService' => 'Blog\Service\BlogFactory'
            )
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Blog\Controller\Blog' => function(ControllerManager $cm) {
                    $controller = new BlogController();
                    $controller->setBlogService($cm->getServiceLocator()->get('BlogService'));

                    return $controller;
                }
            )
        );
    }

}