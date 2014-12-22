<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Reply\Service\Reply as ReplyService;
use Zend\View\Model\JsonModel;

class ReplyController extends AbstractAdminController
{

    /**
     * @var ReplyService
     */
    protected $replyService;

    /**
     * Read.
     *
     * @return JsonModel
     */
    public function readAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        $data = $this->getReplyService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getReplies();

        return new JsonModel(array(
            'data' => $data
        ));
    }

    /**
     * Create.
     *
     * @return JsonModel
     */
    public function createAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if ($jsonObject) {
            $entity = $this->getReplyService()
                           ->mergeEntityWithJsonObject(new \Reply\Entity\Reply(), $jsonObject);

            if ($this->getReplyService()->validateEntity($entity)) {
                $success = $this->getReplyService()
                                ->saveEntity($entity);
            }
        }

        return new JsonModel(array(
            'success' => $success
        ));
    }

    /**
     * Update.
     *
     * @return JsonModel
     */
    public function updateAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        $success    = false;
        $jsonObject = json_decode($this->params()->fromPost('data'));

        if (isset($jsonObject->id)) {
            $reply = $this->getReplyService()
                          ->getReply($jsonObject->id);

            if ($reply) {
                $entity = $this->getReplyService()
                               ->mergeEntityWithJsonObject($reply, $jsonObject);

                if ($this->getReplyService()->validateEntity($entity)) {
                    $success = $this->getReplyService()
                                    ->saveEntity($entity, true);
                }
            }
        }

        return new JsonModel(array(
            'success' => $success
        ));
    }

    /**
     * Destroy.
     *
     * @return JsonModel
     */
    public function destroyAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->authFailed();
        }

        $success              = false;;
        $jsonObject           = json_decode($this->params()->fromPost('data'));
        $jsonObjectCollection = array();

        if (isset($jsonObject->id)) {
            $jsonObjectCollection[] = $jsonObject;
        } elseif (is_array($jsonObject)) {
            $jsonObjectCollection = $jsonObject;
        }

        if (!empty($jsonObjectCollection)) {
            foreach ($jsonObjectCollection as $jsonObject) {
                if (isset($jsonObject->id)) {
                    $entity  = $this->getReplyService()
                                    ->getReply($jsonObject->id);

                    if ($entity) {
                        $this->getReplyService()
                             ->deleteEntity($entity);
                    }

                    $success = true;
                }
            }
        }

        return new JsonModel(array(
            'success' => $success
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