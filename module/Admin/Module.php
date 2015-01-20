<?php

namespace Admin;

use Admin\Controller\BlogController;
use Admin\Controller\CategoryController;
use Admin\Controller\PageController;
use Admin\Controller\ReplyController;
use Admin\Controller\SiteController;
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
                'Admin\Controller\Blog' => function(ControllerManager $cm) {
                    $controller = new BlogController();
                    $controller->setBlogService($cm->getServiceLocator()->get('BlogService'));

                    return $controller;
                },
                'Admin\Controller\Site' => function(ControllerManager $cm) {
                    $controller = new SiteController();
                    $controller->setSiteService($cm->getServiceLocator()->get('SiteService'));

                    return $controller;
                },
                'Admin\Controller\Reply' => function(ControllerManager $cm) {
                    $controller = new ReplyController();
                    $controller->setReplyService($cm->getServiceLocator()->get('ReplyService'));

                    return $controller;
                },
                'Admin\Controller\Status' => function(ControllerManager $cm) {
                    $controller = new StatusController();
                    $controller->setStatusService($cm->getServiceLocator()->get('StatusService'));

                    return $controller;
                },
                'Admin\Controller\Category' => function(ControllerManager $cm) {
                    $controller = new CategoryController();
                    $controller->setCategoryService($cm->getServiceLocator()->get('CategoryService'));

                    return $controller;
                }
            )
        );
    }

}