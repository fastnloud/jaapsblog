<?php
namespace Blog\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class BlogNavigation extends DefaultNavigationFactory
{
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            $pages  = $serviceLocator->get('Page\Model\PageTable')->getPages();
            $config['navigation']['default'] = array();

            if ($pages) {
                foreach ($pages as $key => $page) {
                    $visible = true;

                    if (true !== AUTHENTICATED && 'offline' == $page->status) {
                        continue;
                    } elseif ('online' != $page->status) {
                        $visible = false;
                    }

                    $config['navigation']['default'][$key] = array (
                        'url_string'=> $page->url_string, // unique
                        'visible'   => $visible,
                        'label'     => $page->label,
                        'route'     => $page->route
                    );

                    if ('page' == $page->route) {
                        $config['navigation']['default'][$key]['params'] = array(
                            'page' => $this->urlString($page->url_string)
                        );
                    }

                    if ('blog' == $page->route) {
                        $blogPosts = $serviceLocator->get('Blog\Model\BlogTable')->getIndex();

                        if ($blogPosts) {
                            $config['navigation']['default'][$key]['pages'] = array();
                            foreach ($blogPosts as $post) {
                                $config['navigation']['default'][$key]['pages'][] = array(
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

                $config['navigation']['default'][] = array(
                    'id'    => 'btn-search',
                    'label' => 'Search',
                    'uri'   => '#'
                );
            }

            $application = $serviceLocator->get('Application');
            $routeMatch  = $application->getMvcEvent()->getRouteMatch();
            $router      = $application->getMvcEvent()->getRouter();
            $pages       = $this->getPagesFromConfig($config['navigation'][$this->getName()]);

            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }

        return $this->pages;
    }

    protected function urlString($string)
    {
        $urlString = strtolower($string);
        $urlString = preg_replace('/[^a-z0-9]+/i', '-', $urlString);
        $urlString = preg_replace('/-$/', '', $urlString);

        // return without suffix and strip if needed
        return (preg_match('/.html$/i', $urlString) ? substr($urlString,0,-5) : $urlString);
    }
}