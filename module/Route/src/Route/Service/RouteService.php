<?php

namespace Route\Service;

use Application\Service\AbstractEntityService;

/**
 * Class RouteService
 * @package Route\Service
 */
class RouteService extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Route\Entity\Route')
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
                    ->getRepository('Route\Entity\Route')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

}