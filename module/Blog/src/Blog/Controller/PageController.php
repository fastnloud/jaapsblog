<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PageController extends AbstractActionController
{

    protected $pageTable;

    public function pageAction()
    {
        $page = $this->getEvent() // find in container
              ->getApplication()->getServiceManager()->get('Navigation')
              ->findOneBy('url_string', $this->params()->fromRoute('page', 'home'));

        if (!$page) { // throw error if not found
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        if ('home' == $page->url_string) {
            $this->getServiceLocator()->get('viewhelpermanager')
                 ->get('placeholder')->createContainer('isHomepage')->set(true);
        }

        return new ViewModel(array(
            'page' => $this->getPageTable()->getPageByUrlString($page->url_string)
        ));
    }

    public function getPageTable()
    {
        if (!$this->pageTable) {
            $sm = $this->getServiceLocator();
            $this->pageTable = $sm->get('Page\Model\PageTable');
        }
    
        return $this->pageTable;
    }

}
