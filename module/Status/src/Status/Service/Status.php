<?php

namespace Status\Service;

use Application\Entity\AbstractEntityService;

class Status extends AbstractEntityService
{

    public function getStatus()
    {
        return $this->getEntityManager()
                    ->getRepository('Status\Entity\Status')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getStatus();
    }

}