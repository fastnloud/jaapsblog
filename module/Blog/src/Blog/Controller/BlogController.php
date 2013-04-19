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

    public function indexAction()
    {
        return new ViewModel(array(
            'q'     => $this->request->getQuery('q'),
            'index' => $this->getBlogTable()->getIndex($this->request->getQuery('q'))
        ));
    }

    public function viewAction()
    {
        // page id
        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        // fetch blog item from db
        $blog = $this->getBlogTable()->getBlogItem($id);

        // search navigation container for entries
        $post = $this->getEvent()
              ->getApplication()->getServiceManager()->get('Navigation')
              ->findOneBy('id_blog_post', $id);

        if ($post) { // so we can compare the path
            $path  = $this->getRequest()->getUri()->getPath();
            $realPath = $post->getHref();
        } else { // 404 if not in container
            $this->getResponse()->setStatusCode(404);

            return false;
        }

        // redirect if needed
        if ($path != $realPath) {
            $this->redirect()->toUrl($realPath);
            $this->response->setStatusCode(301);
        }

        // reply form
        $form = $this->getReplyForm($realPath);

        return new ViewModel(array(
            'blog' => $blog,
            'form' => $form
        ));
    }

    protected function getReplyForm($path)
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
                $this->redirect()->toUrl($path);
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
