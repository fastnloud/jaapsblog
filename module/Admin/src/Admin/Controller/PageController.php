<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Blog\Service\Page as PageService;
use Zend\View\Model\JsonModel;

class PageController extends AbstractActionController
{

    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * Get page index.
     *
     * @return array|JsonModel
     */
    public function indexAction()
    {
        return new JsonModel($this->getPageService()->getPages());
    }

    /**
     * Edit page.
     *
     * @return JsonModel
     */
    public function editAction()
    {
        return new JsonModel($this->getPageService()->save(new \Blog\Model\Page()));
    }

    /**
     * Delete page.
     *
     * @return JsonModel
     */
    public function deleteAction()
    {
        return new JsonModel($this->getPageService()->remove());
    }

    /**
     * @param \Blog\Service\Page $pageService
     */
    public function setPageService(PageService $pageService)
    {
        $this->pageService = $pageService->setReturnType('JsonArray');
    }

    /**
     * @return \Blog\Service\Page
     */
    protected function getPageService()
    {
        return $this->pageService;
    }

}
