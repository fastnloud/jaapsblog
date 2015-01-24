<?php

namespace Category\Service;

use Application\Entity\AbstractEntityService;

/**
 * Class Category
 * @package Category\Service
 */
class Category extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Category\Entity\Category')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntities();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function fetchEntity($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Category\Entity\Category')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity();
    }

}