<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message as Mail;
use Zend\Mail\Transport as Transport;

use Blog\Model\Reply;
use Blog\Form\ReplyForm;

class BlogController extends AbstractActionController
{
    protected $blogTable;

    protected $replyTable;

    /**
     * Fetch blog content.
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        // make sure no title is set
        if ($this->params('title')) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        return new ViewModel(array(
            'q'     => $this->request->getQuery('q'),
            'index' => $this->getBlogTable()->getIndex($this->request->getQuery('q'))
        ));
    }

    /**
     * View blog item, with all content.
     */
    public function viewAction()
    {
        // A few preperations.
        $sm   = $this->getEvent()->getApplication()->getServiceManager();
        $uri  = $this->getRequest()->getUri();

        // Fetch View helpers needed to check the URL.
        $urlHelper        = $sm->get('viewhelpermanager')->get('Url');
        $urlStringHelper  = $sm->get('viewhelpermanager')->get('UrlString');

        // Fetch ID from URL.
        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        // Get blog item.
        $blog = $this->getBlogTable()->getBlogItem($id);
        if (false === $blog) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        // Fetch the current path.
        $path = $uri->getPath();

        // And build the actual path.
        $params = array('action' => 'view', 'id' => $id, 'title' => $urlStringHelper($blog->title));
        $realPath = $urlHelper('blog', $params);

        // So if "path" differs from "real path" do redirect.
        if ($path != $realPath) {
            $this->redirect()->toUrl($realPath);
            $this->response->setStatusCode(301);
        }

        // reply form
        $form = $this->getReplyForm($params);

        return new ViewModel(array(
            'blog' => $blog,
            'form' => $form
        ));
    }

    /**
     * Fetch Reply forms.
     *
     * @param $params Route params for redirecting
     * @return \Blog\Form\ReplyForm
     */
    protected function getReplyForm($params)
    {
        // model
        $reply = new Reply();

        // actual form
        $form  = new ReplyForm();

        // bind model
        $form->bind($reply);

        // handle form request
        if ($this->getRequest()->isPost()) {
            $form->setInputFilter($reply->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            // validate
            if ($form->isValid()) {
                // fetch id from route
                $reply->id_blog = $this->params()->fromRoute('id');

                // save
                $this->getReplyTable()->save($reply);

                // send notification
                $this->notification();

                // redirect
                $this->redirect()->toRoute('blog', $params);
            } else {
                // override form messages and replace with attribute
                foreach ($form->getElements() as $element) {
                    if ($element->getMessages()) {
                        $element->setMessages(array());
                        $element->setAttribute('class', trim($element->getAttribute('class'). ' error'));
                    }
                }
            }
        }

        return $form;
    }

    /**
     * Notification e-mail.
     *
     * @return void
     */
    protected function notification()
    {
        // fetch config
        $config = $this->getServiceLocator()->get('Config');

        // fetch uri
        $uri = $this->getRequest()->getUri();

        // build body message
        $body =  'Reply on: ' . $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();

        // build the mail itself
        $mail = new Mail();
        $mail->setBody($body);
        $mail->setFrom('noreply@jaapsblog.nl', 'Jaapsblog.nl');
        $mail->addTo($config['email'][0]);
        $mail->setSubject('Notification');

        // only for development
        if ('development' == getenv('application_env')) {
            $options = new Transport\SmtpOptions();
            $options->setHost('smtp.ziggo.nl');

            $transport = new Transport\Smtp($options);
        } else {
            $transport = new Transport\Sendmail();
        }

        // send
        $transport->send($mail);
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
