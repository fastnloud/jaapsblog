<?php

namespace Application\Navigation;

use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

/**
 * Class Navigation
 * @package Application\Navigation
 */
class Navigation extends DefaultNavigationFactory
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array|mixed
     */
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        $this->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        if (null === $this->pages) {
            $pages = $this->getEntityManager()
                          ->getRepository('Page\Entity\Page')
                          ->fetchPages();

            if ($pages) {
                foreach ($pages as $key => $page) {
                    $route = $page->getRoute()->getLabel();

                    $navigation[$key] = array (
                        'page_id'   => $page->getId(),
                        'visible'   => $page->getIsVisible(),
                        'label'     => $page->getLabel(),
                        'route'     => $route,
                        'params'    => array(
                            'slug' => $page->getSlug()
                        )
                    );

                    if ('blog' == $route) {
                        $blogItems = $this->getEntityManager()
                                          ->getRepository('Blog\Entity\Blog')
                                          ->fetchBlogItems();

                        if ($blogItems) {
                            foreach ($blogItems as $blogItem) {
                                $navigation[$key]['pages'][] = array(
                                    'blog_id' => $blogItem->getId(),
                                    'label'   => $blogItem->getTitle(),
                                    'route'   => $route,
                                    'params'  => array(
                                        'slug' => $blogItem->getSlug()
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
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    protected function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

}