<?php

namespace Blog\Service;

use Blog\Model\BlogTable;
use Blog\Model\Blog as BlogModel;
use Blog\Model\ReplyTable;
use Blog\Model\Reply as ReplyModel;
use Blog\Form\ReplyForm;
use Blog\Mail\SmtpOptions;
use Dkim\Signer\Signer as DkimSigner;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Navigation\Navigation;

class Blog extends Service
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Navigation
     */
    protected $navigation;

    /**
     * @var SmtpOptions
     */
    protected $smtpOptions;

    /**
     * @var DkimSigner
     */
    protected $dkimSigner;

    /**
     * @var BlogTable
     */
    protected $blogTable;

    /**
     * @var ReplyTable
     */
    protected $replyTable;

    /**
     * @var ReplyForm
     */
    protected $replyForm;

    /**
     * Fetch multiple Blog items.
     *
     * @param null $query
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getItems($query = null)
    {
        $result = $this->getBlogTable()->fetchAll($query);

        if ('JsonArray' == $this->getReturnType()) {
            return $this->returnAsJsonArray($result);
        }

        return $result;
    }

    /**
     * Fetch multiple Blog items.
     *
     * @param null $query
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getReplies()
    {
        return $this->returnAsJsonArray($this->getReplyTable()->fetchAll());
    }

    /**
     * Fetch a single Blog item.
     *
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        $item = $this->getBlogTable()->fetch($id);

        return $item;
    }


    /**
     * Edit page (validating POST data).
     *
     * @return array
     */
    public function save($model)
    {
        $data = $this->encodeAndValidateJsonData($model);

        if (false !== $data) {
            $result = (bool) $this->getBlogTable()->save($data);
        }

        return $this->returnAsJsonArray(isset($result) ? $result : false);
    }

    /**
     * Delete page (validating POST data).
     *
     * @return array
     */
    public function remove()
    {
        $data = $this->encodeAndValidateJsonData();

        if (false !== $data) {
            $result = (bool) $this->getBlogTable()->remove($data['id']);
        }

        return $this->returnAsJsonArray(isset($result) ? $result : false);
    }




    /**
     * Edit page (validating POST data).
     *
     * @return array
     */
    public function saveReply($model)
    {
        $data = $this->encodeAndValidateJsonData($model);

        if (false !== $data) {
            $result = (bool) $this->getReplyTable()->save($data);
        }

        return $this->returnAsJsonArray(isset($result) ? $result : false);
    }

    /**
     * Delete page (validating POST data).
     *
     * @return array
     */
    public function removeReply()
    {
        $data = $this->encodeAndValidateJsonData();

        if (false !== $data) {
            $result = (bool) $this->getReplyTable()->remove($data['id']);
        }

        return $this->returnAsJsonArray(isset($result) ? $result : false);
    }

    /**
     * Reply to a blog item (if input valid).
     *
     * @param BlogModel $item
     */
    public function reply(BlogModel $item)
    {
        $form   = $this->getReplyForm();
        $config = $this->getConfig();
        $model  = new ReplyModel();

        $form->bind($model);
        $form->setInputFilter($model->getInputFilter());
        $form->setData($this->getRequest()->getPost());

        if ($form->isValid()) {
            $model->id_blog = $item->id;
            $this->getReplyTable()->save($model);

            if (isset($config['reply_form']) && !empty($config['reply_form']['send_notification_to'])) {
                $this->notify($item);
            }
        }
    }

    /**
     * Sends out a notificaiton e-mail about the given
     * blog item.
     *
     * @param BlogModel $item
     */
    protected function notify(BlogModel $item)
    {
        $config  = $this->getConfig();
        $uriPath = $this->getUriPath($item);

        if (false !== $uriPath) {
            $body = 'reply on: '
                  . $this->getRequest()->getUri()->getScheme()
                  . '://' . $this->getRequest()->getUri()->getHost()
                  . $uriPath;

            // the message
            $message = new Message();
            $message->setBody($body);
            $message->setFrom($config['mail']['from']);
            $message->addTo($config['reply_form']['send_notification_to']);
            $message->setSubject('notification');

            // sign message with dkim
            $signer = $this->getDkimSigner();
            $signer->signMessage($message);

            $transport = new Smtp();
            $transport->setOptions($this->getSmtpOptions());

            // send
            $transport->send($message);
        }

    }

    /**
     * Get UriPath (path after the domain).
     *
     * @param BlogModel $item
     * @return bool|string
     */
    public function getUriPath(BlogModel $item)
    {
        $itemInNavigation = $this->getNavigation()->findOneBy('id_blog_post', $item->id);

        if ($itemInNavigation) {
            return $itemInNavigation->getHref();
        }

        return false;
    }

    /**
     * Validate the UriPath with the RequestUriPath so if needed
     * it can be re-directed.
     *
     * @param BlogModel $item
     * @return bool|string
     */
    public function validateUri(BlogModel $item)
    {
        $uriPath = $this->getUriPath($item);
        $requestUriPath   = $this->getRequest()->getUri()->getPath();

        if (!$uriPath) {
            return false;
        }

        if ($uriPath != $requestUriPath) {
            return $uriPath;
        }

        return true;
    }

    /**
     * @param \Zend\Navigation\Navigation $navigation
     */
    public function setNavigation(Navigation $navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * @return \Zend\Navigation\Navigation
     */
    protected function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * @param \Blog\Model\BlogTable $blogTable
     */
    public function setBlogTable(BlogTable $blogTable)
    {
        $this->blogTable = $blogTable;
    }

    /**
     * @return \Blog\Model\BlogTable
     */
    protected function getBlogTable()
    {
        return $this->blogTable;
    }

    /**
     * @param \Blog\Model\ReplyTable $replyTable
     */
    public function setReplyTable(ReplyTable $replyTable)
    {
        $this->replyTable = $replyTable;
    }

    /**
     * @return \Blog\Model\ReplyTable
     */
    protected function getReplyTable()
    {
        return $this->replyTable;
    }

    /**
     * @param \Blog\Form\ReplyForm $replyForm
     */
    public function setReplyForm(ReplyForm $replyForm)
    {
        $this->replyForm = $replyForm;
    }

    /**
     * @return \Blog\Form\ReplyForm
     */
    public function getReplyForm()
    {
        return $this->replyForm;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \Blog\Mail\SmtpOptions $smtpOptions
     */
    public function setSmtpOptions(SmtpOptions $smtpOptions)
    {
        $this->smtpOptions = $smtpOptions;
    }

    /**
     * @return \Blog\Mail\SmtpOptions
     */
    protected function getSmtpOptions()
    {
        return $this->smtpOptions;
    }

    /**
     * @param \Dkim\Signer\Signer $dkimSigner
     */
    public function setDkimSigner(DkimSigner $dkimSigner)
    {
        $this->dkimSigner = $dkimSigner;
    }

    /**
     * @return \Dkim\Signer\Signer
     */
    protected function getDkimSigner()
    {
        return $this->dkimSigner;
    }

}