<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Blog\Form\PageForm;

class PageController extends AbstractActionController
{
    protected $pageTable;
    
    /**
     * Simply render the page (if found). It'll be fetched by
     * URL string.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function pageAction()
    {
        // As we're not using the "home" param here; redirect it.
        if (isset($params['page']) && 'home' == $params['page']) {
            $this->redirect()->toRoute('home');
        }

        $page = $this->getPageTable()->getPageByUrlString($this->getUrlString(false));
        if (false === $page) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        // Return page.
        return new ViewModel(array(
            'page' => $page
        ));
    }
    
    /**
     * Edit a page, that's all.
     * 
     * @return multitype:\page\Form\PageForm
     */
    public function editAction()
    {
        $page = $this->getPageTable()->getPageByUrlString($this->getUrlString(false));
        
        $form = new PageForm();
        $form->bind($page);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($page->getInputFilter());
            $form->setData($request->getPost());
        
            if ($form->isValid()) {
                $this->getPageTable()->save($page);

                return $this->redirect()->toRoute('page', array('page' => $this->getUrlString(true)));
            }
        }
        
        return new ViewModel(array(
            'page' => $page,
            'form' => $form
        ));
    }

    /**
     * Fetch the URL string, with or without its suffix.
     *
     * @param bool $suffix
     * @return mixed
     */
    protected function getUrlString($suffix)
    {
        // fetch helper
        $sm = $this->getEvent()->getApplication()->getServiceManager();
        $urlStringHelper = $sm->get('viewhelpermanager')->get('UrlString');

        return $urlStringHelper($this->params()->fromRoute('page', 'home'), $suffix);
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
