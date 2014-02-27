<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Blog\Service\Blog as BlogService;
use Zend\View\Model\JsonModel;

class BlogController extends AbstractActionController
{

    /**
     * @var BlogService
     */
    protected $blogService;

    /**
     * Get all blog items.
     *
     * @return JsonModel
     */
    public function indexAction()
    {
        return new JsonModel($this->getBlogService()->getItems());
    }

    /**
     * Get all replies.
     *
     * @return JsonModel
     */
    public function indexReplyAction()
    {
        return new JsonModel($this->getBlogService()->getReplies());
    }

    /**
     * Edit blog item.
     *
     * @return JsonModel
     */
    public function editAction()
    {
        return new JsonModel($this->getBlogService()->save(new \Blog\Model\Blog()));
    }

    /**
     * Edit reply.
     *
     * @return JsonModel
     */
    public function editReplyAction()
    {
        return new JsonModel($this->getBlogService()->saveReply(new \Blog\Model\Reply()));
    }

    /**
     * Delete blog item.
     *
     * @return JsonModel
     */
    public function deleteAction()
    {
        return new JsonModel($this->getBlogService()->remove());
    }

    /**
     * Delete reply.
     *
     * @return JsonModel
     */
    public function deleteReplyAction()
    {
        return new JsonModel($this->getBlogService()->removeReply());
    }

    /**
     * @param \Blog\Service\Blog $blogService
     */
    public function setBlogService(BlogService $blogService)
    {
        $this->blogService = $blogService->setReturnType('JsonArray');
    }

    /**
     * @return \Blog\Service\Blog
     */
    protected function getBlogService()
    {
        return $this->blogService;
    }
   
}
