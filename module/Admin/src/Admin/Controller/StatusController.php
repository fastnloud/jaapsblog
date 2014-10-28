<?php

namespace Admin\Controller;

use Doctrine\ORM\Query;
use Status\Service\Status as StatusService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class StatusController extends AbstractActionController
{

    /**
     * @var StatusService
     */
    protected $statusService;

    /**
     * Index.
     *
     * @return array|JsonModel
     */
    public function indexAction()
    {
        $data = $this->getStatusService()
                     ->setQueryHydrator(Query::HYDRATE_ARRAY)
                     ->getStatus();

        return new JsonModel(array(
            'data' => $data
        ));
    }

    /**
     * @param \Status\Service\Status $statusService
     */
    public function setStatusService(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * @return \Status\Service\Status
     */
    protected function getStatusService()
    {
        return $this->statusService;
    }

}