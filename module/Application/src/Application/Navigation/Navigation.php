<?php

namespace Application\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

/**
 * Class Navigation
 * @package Application\Navigation
 */
class Navigation extends DefaultNavigationFactory
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array|mixed
     */
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            $pages = $serviceLocator->get('Page\Service\PageService')
                                    ->fetchEntities();

            if ($pages) {
                foreach ($pages as $key => $page) {
                    $route = $page->getRoute()->getLabel();

                    $navigation[$key] = array (
                        'page_id'   => $page->getId(),
                        'visible'   => $page->getIsVisible(),
                        'label'     => ('home' === $route ? null : $page->getLabel()),
                        'class'     => ('home' === $route ? 'fa fa-home' : null),
                        'route'     => $route
                    );

                    if ('page' === $route) {
                        $navigation[$key]['params'] = array(
                            'slug' => $page->getSlug()
                        );
                    }

                    if ('blog' == $route) {
                        $blogItems = $serviceLocator->get('Blog\Service\BlogService')
                                                    ->fetchEntities();

                        if ($blogItems) {
                            foreach ($blogItems as $blogItem) {
                                $navigation[$key]['pages'][] = array(
                                    'blog_id' => $blogItem->getId(),
                                    'label'   => $blogItem->getTitle(),
                                    'route'   => $route . '/item',
                                    'params'  => array(
                                        'item' => $blogItem->getSlug()
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

            // set pages
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }

        return $this->pages;
    }

}