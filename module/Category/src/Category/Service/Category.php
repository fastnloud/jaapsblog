<?php

namespace Category\Service;

use Application\Entity\AbstractEntityService;

class Category extends AbstractEntityService
{

    public function getCategory()
    {
        return $this->getEntityManager()
                    ->getRepository('Category\Entity\Category')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getCategory();
    }

}