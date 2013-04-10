<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Blog\Model\Page;

class PageController extends AbstractActionController
{  
    protected $pageTable;

    public function indexAction()
    {
        $index = $this->getPageTable()->getPages();
        $data  = array();

        if ($index->count() > 0) {
            foreach ($index as $entry) {
                $data[] = $entry;
            }
        }
        return new JsonModel(array(
            'data' => $data
        ));
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $params = $this->params()->fromPost();

            if(isset($params['data'])) {
                $data = json_decode($params['data'], true);

                if (isset($data['id'])) {
                    $page = new Page();
                    $page->exchangeArray($data);

                    $form = new \Zend\Form\Form();
                    $form->bind($page);

                    if ($form->isValid()) {
                        $this->getPageTable()->save($page);
                        $success = true;
                    };
                }
            }
        }

        return new JsonModel(array(
            'success' => (isset($success) ? true : false)
        ));
    }

    public function deleteAction()
    {
        if ($this->request->isPost()) {
            $params = $this->params()->fromPost();

            if(isset($params['data'])) {
                $data = json_decode($params['data'], true);

                if (isset($data['id']) && !empty($data['id'])) {
                    $this->getPageTable()->deletePage((int)$data['id']);
                    $success = true;
                }
            }
        }

        return new JsonModel(array(
            'success' => (isset($success) ? true : false)
        ));
    }

    protected function getPageTable()
    {
        if (!$this->pageTable) {
            $sm = $this->getServiceLocator();
            $this->pageTable = $sm->get('Page\Model\PageTable');
        }

        return $this->pageTable;
    }

}
