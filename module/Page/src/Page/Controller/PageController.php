<?php

namespace Page\Controller;

use Doctrine\ORM\NoResultException;
use Page\Service\Page as PageService;
use Zend\Http\Response;
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
     * Homepage.
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        return $this->forward()->dispatch('Page\Controller\Page',
            array(
                'action' => 'page',
                'slug'   => $this->params()->fromRoute('slug')
            )
        );
    }

    /**
     * Page.
     *
     * @return ViewModel
     */
    public function pageAction()
    {
        try {
            $page = $this->getPageService()
                         ->fetchPageBySlug($this->params()->fromRoute('slug'));
        } catch (NoResultException $e) {
            $this->getResponse()
                 ->setStatusCode(Response::STATUS_CODE_404);

            return false;
        }

        return new ViewModel(array(
            'page' => $page
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