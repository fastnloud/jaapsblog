<?php

namespace Blog;

use Blog\Controller\BlogController;
use Zend\Mvc\Controller\ControllerManager;

/**
 * Class Module
 * @package Blog
 */
class Module
{

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Blog\Controller\Blog' => function(ControllerManager $cm) {
                    $controller = new BlogController();
                    $controller->setBlogService($cm->getServiceLocator()->get('BlogService'));
                    $controller->setPageService($cm->getServiceLocator()->get('PageService'));

                    return $controller;
                }
            )
        );
    }

}