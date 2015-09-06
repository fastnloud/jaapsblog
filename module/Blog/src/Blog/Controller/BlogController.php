<?php

namespace Blog\Controller;

use Doctrine\ORM\NoResultException;
use Page\Service\PageService;
use Blog\Service\BlogService;
use Route\Entity\Route;
use Site\Service\SiteService;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class BlogController
 * @package Blog\Controller
 */
class BlogController extends AbstractActionController
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
     * Blog index.
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        try {
            $site = $this->getSiteService()
                         ->getSite();

            $page = $this->getPageService()
                         ->fetchPageByRoute('blog', $site);
        } catch (NoResultException $e) {
            $this->getResponse()
                 ->setStatusCode(Response::STATUS_CODE_404);

            return false;
        }

        $blogItems = $this->getBlogService()
                          ->fetchBlogItems($site);

        return new ViewModel(array(
            'page'      => $page,
            'blogItems' => $blogItems
        ));
    }

    /**
     * Blog item.
     *
     * @return ViewModel
     */
    public function blogItemAction()
    {
        try {
            $site = $this->getSiteService()
                         ->getSite();

            $page = $this->getPageService()
                         ->fetchPageByRoute('blog', $site);

            $blogItem = $this->getBlogService()
                             ->fetchBlogItemBySlug($this->params()->fromRoute('item'), $site);
        } catch (NoResultException $e) {
            $this->getResponse()
                 ->setStatusCode(Response::STATUS_CODE_404);

            return false;
        }

        return new ViewModel(array(
            'page'     => $page,
            'blogItem' => $blogItem
        ));
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
    protected  function getPageService()
    {
        return $this->pageService;
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