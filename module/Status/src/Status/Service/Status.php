<?php

namespace Status\Service;

use Application\Service\AbstractService;

class Status extends AbstractService
{

    public function getStatus()
    {
        return $this->getEntityManager()
                    ->getRepository('Status\Entity\Status')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getStatus();
    }

}