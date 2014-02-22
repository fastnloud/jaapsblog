<?php

namespace Blog\Controller;

use Blog\Service\Page as PageService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PageController extends AbstractActionController
{

    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * Page (view) action.
     *
     * @return bool|ViewModel
     */
    public function pageAction()
    {
        $page = $this->getPageService()->getPageByUrlString($this->params()->fromRoute('page'));

        if (!$page) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        return new ViewModel(array(
            'page' => $page
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

}
