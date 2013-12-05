<?php

namespace Blog;

use Blog\Model\BlogTable;
use Blog\Model\ReplyTable;
use Blog\Model\PageTable;
use Blog\Service\Amazon as AmazonService;
use Blog\View\Helper\Amazon;
use Blog\View\Helper\Date;
use Blog\View\Helper\Cookies;
use Blog\View\Helper\Analytics;
use Blog\View\Helper\LatestReplies;
use Blog\View\Helper\SocialMedia;
use Blog\View\Helper\LatestBlogPosts;
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
                'latestBlogPosts' => function() {
                    return new LatestBlogPosts();
                },
                'latestReplies' => function($sm) {
                    $locator = $sm->getServiceLocator();

                    $helper = new LatestReplies();
                    $helper->setReplyTable($locator->get('Blog\Model\ReplyTable'));

                    return $helper;
                },
                'cookies' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    return new Cookies($locator->get('Request'), $locator->get('Response'));
                },
                'analytics' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    return new Analytics($locator->get('Request'));
                },
                'socialMedia' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    return new SocialMedia($locator->get('Request'));
                },
                'replies' => function($sm) {
                    return new Replies($sm);
                },
                'amazon' => function($sm) {
                    return new Amazon($sm);
                }
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Navigation' => 'Blog\Navigation\BlogNavigationFactory',
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
            ),
            'services' => array(
                'Amazon' => new AmazonService()
            )
        );
    }
}