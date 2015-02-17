<?php

namespace Blog\Controller;

use Doctrine\ORM\NoResultException;
use Page\Service\Page as PageService;
use Blog\Service\Blog as BlogService;
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
     * Blog index.
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        try {
            $page = $this->getPageService()
                         ->fetchPageBySlug($this->params()->fromRoute('slug'));
        } catch (NoResultException $e) {
            $this->getResponse()
                 ->setStatusCode(Response::STATUS_CODE_404);

            return false;
        }

        $blogItems = $this->getBlogService()
                          ->fetchBlogItems();

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
            $page = $this->getPageService()
                         ->fetchPageBySlug($this->params()->fromRoute('slug'));

            $blogItem = $this->getBlogService()
                             ->fetchBlogItemBySlug($this->params()->fromRoute('item'));
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
     * @param \Page\Service\Page $pageService
     */
    public function setPageService(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @return \Page\Service\Page
     */
    protected  function getPageService()
    {
        return $this->pageService;
    }

    /**
     * @param \Blog\Service\Blog $blogService
     */
    public function setBlogService(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * @return \Blog\Service\Blog
     */
    protected function getBlogService()
    {
        return $this->blogService;
    }

}