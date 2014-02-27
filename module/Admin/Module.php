<?php

namespace Admin;

use Admin\Controller\BlogController;
use Admin\Controller\PageController;
use Blog\Model\BlogTable;
use Blog\Model\ReplyTable;
use Blog\Model\PageTable;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Admin\Controller\Page' => function($sm) {
                    $controller = new PageController();
                    $controller->setPageService($sm->getServiceLocator()->get('PageService'));

                    return $controller;
                },
                'Admin\Controller\Blog' => function($sm) {
                    $controller = new BlogController();
                    $controller->setBlogService($sm->getServiceLocator()->get('BlogService'));

                    return $controller;
                }
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Blog\Model\BlogTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table     = new BlogTable($dbAdapter);
                    
                    return $table;
                },
                'Blog\Model\ReplyTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table     = new ReplyTable($dbAdapter);

                    return $table;
                },
                'Page\Model\PageTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table     = new PageTable($dbAdapter);
                
                    return $table;
                }
            )
        );
    }

}