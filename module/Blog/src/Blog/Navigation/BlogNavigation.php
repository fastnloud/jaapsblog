<?php
namespace Blog\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class BlogNavigation extends DefaultNavigationFactory
{
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = $config['navigation'][$this->getName()] = array();

        if (null === $this->pages) {
            $pages  = $serviceLocator->get('Page\Model\PageTable')->getPages();

            if ($pages) {
                foreach ($pages as $key => $page) {
                    $visible = true;

                    if (true !== AUTHENTICATED && 'offline' == $page->status) {
                        continue;
                    } elseif ('online' != $page->status) {
                        $visible = false;
                    }

                    $navigation[$key] = array (
                        'url_string'=> $page->url_string, // unique
                        'visible'   => $visible,
                        'label'     => $page->label,
                        'route'     => $page->route
                    );

                    if ('page' == $page->route) {
                        $navigation[$key]['params'] = array(
                            'page' => $this->urlString($page->url_string)
                        );
                    }

                    if ('blog' == $page->route) {
                        $blogPosts = $serviceLocator->get('Blog\Model\BlogTable')->getIndex();

                        if ($blogPosts) {
                            $navigation[$key]['pages'] = array();

                            foreach ($blogPosts as $post) {
                                $navigation[$key]['pages'][] = array(
                                    'id_blog_post' => $post->id, // unique
                                    'label'        => $post->title,
                                    'date'         => $post->date,
                                    'route'        => 'blog_post',
                                    'params'       => array(
                                        'action' => 'view',
                                        'id' => $post->id,
                                        'title' => $this->urlString($post->title)
                                    )
                                );
                            }
                        }
                    }
                }

                $navigation[] = array(
                    'id'    => 'btn-search',
                    'label' => 'Search',
                    'uri'   => '#'
                );
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