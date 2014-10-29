<?php

namespace Page\Service;

use Application\Entity\AbstractEntityService;

class Page extends AbstractEntityService
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

    public function getPage($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getPage($id);
    }

}