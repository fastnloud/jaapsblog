<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Page\Service\Page as PageService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class PageController extends AbstractActionController
{

    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * Index.
     *
     * @return array|JsonModel
     */
    public function indexAction()
    {
        $data = $this->getPageService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getAllPages();

        return new JsonModel(array(
            'data' => $data
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

}