<?php

namespace Page;

use Page\Controller\PageController;
use Zend\Mvc\Controller\ControllerManager;

/**
 * Class Module
 * @package Page
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
                'Page\Controller\Page' => function(ControllerManager $cm) {
                    $controller = new PageController();
                    $controller->setPageService($cm->getServiceLocator()->get('PageService'));

                    return $controller;
                }
            )
        );
    }

}