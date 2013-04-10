<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Blog\Model\Blog;
use Blog\Model\Reply;

class BlogController extends AbstractActionController
{  
    protected $blogTable;

    protected $replyTable;

    public function indexAction()
    {
        $index = $this->getBlogTable()->getIndex();
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

    public function indexReplyAction()
    {
        $index = $this->getReplyTable()->getReplies();
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
                    $blog = new Blog();
                    $blog->exchangeArray($data);

                    $form = new \Zend\Form\Form();
                    $form->bind($blog);

                    if ($form->isValid()) {
                        $this->getBlogTable()->save($blog);
                        $success = true;
                    };
                }
            }
        }

        return new JsonModel(array(
            'success' => (isset($success) ? true : false)
        ));
    }

    public function editReplyAction()
    {
        if ($this->request->isPost()) {
            $params = $this->params()->fromPost();

            if(isset($params['data'])) {
                $data = json_decode($params['data'], true);

                if (isset($data['id'])) {
                    $blog = new Reply();
                    $blog->exchangeArray($data);

                    $form = new \Zend\Form\Form();
                    $form->bind($blog);

                    if ($form->isValid()) {
                        $this->getReplyTable()->save($blog);
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
                    $this->getBlogTable()->deleteBlogItem((int)$data['id']);
                    $success = true;
                }
            }
        }

        return new JsonModel(array(
            'success' => (isset($success) ? true : false)
        ));
    }

    public function deleteReplyAction()
    {
        if ($this->request->isPost()) {
            $params = $this->params()->fromPost();

            if(isset($params['data'])) {
                $data = json_decode($params['data'], true);

                if (isset($data['id']) && !empty($data['id'])) {
                    $this->getReplyTable()->deleteReply((int)$data['id']);
                    $success = true;
                }
            }
        }

        return new JsonModel(array(
            'success' => (isset($success) ? true : false)
        ));
    }

    protected function getBlogTable()
    {
        if (!$this->blogTable) {
            $sm = $this->getServiceLocator();
            $this->blogTable = $sm->get('Blog\Model\BlogTable');
        }

        return $this->blogTable;
    }

    protected function getReplyTable()
    {
        if (!$this->replyTable) {
            $sm = $this->getServiceLocator();
            $this->replyTable = $sm->get('Blog\Model\ReplyTable');
        }

        return $this->replyTable;
    }
   
}
