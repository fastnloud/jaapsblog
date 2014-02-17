<?php

namespace Blog;

use Blog\Model\BlogTable;
use Blog\Model\ReplyTable;
use Blog\Model\PageTable;
use Blog\View\Helper\Date;
use Blog\View\Helper\Cookies;
use Blog\View\Helper\Analytics;
use Blog\View\Helper\SocialMedia;
use Blog\View\Helper\BlogPosts;
use Blog\View\Helper\Replies;

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
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'date' => function() {
                    return new Date();
                },
                'blogPosts' => function() {
                    return new BlogPosts();
                },
                'cookies' => function($sm) {
                    $cookies = new Cookies();
                    $cookies->setRequest($sm->getServiceLocator()->get('Request'));
                    $cookies->setResponse($sm->getServiceLocator()->get('Response'));

                    return $cookies;
                },
                'analytics' => function($sm) {
                    $analytics = new Analytics();
                    $analytics->setRequest($sm->getServiceLocator()->get('Request'));

                    return $analytics;
                },
                'socialMedia' => function($sm) {
                    $socialMedia = new SocialMedia();
                    $socialMedia->setRequest($sm->getServiceLocator()->get('Request'));

                    return $socialMedia;
                },
                'replies' => function($sm) {
                    $replies = new Replies();
                    $replies->setReplyTable($sm->getServiceLocator()->get('Blog\Model\ReplyTable'));

                    return $replies;
                }
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Navigation' => 'Blog\Navigation\NavigationFactory',
                'Blog\Model\BlogTable' =>  function($sm) {
                    return new BlogTable($sm->get('Zend\Db\Adapter\Adapter'));
                },
                'Blog\Model\ReplyTable' =>  function($sm) {
                    return new ReplyTable($sm->get('Zend\Db\Adapter\Adapter'));
                },
                'Page\Model\PageTable' =>  function($sm) {
                    return new PageTable($sm->get('Zend\Db\Adapter\Adapter'));
                }
            )
        );
    }
}