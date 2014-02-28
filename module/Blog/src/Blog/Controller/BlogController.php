<?php

namespace Blog\Controller;

use Blog\Service\Page as PageService;
use Blog\Service\Blog as BlogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
     * Render blog index.
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $page = $this->getPageService()->getPageByUrlString('blog');

        if (!$page) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        return new ViewModel(array(
            'q'     => $this->params()->fromQuery('q'),
            'page'  => $page,
            'index' => $this->getBlogService()->getItems($this->params()->fromQuery('q'))
        ));
    }

    /**
     * View a single blog item.
     *
     * @return bool|ViewModel
     */
    public function viewAction()
    {
        $page = $this->getPageService()->getPageByUrlString('blog');
        $item = $this->getBlogService()->getItem($this->params()->fromRoute('id'));

        if (!$item || !$page) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $uri = $this->getBlogService()->validateUri($item);

        if (!$uri) {
            $this->getResponse()->setStatusCode(404);
            return false;
        } elseif (true !== $uri) {
            $this->redirect()->toUrl($uri);
            $this->getResponse()->setStatusCode(301);
            return false;
        }

        if ($this->getRequest()->isPost()) {
            $this->getBlogService()->reply($item);
        }

        return new ViewModel(array(
            'page' => $page,
            'blog' => $item,
            'form' => $this->getBlogService()->getReplyForm()
        ));
    }

    /**
     * @param \Blog\Service\Page $pageService
     */
    public function setPageService(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @return \Blog\Service\Page
     */
    protected function getPageService()
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
