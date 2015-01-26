<?php

namespace Footer\Service;

use Application\Entity\AbstractEntityService;

/**
 * Class Footer
 * @package Footer\Service
 */
class Footer extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Footer\Entity\Footer')
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
                    ->getRepository('Footer\Entity\Footer')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

}