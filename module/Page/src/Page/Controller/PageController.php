<?php

namespace Page\Controller;

use Page\Service\Page as PageService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class PageController
 * @package Page\Controller
 */
class PageController extends AbstractActionController
{

    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * Index.
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
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

}