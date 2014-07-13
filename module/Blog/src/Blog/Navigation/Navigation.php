<?php

namespace Blog\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class Navigation extends DefaultNavigationFactory
{

    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = array();

        if (null === $this->pages) {
            $pages  = $serviceLocator->get('Page\Model\PageTable')->fetchAll();

            if ($pages) {
                foreach ($pages as $key => $page) {
                    $visible = true;

                    if ('offline' == $page->getStatus()) {
                        continue;
                    } elseif ('online' != $page->getStatus()) {
                        $visible = false;
                    }

                    $navigation[$key] = array (
                        'url_string'=> $page->getUrlString(), // unique
                        'visible'   => $visible,
                        'label'     => $page->getLabel(),
                        'route'     => $page->getRoute()
                    );

                    if ('page' == $page->getRoute()) {
                        $navigation[$key]['params'] = array(
                            'page' => $this->urlString($page->getUrlString())
                        );
                    }

                    if ('blog' == $page->getRoute()) {
                        $blogPosts = $serviceLocator->get('Blog\Model\BlogTable')->fetchAll();

                        if ($blogPosts) {
                            $navigation[$key]['pages'] = array();

                            foreach ($blogPosts as $post) {
                                $navigation[$key]['pages'][] = array(
                                    'id_blog_post' => $post->getId(), // unique
                                    'label'        => $post->getTitle(),
                                    'date'         => $post->getDate(),
                                    'route'        => 'blog_post',
                                    'params'       => array(
                                        'action' => 'view',
                                        'id'     => $post->getId(),
                                        'title'  => $this->urlString($post->getTitle())
                                    )
                                );
                            }
                        }
                    }
                }
            }

            $mvcEvent = $serviceLocator->get('Application')
                      ->getMvcEvent();

            $routeMatch  = $mvcEvent->getRouteMatch();
            $router      = $mvcEvent->getRouter();
            $pages       = $this->getPagesFromConfig($navigation);

            $this->pages = $this->injectComponents(
                $pages,
                $routeMatch,
                $router
            );
        }

        return $this->pages;
    }

    protected function urlString($string)
    {
        $urlString = strtolower($string);
        $urlString = preg_replace('/[^a-z0-9]+/i', '-', $urlString);
        $urlString = preg_replace('/-$/', '', $urlString);

        return $urlString;
    }

}