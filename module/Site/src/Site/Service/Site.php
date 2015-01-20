<?php

namespace Site\Service;

use Application\Entity\AbstractEntityService;

class Site extends AbstractEntityService
{

    public function getSites()
    {
        return $this->getEntityManager()
                    ->getRepository('Site\Entity\Site')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getSites();
    }

    public function getSite($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Site\Entity\Site')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getSite($id);
    }

}