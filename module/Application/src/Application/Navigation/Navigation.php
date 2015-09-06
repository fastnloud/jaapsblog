<?php

namespace Application\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;
use Page\Service\PageService;
use Blog\Service\BlogService;
use Site\Service\SiteService;

/**
 * Class Navigation
 * @package Application\Navigation
 */
class Navigation extends DefaultNavigationFactory
{

    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * @var BlogService
     */
    protected $blogService;

    /**
     * @var SiteService
     */
    protected $siteService;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array|mixed
     */
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        $site = $this->getSiteService()
                     ->getSite();

        if (null === $this->pages) {
            $pages = $this->getPageService()
                          ->fetchPages($site);

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
                        $blogItems = $this->getBlogService()
                                          ->fetchBlogItems($site);

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

    /**
     * @param \Blog\Service\BlogService $blogService
     */
    public function setBlogService(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * @return \Blog\Service\BlogService
     */
    protected function getBlogService()
    {
        return $this->blogService;
    }

    /**
     * @param \Page\Service\PageService $pageService
     */
    public function setPageService(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @return \Page\Service\PageService
     */
    protected function getPageService()
    {
        return $this->pageService;
    }

    /**
     * @param \Site\Service\SiteService $siteService
     */
    public function setSiteService(SiteService $siteService)
    {
        $this->siteService = $siteService;
    }

    /**
     * @return \Site\Service\SiteService
     */
    protected function getSiteService()
    {
        return $this->siteService;
    }

}