<?php

namespace Page\Service;

use Application\Service\AbstractService;

class Page extends AbstractService
{

    public function getPages()
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getPages();
    }

    public function getAllPages()
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getPages(true);
    }

}