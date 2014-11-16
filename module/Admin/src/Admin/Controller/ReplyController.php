<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Reply\Service\Reply as ReplyService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ReplyController extends AbstractActionController
{

    /**
     * @var ReplyService
     */
    protected $replyService;

    /**
     * Read.
     *
     * @return array|JsonModel
     */
    public function readAction()
    {
        $data = $this->getReplyService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getReplies();

        return new JsonModel(array(
            'data' => $data
        ));
    }

    /**
     * @param \Reply\Service\Reply $replyService
     */
    public function setReplyService(ReplyService $replyService)
    {
        $this->replyService = $replyService;
    }

    /**
     * @return \Reply\Service\Reply
     */
    protected function getReplyService()
    {
        return $this->replyService;
    }

}