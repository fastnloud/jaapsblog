<?php

namespace Blog\Controller;

use Blog\Service\Blog as BlogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class BlogController
 * @package Blog\Controller
 */
class BlogController extends AbstractActionController
{

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
        return new ViewModel();
    }

    /**
     * Blog item.
     *
     * @return ViewModel
     */
    public function blogItemAction()
    {
        return new ViewModel();
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