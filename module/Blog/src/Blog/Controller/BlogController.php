<?php

namespace Blog\Controller;

use Blog\Service\Blog as BlogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{

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
        return new ViewModel(array(
            'q'     => $this->params()->fromQuery('q'),
            'index' => $this->getBlogService()->getIndex($this->params()->fromQuery('q'))
        ));
    }

    /**
     * View a single blog item.
     *
     * @return bool|ViewModel
     */
    public function viewAction()
    {
        $item = $this->getBlogService()->getItem($this->params()->fromRoute('id'));

        if (!$item) {
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
            'blog' => $item,
            'form' => $this->getBlogService()->getReplyForm()
        ));
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
